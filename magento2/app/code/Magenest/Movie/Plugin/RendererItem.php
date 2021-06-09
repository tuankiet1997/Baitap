<?php

namespace Magenest\Movie\Plugin;

class RendererItem

{
    public function afterGetImage($item, $result)
    {
        $sku = $item->getItem()->getData('sku');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        $productObj = $productRepository->get($sku);
        $imageHelper  = $objectManager->get('\Magento\Catalog\Helper\Image');
        $image_url = $imageHelper->init($productObj, 'product_page_image_small')->setImageFile($productObj->getImage())->resize(100, 100)->getUrl();
        $result->setImageUrl($image_url);
        return $result;
    }
}
