<?php 
namespace Magenest\Movie\Plugin;

use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;

class AddColumnsSalesOrderGridCollection extends \Magento\Framework\Data\Collection
{
    private $messageManager;
    private $collection;

    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(MessageManager $messageManager,
        SalesOrderGridCollection $collection,
        \Magento\Framework\Registry $registry
    ) {

        $this->messageManager = $messageManager;
        $this->collection = $collection;
        $this->registry = $registry;
    }

    public function beforeLoad($printQuery = false, $logQuery = false)
    {
        if ($printQuery instanceof Collection) {
            $collection = $printQuery;
 
            $joined_tables = array_keys(
                $collection->getSelect()->getPart('from')
            );
 
                $collection->getSelect()
                    ->columns(
                        array(
                            'skus' => new \Zend_Db_Expr('(SELECT GROUP_CONCAT(`sku` SEPARATOR " & ") FROM `sales_order_item` WHERE `sales_order_item`.`order_id` = main_table.`entity_id` GROUP BY `sales_order_item`.`order_id`)')
                        )
                    );
 
        }
    }
}