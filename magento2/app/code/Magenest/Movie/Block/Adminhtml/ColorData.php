<?php

namespace Magenest\Movie\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Registry;

class ColorData extends AbstractFieldArray
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


    protected function _prepareToRender()
    {

        $this->addColumn(
            'color_text',
            ['label' => __('Color'), 'style' => 'width:100px']
        );

        $this->addColumn(
            'color_code',
            [
                'label' => __('Color Code'),
                'id' => 'color_code',
                'class' => 'color_kiet',
                'style' => 'width:100px'
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * add color picker in admin configuration fields
     * @param  AbstractElement $element
     * @return string script
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = parent::_getElementHtml($element);
        $value = $element->getData('value');
            $html .= '<script type="text/javascript">
                require(["jquery", "jquery/colorpicker/js/colorpicker"], function ($) {
                    $(document).ready(function () {
                        function bindColorPicker() {
                            setTimeout(function() {
                                var $el2 = $(".color_kiet");
                                $el2.ColorPicker({
                                    color: "#" + $el2.val().replace(/^(#)/,"").substring(0, 6),
                                    onChange: function (hsb, hex, rgb) {
                                        $el2.css("backgroundColor", "#" + hex).val("#" + hex);
                                    }
                                });
                                $el2.on("change keyup focus", function(){
                                    var currentVal = $(this).val().replace(/^(#)/,"").substring(0, 6);
                                    $(this).val("#" + currentVal);
                                    $(this).css("backgroundColor", "#" + currentVal);
                                    $(this).ColorPickerSetColor("#" + currentVal);
                                });
                            }, 50 )
                        }
                        bindColorPicker();
                        $("button.action-add").on("click", function(e) {
                            bindColorPicker();
                        });
                    });
                });
                </script>';



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
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}
