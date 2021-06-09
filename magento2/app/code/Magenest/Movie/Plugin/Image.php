<?php

namespace Magenest\Movie\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Block\Form\Register;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Newsletter\Model\Subscriber;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Framework\UrlInterface;

class Image

{
    /**
     * Cached subscription object
     *
     * @var Subscriber
     */
    protected $_subscription;

    /**
     * @var SubscriberFactory
     */
    protected $_subscriberFactory;

    /**
     * @var View
     */
    protected $_helperView;

    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;

    protected $urlBuilder;

    protected $storeManager;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CurrentCustomer $currentCustomer
     * @param SubscriberFactory $subscriberFactory
     * @param View $helperView
     * @param array $data
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        SubscriberFactory $subscriberFactory,
        UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        View $helperView
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->_subscriberFactory = $subscriberFactory;
        $this->_helperView = $helperView;
        $this->urlBuilder            = $urlBuilder;
        $this->storeManager          = $storeManager;
    }
    public function aroundGetItemData($subject, $proceed, $item)
    {
        $result = $proceed($item);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        $productObj = $productRepository->get($result['product_sku']);
        $result['product_name'] = $result['product_sku'];
        $imageHelper  = $objectManager->get('\Magento\Catalog\Helper\Image');
        $image_url = $imageHelper->init($productObj, 'product_page_image_small')->setImageFile($productObj->getImage())->resize(100, 100)->getUrl();
        $result['product_image']['src'] = $image_url;
        return $result;
    }
}
