<?php
namespace Magenest\Movie\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

/**
 * Class ScheduleDesignUpdateMetaProvider customizes Schedule Design Update panel
 *
 * @api
 * @since 101.0.0
 */
class PreSellDesignUpdate extends AbstractModifier
{
    /**#@+
     * Field names
     */
    const PRESALE_START = 'product_from_date';
    const PRESALE_END = 'product_to_date';
    /**#@-*/

    /**
     * @var ArrayManager
     * @since 101.0.0
     */
    protected $arrayManager;

    /**
     * @param ArrayManager $arrayManager
     */
    public function __construct(ArrayManager $arrayManager)
    {
        $this->arrayManager = $arrayManager;
    }

    /**
     * @inheritdoc
     *
     * @since 101.0.0
     */
    public function modifyMeta(array $meta)
    {
        $meta = $this->toTime($meta);
        $meta = $this->fromTime($meta);
        $meta = $this->customizeDateRangeField($meta);
        return $meta;
    }

    /**
     * @inheritdoc
     *
     * @since 101.0.0
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Customise Custom Attribute field
     *
     * @param array $meta
     *
     * @return array
     */
    protected function fromTime(array $meta)
    {
        $fieldCode = self::PRESALE_START;

        $elementPath = $this->arrayManager->findPath($fieldCode, $meta, null, 'children');
        $containerPath = $this->arrayManager->findPath(static::CONTAINER_PREFIX . $fieldCode, $meta, null, 'children');

        if (!$elementPath) {
            return $meta;
        }

        $meta = $this->arrayManager->merge(
            $containerPath,
            $meta,
            [
                'children'  => [
                    $fieldCode => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'default' => '',
                                    'options'       => [
                                        'dateFormat' > 'Y-m-d',
                                        'timeFormat' => 'HH:mm:ss',
                                        'showsTime' => true
                                    ]
                                ],
                            ],
                        ],
                    ]
                ]
            ]
        );


        return $meta;
    }

    /**
     * Customise Custom Attribute field
     *
     * @param array $meta
     *
     * @return array
     */
    protected function toTime(array $meta)
    {
        $fieldCode = self::PRESALE_END;

        $elementPath = $this->arrayManager->findPath($fieldCode, $meta, null, 'children');
        $containerPath = $this->arrayManager->findPath(static::CONTAINER_PREFIX . $fieldCode, $meta, null, 'children');

        if (!$elementPath) {
            return $meta;
        }

        $meta = $this->arrayManager->merge(
            $containerPath,
            $meta,
            [
                'children'  => [
                    $fieldCode => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'default' => '',
                                    'options'       => [
                                        'dateFormat' > 'Y-m-d',
                                        'timeFormat' => 'HH:mm:ss',
                                        'showsTime' => true
                                    ]
                                ],
                            ],
                        ],
                    ]
                ]
            ]
        );


        return $meta;
    }

    /**
     * Customize date range field if from and to fields belong to one group
     *
     * @param array $meta
     * @return array
     * @since 101.0.0
     */
    protected function customizeDateRangeField(array $meta)
    {
        if ($this->getGroupCodeByField($meta, self::PRESALE_START)
            !== $this->getGroupCodeByField($meta, self::PRESALE_END)
        ) {
            return $meta;
        }

        $fromFieldPath = $this->arrayManager->findPath(self::PRESALE_START, $meta, null, 'children');
        $toFieldPath = $this->arrayManager->findPath(self::PRESALE_END, $meta, null, 'children');
        $fromContainerPath = $this->arrayManager->slicePath($fromFieldPath, 0, -2);
        $toContainerPath = $this->arrayManager->slicePath($toFieldPath, 0, -2);

        $meta = $this->arrayManager->merge(
            $fromFieldPath . self::META_CONFIG_PATH,
            $meta,
            [
                'label' => __('Product From'),
                'additionalClasses' => 'admin__field-date',
            ]
        );
        $meta = $this->arrayManager->merge(
            $toFieldPath . self::META_CONFIG_PATH,
            $meta,
            [
                'label' => __('To'),
                'scopeLabel' => null,
                'additionalClasses' => 'admin__field-date',
            ]
        );
        $meta = $this->arrayManager->merge(
            $fromContainerPath . self::META_CONFIG_PATH,
            $meta,
            [
                'label' => false,
                'required' => false,
                'additionalClasses' => 'admin__control-grouped-date',
                'breakLine' => false,
                'component' => 'Magento_Ui/js/form/components/group',
            ]
        );
        $meta = $this->arrayManager->set(
            $fromContainerPath . '/children/' . self::PRESALE_END,
            $meta,
            $this->arrayManager->get($toFieldPath, $meta)
        );

        return $this->arrayManager->remove($toContainerPath, $meta);
    }
}