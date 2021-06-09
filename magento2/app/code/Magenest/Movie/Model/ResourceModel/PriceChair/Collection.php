<?php
namespace Magenest\Movie\Model\ResourceModel\PriceChair;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\PriceChair', 'Magenest\Movie\Model\ResourceModel\PriceChair');
    }
}