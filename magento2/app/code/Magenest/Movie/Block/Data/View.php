<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block\Data;


/**
 * Product View block
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class View extends \Magento\Framework\View\Element\Template
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
     * @var \Magenest\Movie\Model\ActorFactory
     */
    protected $_actorFactory;

     /**
     * @var \Magenest\Movie\Model\ActorFactory
     */
    protected $_priceChairFactory;


    /**
     * @var \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magenest\Movie\Model\ResourceModel\PriceChair\CollectionFactory
     */
    protected $_collectionPriceChairFactory;

    /**
     * @var \Magenest\Movie\Model\ResourceModel\ChairType\CollectionFactory
     */
    protected $_collectionChairTypeFactory;

    /**
     * @var \Magenest\Movie\Model\ResourceModel\Chair\CollectionFactory
     */
    protected $_collectionChairFactory;

    protected $_chairFactory;

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
        \Magenest\Movie\Model\ChairFactory $ChairFactory,
        \Magenest\Movie\Model\ActorFactory $actorFactory,
        \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory $collectionFactory,
        \Magenest\Movie\Model\ResourceModel\PriceChair\CollectionFactory $collectionPriceChairFactory,
        \Magenest\Movie\Model\ResourceModel\ChairType\CollectionFactory $collectionChairTypeFactory,
        \Magenest\Movie\Model\ResourceModel\Chair\CollectionFactory $collectionChairFactory,
        \Magento\Framework\Locale\FormatInterface $localeFormat
    ) {
        $this->_jsonEncoder = $jsonEncoder;
        $this->string = $string;
        $this->_localeFormat = $localeFormat;
        $this->_directorFactory = $directorFactory;
        $this->_actorFactory = $actorFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_collectionPriceChairFactory = $collectionPriceChairFactory;
        $this->_collectionChairTypeFactory = $collectionChairTypeFactory;
        $this->_collectionChairFactory = $collectionChairFactory;
        $this->_chairFactory = $ChairFactory;
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
     * get Conllection Movie
     */
    public function getChairData(){
        $ChariData = $this->_collectionChairTypeFactory->create();
        return $ChariData->getData();
    }

    /**
     * get Conllection Movie
     */
    public function getListChair(){
        $ChariData = $this->_collectionChairFactory->create();
        return $ChariData->getData();
    }

    /**
     * get Conllection Movie
     */
    public function getPriceChair($id){
        $ChariData = $this->_chairFactory->create()->load($id);
        $ChariData->getData('chair_id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $tableNameActor = $resource->getTableName('magenest_price_chair');
        $connection = $resource->getConnection();
        $sqlActor = "select price_movie FROM ". $tableNameActor . " where chair_id = '" . $ChariData->getData('chair_id') . "'";
        $result = $connection->fetchAll($sqlActor);
        return $result;
    }

    /**
     * get Data Director By Id
     */
    public function getDataDirectorById($directorId){
        $directorData = $this->_directorFactory->create()->load($directorId);
        return $directorData->getData();
    }

    /**
     * get Data Director By Id
     */
    public function getDataActorById($actorId){
        $actorData = $this->_actorFactory->create()->load($actorId);
        return $actorData->getData();
    }

    public function getActorByMovie($movieId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $tableNameActor = $resource->getTableName('magenest_movie_actor');
        $connection = $resource->getConnection();
        $sqlActor = "select actor_id FROM ". $tableNameActor . " where movie_id = '" . $movieId . "'";
        $resultActorId = $connection->fetchAll($sqlActor);
        return $resultActorId;
    }

    /**
     * get Data Director By Id
     */
    public function getDataChair(){
        $PriceChair = $this->_collectionPriceChairFactory->create();
        return $PriceChair->getData();
    }
}
