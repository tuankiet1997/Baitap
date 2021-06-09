<?php
namespace Magenest\Movie\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class ChairType extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_chair_type', 'chair_id');
    }
}