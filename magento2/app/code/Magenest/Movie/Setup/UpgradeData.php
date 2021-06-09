<?php

namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\App\State;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;

/**
 * Class UpgradeData
 * @package
 */
class UpgradeData implements UpgradeDataInterface
{
    private $attributeSetFactory;
    private $attributeSet;
    private $categorySetupFactory;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var EavConfig
     */
    protected $_eavConfig;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resourceConnection;
    /**
     * Init
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory,
        StoreManager $storeManager,
        CategoryFactory $categoryFactory,
        CategoryRepository $categoryRepository,
        State $state,
        CustomerSetupFactory $customerSetupFactory,
        EavConfig $eavConfig,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    )
    {
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->eavSetupFactory     = $eavSetupFactory;
        $this->storeManager = $storeManager;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->state = $state;
        $this->_eavConfig = $eavConfig;
        $this->_resourceConnection = $resourceConnection;
	}

    /**
     * Installs DB schema for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        // $setup->endSetup();
        $setup->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if(version_compare($context->getVersion(), "1.0.1", "<")){
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, 'country_of_manufacture', \Magento\Eav\Api\Data\AttributeInterface::BACKEND_TYPE, 'text');
        }

        if(version_compare($context->getVersion(), "1.0.2", "<")){
            $customerSetup->addAttribute('customer_address', 'vn_region', [
                'label' => 'Region VN',
                'input' => 'select',
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'source' => 'Magenest\Movie\Model\Config\Source\Region',
                'required' => false,
                'position' => 90,
                'visible' => true,
                'system' => false,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'user_defined' => true,
                'is_searchable_in_grid' => false,
                'frontend_input' => 'hidden',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend'
            ]);
    
               $attribute=$customerSetup->getEavConfig()
                 ->getAttribute('customer_address','vn_region')                                  
                 ->addData(['used_in_forms' => [
                    'adminhtml_customer_address',
                    'adminhtml_customer',
                    'customer_address_edit',
                    'customer_register_address',
                    'customer_address',
                   ]
                 ]);
            $attribute->save();
        }

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        if(version_compare($context->getVersion(), "1.0.3", "<")){
            $customerSetup->addAttribute(Customer::ENTITY, 'telephone', [
                'type' => 'varchar',
                'label' => 'Phone',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 90,
                'position' => 90,
                'system' => 0,
            ]);

            $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'telephone')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer'],
                ]);

            $attribute->save();
        }

        if(version_compare($context->getVersion(), "1.0.4", "<")){
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'product_from_date',
                [
                    'type' => 'datetime',
                    'backend' => '',
                    'frontend' => 'Magento\Eav\Model\Entity\Attribute\Frontend\Datetime',
                    'label' => 'Start Date',
                    'input' => 'date',
                    'class' => '',
                    'source' => '',
                    'global' => 0,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => true,
                    'default' => null,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => true,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => '',
                    'system' => 1,
                    'group' => 'General',
                    'option' => array('values' => array("")),
                    'sort_order' => 17,
                ]
            );

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'product_to_date',
                [
                    'type' => 'datetime',
                    'backend' => '',
                    'frontend' => 'Magento\Eav\Model\Entity\Attribute\Frontend\Datetime',
                    'label' => 'End Date',
                    'input' => 'date',
                    'class' => '',
                    'source' => '',
                    'global' => 0,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => true,
                    'default' => null,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => true,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => '',
                    'system' => 1,
                    'group' => 'General',
                    'option' => array('values' => array("")),
                    'sort_order' => 17,
                ]
            );
        }

        if(version_compare($context->getVersion(), "1.0.5", "<")){
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
            $attributeSet = $this->attributeSetFactory->create();
            $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
            $data = [
            'attribute_set_name' => 'Movie',
            'entity_type_id' => $entityTypeId,
            'sort_order' => 50,
            ];
            $attributeSet->setData($data);
            $attributeSet->validate();
            $attributeSet->save();
            $attributeSet->initFromSkeleton($attributeSetId);
            $attributeSet->save();
        }

        if(version_compare($context->getVersion(), "1.0.6", "<")){
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'type_of_chair',
                [
                'group' => 'General',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Type Chair',
                'input' => 'select',
                'class' => '',
                'source' => 'Magenest\Movie\Model\Config\Source\Options',
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => true,
                'filterable' => true,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,            
                'unique' => false
                
                ]
                
                );
        }

        if(version_compare($context->getVersion(), "1.0.7", "<")){
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'type_of_room',
                [
                'group' => 'General',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Type Room',
                'input' => 'select',
                'class' => '',
                'source' => 'Magenest\Movie\Model\Config\Source\OptionsRoom',
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => true,
                'filterable' => true,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,            
                'unique' => false
                
                ]
                
                );
        }
        $setup->endSetup();
    }
}