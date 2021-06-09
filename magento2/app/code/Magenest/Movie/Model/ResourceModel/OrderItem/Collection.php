<?php
namespace Magenest\Movie\Model\ResourceModel\OrderItem;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\OrderItem', 'Magenest\Movie\Model\ResourceModel\OrderItem');
    }

    // protected function _initSelect()
    // {
    //     $this->getSelect()
    //         ->from(['main_table' => $this->getMainTable()])
    //         ->join('sales_order_grid',
    //         'main_table.item_id = sales_order_grid.entity_id',
    //         [
    //             'increment_id',
    //             'status',
    //             'store_name',
    //             'base_grand_total',
    //             'base_total_paid',
    //             'order_currency_code',
    //             'shipping_name',
    //             'billing_name',
    //             'billing_address',
    //             'shipping_address',
    //             'shipping_information',
    //             'customer_email',
    //             'customer_group',
    //             'subtotal',
    //             'payment_method',
    //             'total_refunded',
    //             'customer_name',
    //             'shipping_and_handling'

    //         ]);           
    //     return $this;
    // }
}