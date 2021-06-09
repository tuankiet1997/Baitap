<?php
namespace Magenest\Movie\Model;
 
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Chair extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\ResourceModel\Chair');
    }
}