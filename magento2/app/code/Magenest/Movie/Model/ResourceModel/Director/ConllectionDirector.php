<?php
namespace Magenest\Movie\Model\ResourceModel\Director;

class ConllectionDirector extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Director', 'Magenest\Movie\Model\ResourceModel\Director');
    }
}