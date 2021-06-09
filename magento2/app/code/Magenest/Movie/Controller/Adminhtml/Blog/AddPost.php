<?php

namespace Magenest\Movie\Controller\Adminhtml\Blog;

use Magento\Framework\Message\Manager;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magenest\Movie\Model\BlogFactory;

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

    protected $_blogFactory;

	protected $authSession;

	/**
    * @var \Magento\UrlRewrite\Model\UrlRewriteFactory
    */
    protected $_urlRewriteFactory;

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
        BlogFactory $blogFactory,
		\Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
		\Magento\Backend\Model\Auth\Session $authSession,
		Manager $messageManager,
		ScopeConfigInterface $scopeConfig,
		\Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory
	)
	{
		$this->dataObjectHelper = $dataObjectHelper;
        $this->request = $request;
		$this->messageManager = $messageManager;
		$this->_scopeConfig = $scopeConfig;
        $this->_blogFactory = $blogFactory;
		$this->authSession = $authSession;
		$this->_urlRewriteFactory = $urlRewriteFactory;
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
			$id = !empty($data['blog']['id']) ? $data['blog']['id'] : null;
			$dataBlog = [
				'title' => $data['blog']['title'],
				'description' => $data['blog']['description'],
				'author_id' => $this->getCurrentUser()->getId(),
				'content' => $data['blog']['content'],
				'url_rewrite' =>$data['blog']['url_rewrite'],
				'status' =>$data['blog']['status']
			];
			$blogData = $this->_blogFactory->create();
			if($id){
				$blogData->load($id);
				$blogData->addData($dataBlog);
				$blogData->setId($id);
				$blogData->save();
			}else{
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
				$connection = $resource->getConnection();
				$tableName = $resource->getTableName('magenest_blog');
				$urlRewrite = $data['blog']['url_rewrite'];
				$select = "select * FROM ". $tableName . " where url_rewrite = '".$urlRewrite."'";
				$result = $connection->fetchAll($select);
				if(count($result) != 0){
					$this->messageManager->addErrorMessage(("already exist url_rewrite."));
					$resultRedirect = $this->resultRedirectFactory->create();
					$resultRedirect->setRefererOrBaseUrl();
					return $resultRedirect;
				}else{
					$blogData->setData($dataBlog)->save();
					$urlRewriteModel = $this->_urlRewriteFactory->create();
					 $urlRewriteModel->setStoreId(1);
					 $urlRewriteModel->setIsSystem(0);
					 $urlRewriteModel->setIdPath(rand(1, 100000));
					 $urlRewriteModel->setTargetPath('magenest/blog/view/id/' . $blogData->getData('id'));
					 $urlRewriteModel->setRequestPath($blogData->getData('url_rewrite'));
					 $urlRewriteModel->save();
				}
			}
			$resultRedirect = $this->resultRedirectFactory->create();
			$resultRedirect->setPath('*/*/');
			$this->messageManager->addSuccessMessage("Save Success" . ' ' .  $data['blog']['title']);
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
