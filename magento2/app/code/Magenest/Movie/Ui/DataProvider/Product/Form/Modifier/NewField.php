<?php
namespace Magenest\Movie\Ui\DataProvider\Product\Form\Modifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Framework\UrlInterface;
class NewField extends AbstractModifier
{

    /**#@+
     * Group values
     */
    const GROUP_CUSTOM_OPTIONS_NAME = 'custom_fieldset';
    const GROUP_CUSTOM_OPTIONS_SCOPE = 'data.product';
    const GRID_OPTIONS_NAME = 'custom_field';
    const CUSTOM_OPTIONS_LISTING = 'product_custom_options_listing';
    const CONTAINER_OPTION = 'container_option';
    const CONTAINER_COMMON_NAME = 'container_common';
    const FIELD_TITLE_COMMENT = 'title';
    const FIELD_TITLE_LINK = 'link';
    const FIELD_TYPE_NAME = 'type';


    const FIELD_IS_DELETE = 'is_delete';
    const FIELD_SORT_ORDER_NAME = 'sort_order';
    const FIELD_NAME_SELECT = 'select_field';
    const FIELD_NAME_TEXT  = 'text_field';
    const FIELD_NAME_UPLOAD = 'upload_field';
    const CONTAINER_HEADER_NAME = 'container_header';
    const BUTTON_ADD = 'button_add';
    const FIELD_ENABLE = 'affect_product_custom_options';
    const FIELD_OPTION_ID = 'option_id';

    private $locator;
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;
    public function __construct(
    LocatorInterface $locator,
    UrlInterface $urlBuilder
    ) {
        $this->locator = $locator;
        $this->urlBuilder            = $urlBuilder;
    }
    public function modifyData(array $data)
    {
        return $data;
    }
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'custom_fieldset' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Dynamic row'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product.custom_fieldset',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                    "custom_test" => $this->getHeaderContainerConfig(1),
                    static::GRID_OPTIONS_NAME => $this->getSelectTypeGridConfig(2)
                    ],
                ]
            ]
        );
        return $meta;
    }

    /**
     * Get config for header container
     *
     * @param int $sortOrder
     * @return array
     * @since 101.0.0
     */
    protected function getHeaderContainerConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => null,
                        'formElement' => Container::NAME,
                        'componentType' => Container::NAME,
                        'template' => 'ui/form/components/complex',
                        'sortOrder' => $sortOrder,
                        'content' => __('Custom options'),
                    ],
                ],
            ],
            'children' => [
                static::BUTTON_ADD => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'title' => __('Add Option'),
                                'formElement' => Container::NAME,
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/form/components/button',
                                'sortOrder' => 20,
                                'actions' => [
                                    [
                                        'targetName' => '${ $.ns }.${ $.ns }.' . static::GROUP_CUSTOM_OPTIONS_NAME
                                            . '.' . static::GRID_OPTIONS_NAME,
                                        '__disableTmpl' => ['targetName' => false],
                                        'actionName' => 'processingAddChild',
                                    ]
                                ]
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }


    protected function getSelectTypeGridConfig($sortOrder) {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'addButtonLabel' => __('Add Option'),
                        'componentType' => DynamicRows::NAME,
                        'component' => 'Magento_Catalog/js/components/dynamic-rows-import-custom-options',
                        'template' => 'ui/dynamic-rows/templates/collapsible',
                        'additionalClasses' => 'admin__field-wide',
                        'deleteProperty' => static::FIELD_IS_DELETE,
                        'deleteValue' => '1',
                        'addButton' => false,
                        'renderDefaultRecord' => false,
                        'columnsHeader' => false,
                        'collapsibleHeader' => true,
                        'sortOrder' => $sortOrder,
                        'dataProvider' => static::CUSTOM_OPTIONS_LISTING,
                        'imports' => [
                            'insertData' => '${ $.provider }:${ $.dataProvider }',
                            '__disableTmpl' => ['insertData' => false],
                        ],
                    ],
                ],
            ],
            'children' => [
                'record' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'headerLabel' => __('New Document'),
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/dynamic-rows/record',
                                'positionProvider' => static::CONTAINER_OPTION . '.' . static::FIELD_SORT_ORDER_NAME,
                                'isTemplate' => true,
                                'is_collection' => true,
                            ],
                        ],
                    ],
                    'children' => [
                        static::CONTAINER_OPTION => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => Fieldset::NAME,
                                        'collapsible' => true,
                                        'label' => null,
                                        'sortOrder' => 10,
                                        'opened' => true,
                                    ],
                                ],
                            ],
                            'children' => [
                                static::CONTAINER_COMMON_NAME => $this->getCommonContainerConfig(10),
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }
    /**
     * Get config for container with common fields for any type
     *
     * @param int $sortOrder
     * @return array
     * @since 101.0.0
     */
    protected function getCommonContainerConfig($sortOrder)
    {
        $commonContainer = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Container::NAME,
                        'formElement' => Container::NAME,
                        'component' => 'Magento_Ui/js/form/components/group',
                        'breakLine' => false,
                        'showLabel' => false,
                        'additionalClasses' => 'admin__field-group-columns admin__control-group-equal',
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
            'children' => [
                static::FIELD_OPTION_ID => $this->getOptionIdFieldConfig(10),
                static::FIELD_TITLE_COMMENT => $this->getComentFieldConfig(
                    20,
                    [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'label' => __('Comment'),
                                    'component' => 'Magento_Catalog/component/static-type-input',
                                    'valueUpdate' => 'input',
                                    'imports' => [
                                        'optionId' => '${ $.provider }:${ $.parentScope }.option_id',
                                        'isUseDefault' => '${ $.provider }:${ $.parentScope }.is_use_default',
                                        '__disableTmpl' => ['optionId' => false, 'isUseDefault' => false],
                                    ]
                                ],
                            ],
                        ],
                    ]
                ),
                static::FIELD_TITLE_LINK => $this->getLinkFieldConfig(
                    30,
                    [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'label' => __('Link'),
                                    'component' => 'Magento_Catalog/component/static-type-input',
                                    'valueUpdate' => 'input',
                                    'imports' => [
                                        'optionId' => '${ $.provider }:${ $.parentScope }.option_id',
                                        'isUseDefault' => '${ $.provider }:${ $.parentScope }.is_use_default',
                                        '__disableTmpl' => ['optionId' => false, 'isUseDefault' => false],
                                    ]
                                ],
                            ],
                        ],
                    ]
                ),
            ]
        ];

        return $commonContainer;
    }
    /**
     * Get config for hidden id field
     *
     * @param int $sortOrder
     * @return array
     * @since 101.0.0
     */
    protected function getOptionIdFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'formElement' => Input::NAME,
                        'componentType' => Field::NAME,
                        'dataScope' => static::FIELD_OPTION_ID,
                        'sortOrder' => $sortOrder,
                        'visible' => false,
                    ],
                ],
            ],
        ];
    }

     /**
     * Get config for "Title" fields
     *
     * @param int $sortOrder
     * @param array $options
     * @return array
     * @since 101.0.0
     */
    protected function getComentFieldConfig($sortOrder, array $options = [])
    {
        return array_replace_recursive(
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Title'),
                            'componentType' => Field::NAME,
                            'formElement' => Input::NAME,
                            'dataScope' => static::FIELD_TITLE_COMMENT,
                            'dataType' => Text::NAME,
                            'sortOrder' => $sortOrder,
                            'validation' => [
                                'required-entry' => true
                            ],
                        ],
                    ],
                ],
            ],
            $options
        );
    }

    /**
     * Get config for "Title" fields
     *
     * @param int $sortOrder
     * @param array $options
     * @return array
     * @since 101.0.0
     */
    protected function getLinkFieldConfig($sortOrder, array $options = [])
    {
        return array_replace_recursive(
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Title'),
                            'componentType' => Field::NAME,
                            'formElement' => Input::NAME,
                            'dataScope' => static::FIELD_TITLE_LINK,
                            'dataType' => Text::NAME,
                            'sortOrder' => $sortOrder,
                            'validation' => [
                                'required-entry' => true
                            ],
                        ],
                    ],
                ],
            ],
            $options
        );
    }

    protected function getDataUploadField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => 'fileUploader',
                        'formElement' => 'imageUploader',
                        'component' => 'Magento_Ui/js/form/element/file-uploader',
                        'dataScope' => 'file',
                        'fileInputName' => 'image',
                        'uploaderConfig' => [
                            'url' => $this->urlBuilder->getUrl(
                                'magenest/banner/filesubmission'
                            ),
                        ],
                    ],
                ],
            ]
        ];
    }
    protected function getIsDeleteFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => ActionDelete::NAME,
                        'fit' => true,
                        'sortOrder' => $sortOrder
                    ],
                ],
            ],
        ];
    }
}