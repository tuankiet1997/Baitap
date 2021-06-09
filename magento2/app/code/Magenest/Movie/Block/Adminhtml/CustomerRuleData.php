<?php

namespace Magenest\Movie\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Registry;

class CustomerRuleData extends AbstractFieldArray
{
    private $holidaysRenderer;
    private $dateRenderer;
    /**
     * @var Customergroup
     */
    protected $_groupRenderer;
    /** @var $textAreaType */
    private $textAreaType;
    

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }


    /**
     * Retrieve group column renderer
     *
     * @return Customergroup
     */
    protected function _getGroupRenderer()
    {
        if (!$this->_groupRenderer) {
            $this->_groupRenderer = $this->getLayout()->createBlock(
                \Magento\CatalogInventory\Block\Adminhtml\Form\Field\Customergroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->_groupRenderer->setClass('customer_group_select admin__control-select');
        }
        return $this->_groupRenderer;
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function textAreaTypes()
    {
        if (!$this->textAreaType) {
            $this->textAreaType = $this->getLayout()->createBlock(
                '\Magenest\Movie\Block\Adminhtml\Form\Field\Textarea',
                ''
            );
        }
 
        return $this->textAreaType;
    }


    protected function _prepareToRender()
    {

        $this->addColumn(
            'customer_group_id',
            ['label' => __('Customer Group'), 'style' => 'width:100px',  'renderer' => $this->_getGroupRenderer()]
        );

        $this->addColumn(
            'textarea_rule',
            [
                'label' => __('Content'),
                'renderer' => $this->textAreaTypes()
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [];
        $optionExtraAttr['option_' . $this->_getGroupRenderer()->calcOptionHash($row->getData('customer_group_id'))] =
            'selected="selected"';
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}