<?php

 namespace Magenest\Movie\Controller\Data;

 use Magenest\Movie\Model\CheckoutFactory;
 use Magento\Framework\Controller\ResultFactory;

 class CheckoutPost extends \Magento\Framework\App\Action\Action
 {
     protected $_pageFactory;

     protected $_checkoutFactory;

     protected $_chairFactory;

     public function __construct(
         \Magento\Framework\App\Action\Context $context,
         \Magento\Framework\View\Result\PageFactory $pageFactory,
         \Magento\Framework\App\Request\Http $request,
         \Magenest\Movie\Model\ChairFactory $ChairFactory,
         CheckoutFactory $checkoutFactory)
     {
         $this->_pageFactory = $pageFactory;
         $this->_checkoutFactory = $checkoutFactory;
         $this->request = $request;
         $this->_chairFactory = $ChairFactory;
         return parent::__construct($context);
     }

    public function execute()
    {
        try {
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $om->get('Magento\Customer\Model\Session');
        $customerData = $customerSession->getCustomer()->getId();
        $data = $this->request->getParams();
        if($data){
            foreach($data as $item)
            {
                $arraydata = [
                'name' => 'test',
                'showtime' => '',
                'room' => '4D',
                'price_movie' => $item[0]['price'],
                'chair' => $item[0]['numChair'],
                'customer_id' => $customerData,
                'status' => '1',
                'typechair' => $item[0]['typeChair']
                ];
                $Data = $this->_checkoutFactory->create();
                $Data->setData($arraydata)->save();
                $ChariData = $this->_chairFactory->create()->load($Data->getData('chair'));
                $ChariData->setData('status', 0);
                $ChariData->save();

            }
        }
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $resultJson->setData($arraydata);
            return $resultJson;
        } catch (\Exception $e) {
            var_dump($e);die();
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
    }
 }
