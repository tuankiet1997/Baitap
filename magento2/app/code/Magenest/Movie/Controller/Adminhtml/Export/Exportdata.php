<?php

namespace Magenest\Movie\Controller\Adminhtml\Export;

use Magento\Framework\App\Filesystem\DirectoryList;


class Exportdata extends \Magento\Backend\App\Action
{
    protected $uploaderFactory;

    protected $_orderItemFactory;
    protected $orderRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magenest\Movie\Model\OrderItemFactory $orderItemFactory // This is returns Collaction of Data

    ) {
       parent::__construct($context);
       $this->_fileFactory = $fileFactory;
       $this->_orderItemFactory = $orderItemFactory;
       $this->orderRepository = $orderRepository;
       $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR); // VAR Directory Path
       parent::__construct($context);
    }

    public function execute()
    {  
        $name = date('m-d-Y-H-i-s');
        $filepath = 'export/export-data-' .$name. '.csv'; // at Directory path Create a Folder Export and FIle
        $this->directory->create('export');

        $stream = $this->directory->openFile($filepath, 'w+');
        $stream->lock();

        //column name dispay in your CSV 

        $columns = ['ID','Product Name','Qty','Purchase Point','Purchase Date','Grand Total (Base)','Grand Total (Purchased)','Status','Billing Address','Shipping Address','Shipping Information','Customer Email','Customer Group','Subtotal','Customer Name','Payment Method'];

            foreach ($columns as $column) 
            {
                $header[] = $column; //storecolumn in Header array
            }

        $stream->writeCsv($header);

        $location = $this->_orderItemFactory->create();
        $location_collection = $location->getCollection(); // get Collection of Table data 


        foreach($location_collection as $item){

            $order = $this->orderRepository->get($item->getData('order_id'));

            $itemData = [];

            // column name must same as in your Database Table 

            $itemData[] = $order->getData('increment_id');
            $itemData[] = $item->getData('name');
            $itemData[] = $item->getData('qty_ordered');
            $itemData[] = $order->getData('store_name');
            $itemData[] = $item->getData('created_at');
            $itemData[] = $order->getData('base_grand_total');
            $itemData[] = $order->getData('base_grand_total');
            $itemData[] = $order->getData('status');
            $itemData[] = $order->getBillingAddress()->getData('street') . $order->getBillingAddress()->getData('city') . $order->getBillingAddress()->getData('postcode');
            $itemData[] = $order->getShippingAddress()->getData('street') . $order->getShippingAddress()->getData('city') . $order->getShippingAddress()->getData('postcode');
            $itemData[] = $order->getData('shipping_description');
            $itemData[] = $order->getData('customer_email');
            $itemData[] = $order->getData('customer_group_id');
            $itemData[] = $order->getData('subtotal');
            $itemData[] = $order->getData('customer_firstname');
            $itemData[] = $order->getPayment()->getData('additional_information')['method_title'];

            $stream->writeCsv($itemData);

        }

        $content = [];
        $content['type'] = 'filename'; // must keep filename
        $content['value'] = $filepath;
        $content['rm'] = '1'; //remove csv from var folder

        $csvfilename = 'locator-import-'.$name.'.csv';
        return $this->_fileFactory->create($csvfilename, $content, DirectoryList::VAR_DIR);

    }


}