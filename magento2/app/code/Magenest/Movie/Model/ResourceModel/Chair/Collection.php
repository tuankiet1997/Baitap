<?php
namespace Magenest\Movie\Model\ResourceModel\Chair;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Chair', 'Magenest\Movie\Model\ResourceModel\Chair');
    }

    // protected function _initSelect()
    // {
    //     $this->getSelect()
    //         ->from(['main_table' => $this->getMainTable()])
    //         ->join('magenest_price_chair',
    //         'main_table.id = magenest_price_chair.chair_id',
    //         [
    //             'price_movie'
    //         ]);           
    //     return $this;
    // }
}