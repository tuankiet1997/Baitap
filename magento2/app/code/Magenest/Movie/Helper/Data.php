<?php

namespace Magenest\Movie\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    protected $transportBuilder;
    protected $storeManager;
    protected $inlineTranslation;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        StateInterface $state
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        parent::__construct($context);
    }

    public function sendEmail()
    {
//         $template = 'abandonedcart_item1';
//         $recipient_address = 'kietit197@gmail.com';
//         $recipient_name = 'Tuan kiet';
//         $from_address = [
//             'Name' => 'admin',
//             'Email' => 'kietnt@magenest.com'
//         ];
// 	//an array with variables, format is key = variable name, value = variable value
// 	$vars = [
// 	];
// 	//several variables in email template, i.e. storeName are generated based on store Id
// 	$storeId = 1;
 
// 	$this->_inlineTranslation->suspend();
// 	$version = $this->_helperData->getVersionMagento();
// 	if(version_compare($version,'2.2.0') < 0){
//     	//create email object for Magento 2.1.x
//     	$this->_transportBuilder->setTemplateIdentifier(
//         	$template
//     	)->setTemplateOptions(
//         	[
//             	'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
//             	'store' => $storeId,
//         	]
//     	)->setTemplateVars(
//         	$vars
//     	)->addTo(
//         	$recipient_address,
//         	$recipient_name
//     	);
// 	}
// 	//create email template for Magento 2.2.x and 2.3.x
// else {
//     	$this->_transportBuilder->setTemplateIdentifier(
//         	$template
//     	)->setTemplateOptions(
//         	[
//             	'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
//             	'store' => $storeId,
//         	]
//     	)->setTemplateVars(
//         	$vars
//     	)->setFrom(
//         	$from_address
//     	)->addTo(
//         	$recipient_address,
//         	$recipient_name
//     	);
// 	}
 
// 	//add bcc email address
// 	$bccMail = ‘[email address]’;
//    	$this->_transportBuilder->addBcc($bccMail);
 
// 	//add attachments to email object
// 	if ($attachments) {
// //check version of Zend Framework in use based on the existence of createAttachment function in Magento 2’s default transportBuiler
//     	if (method_exists($this->_transportBuilder->getMessage(), 'createAttachment')) {
//         	foreach ($attachments as $attachment) {
//             	if ($attachment) {
//                 	$this->_transportBuilder->createAttachment($attachment);
//             	}
//         	}
//         	$transport = $this->_transportBuilder->getTransport();
//     	} else {
//         	$transport = $this->_transportBuilder->getTransport();
//         	foreach ($attachments as $attachment) {
//             	if ($attachment) {
//                 	$this->_transportBuilder->createAttachment($attachment, $transport);
//             	}
//         	}
//     	}
// 	}
 
// 	//create the transport
// 	if (!isset($transport)) {
//     	$transport = $this->_transportBuilder->getTransport();
// 	}
	
// 	//send the email
// 	try {
//     	$transport->sendMessage();
//     	$this->_inlineTranslation->resume();
// 	} catch (\Exception $exception) {
// 	//log failed email send operation
//     	$this->_logger->critical($exception->getMessage());
// 	}
    }
}