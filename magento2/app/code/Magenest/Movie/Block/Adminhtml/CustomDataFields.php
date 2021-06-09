<?php

namespace Magenest\Movie\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Registry;

class CustomDataFields extends AbstractFieldArray
{
    private $holidaysRenderer;
    private $dateRenderer;
    /**
     * @var Customergroup
     */
    protected $_groupRenderer;
    

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

    protected function _prepareToRender()
    {

        $this->addColumn(
            'customer_group_id',
            ['label' => __('Customer Group'), 'style' => 'width:100px',  'renderer' => $this->_getGroupRenderer()]
        );

        $this->addColumn(
            'select_date_from',
            [
                'label' => __('From Date'),
                'id' => 'select_date_from',
                'class' => 'daterecuring',
                'style' => 'width:100px'
            ]
        );

        $this->addColumn(
            'select_date_to',
            [
                'label' => __('To Date'),
                'id' => 'select_date_to',
                'class' => 'daterecuring',
                'style' => 'width:100px'
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('MoreAdd');
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = parent::_getElementHtml($element);

        $script = '<script type="text/javascript">
                require(["jquery", "jquery/ui", "mage/calendar"], function (jq) {
                    jq(function(){
                        function bindDatePicker() {
                            setTimeout(function() {
                                jq(".daterecuring").datetimepicker( { dateFormat: "mm/dd/yy", changeMonth: true, changeYear: true, beforeShowDay: function(d) {
                                    console.log("in"+d.getDate());
                                       if (d.getDate() == 8 || d.getDate() == 9 || d.getDate() == 10 || d.getDate() == 11 || d.getDate() == 12) {
                                         return [true, "" ];
                                       } else {
                                          return [false, "" ];
                                       }
                                    }});
                            }, 50);
                        }
                        bindDatePicker();
                        jq("button.action-add").on("click", function(e) {
                            bindDatePicker();
                        });
                    });  
                });
            </script>';
        $html .= $script;
        return $html;
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