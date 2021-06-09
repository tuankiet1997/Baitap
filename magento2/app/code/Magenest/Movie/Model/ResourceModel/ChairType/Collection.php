<?php
namespace Magenest\Movie\Model\ResourceModel\ChairType;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\ChairType', 'Magenest\Movie\Model\ResourceModel\ChairType');
    }
}