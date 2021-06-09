<?php
namespace Magenest\Movie\Block\Adminhtml\Edit\Tab;
use Magento\Customer\Controller\RegistryConstants;
class TabIndex extends \Magento\Backend\Block\Template
{

    protected $_coreRegistry = null;

    protected $storeManager;

    protected $customer;


    /**
     * Index constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Customer $customer,
        array $data = []
    ) {
        $this->_coreRegistry         = $coreRegistry;
        $this->storeManager          = $storeManager;
        $this->customer              = $customer;
        parent::__construct($context, $data);
    }


    public function getcustomer(){
       $customerId = $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
       $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
       $customerData = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);
       return $customerData;
    }

     /**
     * Submit URL getter
     *
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl('magenest/director/addPost');
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }
 
    public function getMediaUrl()
    {
        return $this->getBaseUrl() . 'media/';
    }
 
    public function getCustomerImageUrl($filePath)
    {
        return $this->getMediaUrl() . 'customer' . $filePath;
    }
 
    public function getFileUrl()
    {
        $url = $this->getCustomer()->getData('avatar');
        if (!empty($url)) {
            return $this->getCustomerImageUrl($url);
        }
        return false;
    }
}