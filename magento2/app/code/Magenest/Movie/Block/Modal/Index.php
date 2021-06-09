<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block\Modal;


/**
 * Product View block
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * Magento string lib
     *
     * @var \Magento\Framework\Stdlib\StringUtils
     */
    protected $string;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;

    /**
     * @var \Magento\Framework\Locale\FormatInterface
     */
    protected $_localeFormat;

    /**
     * @var \Magenest\Movie\Model\DirectorFactory
     */
    protected $_directorFactory;

    /**
     * @var \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @codingStandardsIgnoreStart
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magenest\Movie\Model\DirectorFactory $directorFactory,
        \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory $collectionFactory,
        \Magento\Framework\Locale\FormatInterface $localeFormat
    ) {
        $this->_jsonEncoder = $jsonEncoder;
        $this->string = $string;
        $this->_localeFormat = $localeFormat;
        $this->_directorFactory = $directorFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct(
            $context
        );
    }

    /**
     * get Conllection Movie
     */
    public function getConllection(){
        $movieData = $this->_collectionFactory->create();
        return $movieData->getData();
    }

    /**
     * get Data Director By Id
     */
    public function getDataDirectorById($directorId){
        $directorData = $this->_directorFactory->create()->load($directorId);
        return $directorData->getData();
    }
}
