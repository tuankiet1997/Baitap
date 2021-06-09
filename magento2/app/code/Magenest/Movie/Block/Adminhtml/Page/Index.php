<?php
namespace Magenest\Movie\Block\Adminhtml\Page;

class Index extends \Magento\Backend\Block\Template
{

    protected $_coreRegistry = null;


    protected $_customerFactory;
    protected $_productFactory;
    protected $fullModuleList;
    protected $_orderCollectionFactory;


    /**
     * Index constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Sales\Model\Order\InvoiceRepositoryFactory $invoiceRepositoryFactory,
        \Magento\Sales\Model\Order\CreditmemoRepositoryFactory $creditmemoRepositoryFactory,
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        array $data = []
    ) {
        $this->_coreRegistry         = $coreRegistry;
        $this->_customerFactory = $customerFactory;
        $this->_productFactory = $productFactory;
        $this->fullModuleList = $fullModuleList;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->invoiceRepositoryFactory = $invoiceRepositoryFactory;
        $this->creditmemoRepositoryFactory = $creditmemoRepositoryFactory;
        $this->searchCriteria = $searchCriteria;
        parent::__construct($context, $data);
    }

    public function getFilteredCustomerCollection() {
        $from = date("Y-m-d 00:00:00");
        return $this->_customerFactory->create()->getCollection()
                ->addAttributeToSelect("*")
                ->addFieldToFilter('created_at', array('from' => $from))
                ->load();
    }

    public function getFilteredProductCollection() {
        $from = date("Y-m-d 00:00:00");
        return $this->_productFactory->create()->getCollection()
                ->addAttributeToSelect("*")
                ->addAttributeToFilter("status", array("eq" => "1"))
                ->addFieldToFilter('created_at', array('from' => $from))
                ->load();
    }

    public function modulesList()
    {
        $allModules = $this->fullModuleList->getAll();
        return $allModules;
    }

    public function getOrderCollection()
    {
        $from = date("Y-m-d 00:00:00");
        $collection = $this->_orderCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('created_at', array('from' => $from));   
        return $collection;
    }

    public function getInvoiceCollection()
    {
        $from = date("Y-m-d 00:00:00");
        $this->searchCriteria->setFilterGroups();
        $invoiceRepo = $this->invoiceRepositoryFactory->create();
        $invoiceRepoCollection = $invoiceRepo->getList($this->searchCriteria);
        $invoiceRepoCollection->addFieldToFilter('created_at', array('from' => $from));
        return $invoiceRepoCollection;
    }

    public function getCreditmemosCollection()
    {
        $from = date("Y-m-d 00:00:00");
        $this->searchCriteria->setFilterGroups();
        $creditmemo = $this->creditmemoRepositoryFactory->create();
        $creditmemoCollection = $creditmemo->getList($this->searchCriteria);
        $creditmemoCollection->addFieldToFilter('created_at', array('from' => $from));
        return $creditmemoCollection;
    }
}
