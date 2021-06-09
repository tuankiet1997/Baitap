<?php
namespace Magenest\Movie\Model\ResourceModel\Movie;

class ConllectionDirector extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Actor', 'Magenest\Movie\Model\ResourceModel\Actor');
    }
}