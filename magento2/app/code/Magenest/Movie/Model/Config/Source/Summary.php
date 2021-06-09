<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Model\Config\Source;

class Summary implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('show')],
            ['value' => 2, 'label' => __('not-show')]
        ];
    }
}
