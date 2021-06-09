<?php
namespace Magenest\Movie\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class OrderItem extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sales_order_item', 'item_id');
    }

    // /**
    //  * Retrieve select object for load object data
    //  *
    //  * @param string $field
    //  * @param mixed $value
    //  * @param \Magento\Framework\Model\AbstractModel $object
    //  * @return \Magento\Framework\DB\Select
    //  */
    // protected function _getLoadSelect($field, $value, $object)
    // {
    //     $field = $this->getConnection()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), $field));
    //     $select = $this->getConnection()
    //         ->select()
    //         ->from($this->getMainTable())
    //         ->where($field . '=?', $value)
    //         ->join('admin_user',
    //         'mailing_sign_up.author_id = admin_user.user_id',
    //         [
    //             'firstname',
    //             'lastname',
    //             'username'
    //         ]);
    //     return $select;
    // }
}