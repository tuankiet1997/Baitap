<?php
namespace Magenest\Movie\Model\ResourceModel\Blog;

class CollectionBlog extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Blog', 'Magenest\Movie\Model\ResourceModel\Blog');
    }

    protected function _initSelect()
    {
        $this->getSelect()
            ->from(['main_table' => $this->getMainTable()])
            ->join('admin_user',
            'main_table.author_id = admin_user.user_id',
            [
                'firstname',
                'lastname',
                'username'
            ]);           
        return $this;
    }
}