<?php
namespace Magenest\Movie\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
class AfterPlaceOrderObserver implements ObserverInterface
{
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    protected $_customerGroup;
    protected $inlineTranslation;
    protected $transportBuilder;
    private $logger;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        WriterInterface $configWriter
    ){
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $logger;
        $this->configWriter = $configWriter;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var $order \Magento\Sales\Model\Order */
        $order = $observer->getEvent()->getOrder();

        $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND,'store' => 1);

        $templateVars = array(
            'store' => 1,
            'orderNumber' => $order->getIncrementId(),
            'customer_name' => $order->getCustomerName(),
            'items'=> $order->getAllItems(),
        );

        $from = array(
            'email' => 'user@example.com',
            'name' => 'Admin'
        );

        $to = "kietit197@gmail.com";
        try {
            $this->inlineTranslation->suspend();
            $to = array($to);
            $transport = $this->transportBuilder->setTemplateIdentifier('available_store_template')
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($from)
                ->addTo($to)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
