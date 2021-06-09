<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Model\Config\Source;

/**
 * Back orders source class
 */
class ChairConfig implements \Magento\Framework\Option\ArrayInterface
{
   /**
     * @var \Magenest\Movie\Model\ResourceModel\ChairType\CollectionFactory
     */
    protected $_collectionFactory;

    public function __construct(\Magenest\Movie\Model\ResourceModel\ChairType\CollectionFactory $collectionFactory)
    {
        $this->_collectionFactory = $collectionFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $directorData = $this->_collectionFactory->create();
        $array = [];
        foreach($directorData->getData() as $data){
            $array[] =
                [
                    'value' => $data['chair_id'], 
                    'label' => $data['name']
                ];
        }
        return $array;
        
    }
}
