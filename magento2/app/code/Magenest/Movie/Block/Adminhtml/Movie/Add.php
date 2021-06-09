<?php
namespace Magenest\Movie\Block\Adminhtml\Movie;

class Add extends \Magento\Backend\Block\Template
{

    protected $_coreRegistry = null;


    /**
     * @var \Magenest\Movie\Model\ResourceModel\Director\ConllectionDirectorFactory
     */
    protected $_conllectionDirectorFactory;

    /**
     * @var \Magenest\Movie\Model\ResourceModel\Blog\CollectionBlog
     */
    protected $_CollectionBlogFactory;


    /**
     * Index constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magenest\Movie\Model\ResourceModel\Director\ConllectionDirectorFactory $conllectionDirectorFactory,
        \Magenest\Movie\Model\ResourceModel\Blog\CollectionBlogFactory $collectionBlog,
        array $data = []
    ) {
        $this->_coreRegistry         = $coreRegistry;
        $this->_conllectionDirectorFactory = $conllectionDirectorFactory;
        $this->_CollectionBlogFactory = $collectionBlog;
        parent::__construct($context, $data);
    }

     /**
     * Submit URL getter
     *
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl('magenest/movie/addPost');
    }

    /**
     * get Data Director
     */
    public function getDirectorData(){
        $directorData = $this->_conllectionDirectorFactory->create();
        return $directorData->getData();
    }

    /**
     * get Data Director
     */
    public function getBlogData(){
        $directorData = $this->_CollectionBlogFactory->create();
        return $directorData->getData();
    }
}
