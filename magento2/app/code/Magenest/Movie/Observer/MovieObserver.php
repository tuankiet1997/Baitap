<?php
namespace Magenest\Movie\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
class MovieObserver implements ObserverInterface
{
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    protected $_customerGroup;
    private $logger;
    protected $_customerRepositoryInterface;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ){
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->logger = $logger;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $event = $observer->getEvent();
        $movie = $observer->getData('movie');
        $movie->setData('rating', '0');
        $movie->save();
        return $this;
    }
}
