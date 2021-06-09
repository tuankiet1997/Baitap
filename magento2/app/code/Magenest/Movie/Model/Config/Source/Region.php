<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Model\Config\Source;

class Region extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Retrieve all product tax class options.
     *
     * @param bool $withEmpty
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
            ['label' => __('Mien Bac'), 'value' => 1],
            ['label' => __('Mien Nam'), 'value' => 2],
            ['label' => __('Mien Trung'), 'value' => 3]
        ];
        return $this->_options;
    }
}
