<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block\Blog;


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
     * @var \Magenest\Movie\Model\ResourceModel\Blog\CollectionBlog
     */
    protected $_CollectionBlogFactory;

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
        \Magenest\Movie\Model\ResourceModel\Blog\CollectionBlogFactory $collectionBlog,
        \Magento\Framework\Locale\FormatInterface $localeFormat
    ) {
        $this->_jsonEncoder = $jsonEncoder;
        $this->string = $string;
        $this->_localeFormat = $localeFormat;
        $this->_CollectionBlogFactory = $collectionBlog;
        parent::__construct(
            $context
        );
    }

    /**
     * get Data Director
     */
    public function getBlogData(){
        $directorData = $this->_CollectionBlogFactory->create();
        return $directorData->getData();
    }
}
