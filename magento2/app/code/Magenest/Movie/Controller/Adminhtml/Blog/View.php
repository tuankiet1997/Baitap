<?php

namespace Magenest\Movie\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Model\Session as CustomerSession;

class View extends \Magento\Backend\App\Action
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    private $resultPageFactory;

    protected $_coreRegistry = null;

    /**
     * OrderSave constructor.
     * @param Context $context
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Action\Context $context,
        CustomerSession $customerSession,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $_coreRegistry
    )
    {
        $this->customerSession = $customerSession;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $_coreRegistry;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute() 
    {
        $blogId = $this->getRequest()->getParam('id');
        var_dump($blogId);die();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $topTableData = $objectManager->create('SkyPremium\HGW\Model\Reservation')->load($topTableId);
        $resultPage = $this->resultPageFactory->create(); // this crete an empty page 
        $resultPage->getConfig()->getTitle()->prepend(__('#'.$topTableData->getData('reservation_id')));//this is your page heading
        $block = $resultPage->getLayout()->getBlock('toptable_edit');
        $block->setData('toptable_edit', $topTableData);
        return $resultPage;
    }
}