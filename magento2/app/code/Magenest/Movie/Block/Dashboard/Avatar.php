<?php
namespace Magenest\Movie\Block\Dashboard;

class Avatar extends \Magento\Backend\Block\Template
{

    protected $_coreRegistry = null;


    /**
     * @var \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory
     */
    protected $_collectionFactory;


    /**
     * Index constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_coreRegistry         = $coreRegistry;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

     /**
     * Submit URL getter
     *
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl('magenest/movie/addPost');
    }

    /**
     * get Data Director
     */
    public function getMovieData(){
        $movieData = $this->_collectionFactory->create();
        return $movieData->getData();
    }
}
