<?php

 namespace Magenest\Movie\Controller\Data;

 class View extends \Magento\Framework\App\Action\Action
 {
     protected $_pageFactory;

     public function __construct(
         \Magento\Framework\App\Action\Context $context,
         \Magento\Framework\View\Result\PageFactory $pageFactory)
     {
         $this->_pageFactory = $pageFactory;
         return parent::__construct($context);
     }

     public function execute()
     {
        $movieId = $this->getRequest()->getParam('id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $movieData = $objectManager->create('Magenest\Movie\Model\Movie')->load($movieId);
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__($movieData->getData('name')));
        $block = $resultPage->getLayout()->getBlock('data_view_movie');
        $block->setData('data_view_movie', $movieData);
        return $resultPage;
     }
 }
