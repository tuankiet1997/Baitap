<?php

namespace Magenest\Movie\Controller\Adminhtml\Banner;

use Magento\Framework\Message\Manager;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magenest\Movie\Model\BannerFactory;

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

    protected $_bannerFactory;

	protected $authSession;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param MovieFactory $movieFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param Manager $messageManager
     */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        BannerFactory $bannerFactory,
		\Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
		\Magento\Backend\Model\Auth\Session $authSession,
		Manager $messageManager,
		ScopeConfigInterface $scopeConfig
	)
	{
		$this->dataObjectHelper = $dataObjectHelper;
        $this->request = $request;
		$this->messageManager = $messageManager;
		$this->_scopeConfig = $scopeConfig;
        $this->_bannerFactory = $bannerFactory;
		$this->authSession = $authSession;
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
			$id = !empty($data['banner']['id']) ? $data['banner']['id'] : null;
			$dataBlog = [
				'title' => $data['banner']['title'],
				'link' => $data['banner']['link'],
                'name' => $data['banner']['name'],
				'add_text' => $data['banner']['add_text'],
				'upload_image' => $data['banner']['filesubmission'][0]['url'],
				'status' =>$data['banner']['status']
			];
			$bannerData = $this->_bannerFactory->create();
			if($id){
				$bannerData->load($id);
				$bannerData->addData($dataBlog);
				$bannerData->setId($id);
				$bannerData->save();
			}else{
				$bannerData->setData($dataBlog)->save();			
			}

			$resultRedirect = $this->resultRedirectFactory->create();
			$resultRedirect->setPath('*/*/');
			$this->messageManager->addSuccessMessage("Save Success" . ' ' .  $data['banner']['title']);
			return $resultRedirect;
            
        } catch (\Exception $e) {
            var_dump($e);die();
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
	}

	public function getCurrentUser()
	{
		return $this->authSession->getUser();
	}
}