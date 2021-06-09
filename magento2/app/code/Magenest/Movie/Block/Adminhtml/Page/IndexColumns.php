<?php
namespace Magenest\Movie\Block\Adminhtml\Page;

class IndexColumns extends \Magento\Backend\Block\Template
{

    protected $_coreRegistry = null;


    /**
     * @var \Magenest\Movie\Model\ResourceModel\Director\ConllectionDirectorFactory
     */
    protected $_conllectionDirectorFactory;


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
        array $data = []
    ) {
        $this->_coreRegistry         = $coreRegistry;
        $this->_conllectionDirectorFactory = $conllectionDirectorFactory;
        parent::__construct($context, $data);
    }

    public function getPage()
    {
        return "Test";
    }
}
