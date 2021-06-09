<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Model\Config\Source;

/**
 * Back orders source class
 */
class DirectorConfig implements \Magento\Framework\Option\ArrayInterface
{
   /**
     * @var \Magenest\Movie\Model\ResourceModel\Director\ConllectionDirectorFactory
     */
    protected $_conllectionDirectorFactory;

    public function __construct(\Magenest\Movie\Model\ResourceModel\Director\ConllectionDirectorFactory $conllectionDirectorFactory)
    {
        $this->_conllectionDirectorFactory = $conllectionDirectorFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $directorData = $this->_conllectionDirectorFactory->create();
        $array = [];
        foreach($directorData->getData() as $data){
            $array[] =
                [
                    'value' => $data['director_id'], 
                    'label' => $data['name']
                ];
        }
        return $array;
        
    }
}
