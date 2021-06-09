<?php
namespace Magenest\Movie\Block\Adminhtml\Director;

class Add extends \Magento\Backend\Block\Template
{

    protected $_coreRegistry = null;


    /**
     * Index constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry         = $coreRegistry;
        parent::__construct($context, $data);
    }

     /**
     * Submit URL getter
     *
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl('magenest/director/addPost');
    }
}
