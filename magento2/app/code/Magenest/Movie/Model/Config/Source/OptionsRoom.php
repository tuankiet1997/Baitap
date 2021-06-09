<?php

namespace Magenest\Movie\Model\Config\Source;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;

/**
* Custom Attribute Renderer
*/
class OptionsRoom extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
    * @var OptionFactory
    */
    protected $optionFactory;
    /**
    * @param OptionFactory $optionFactory
    */
    /**
    * Get all options
    *
    * @return array
    */
    public function getAllOptions()
    {
        /* your Attribute options list*/
        $this->_options=[ 
            ['label'=>'2D', 'value'=>'1'],
            ['label'=>'3D', 'value'=>'2'],
            ['label'=>'4D', 'value'=>'3'],
            ['label'=>'IMAX', 'value'=>'4']
        ];
        return $this->_options;
    }
}
