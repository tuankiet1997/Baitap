<?php
namespace Magenest\Movie\Model\ResourceModel\Checkout;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Checkout', 'Magenest\Movie\Model\ResourceModel\Checkout');
    }
}
