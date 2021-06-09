<?php

namespace Magenest\Movie\Plugin;

class RendererItemName

{
    public function afterGetProductName($item, $result)
    {
        $sku = $item->getItem()->getData('sku');
        $result = $sku;
        return $result;
    }
}
