<?php

namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Framework\Message\Manager;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magenest\Movie\Model\DirectorFactory;

class AddPost extends \Magento\Backend\App\Action
{

	/**
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @var \Magento\Framework\Api\DataObjectHelper
	 */
	protected $dataObjectHelper;

	/**
	 * @var Manager
	 */
	protected $messageManager;

	/**
     * 20210414 - WIKI Kiet Ngo
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    protected $_directorFactory;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param DirectorFactory $directorFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param Manager $messageManager
     */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        DirectorFactory $directorFactory,
		\Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
		Manager $messageManager,
		ScopeConfigInterface $scopeConfig
	)
	{
		$this->dataObjectHelper = $dataObjectHelper;
        $this->request = $request;
		$this->messageManager = $messageManager;
		$this->_scopeConfig = $scopeConfig;
        $this->_directorFactory = $directorFactory;
        parent::__construct($context);
	}

	/**
	 * Save action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
        try {
            $data = $this->request->getParams();
            if($data){
                $directorName = $data['name'];
                $data = [
                    'name' => $data['name']
                ]; 
                $directorData = $this->_directorFactory->create();
                $directorData->setData($data)->save();
            }
            
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        $this->messageManager->addSuccessMessage("Save Success" . ' ' .  $data['name']);
        return $resultRedirect;
	}
}