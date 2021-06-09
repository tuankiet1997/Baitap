<?php

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Framework\Message\Manager;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magenest\Movie\Model\ActorFactory;

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

    protected $_actorFactory;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param ActorFactory $actorFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param Manager $messageManager
     */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        ActorFactory $actorFactory,
		\Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
		Manager $messageManager,
		ScopeConfigInterface $scopeConfig
	)
	{
		$this->dataObjectHelper = $dataObjectHelper;
        $this->request = $request;
		$this->messageManager = $messageManager;
		$this->_scopeConfig = $scopeConfig;
        $this->_actorFactory = $actorFactory;
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
                $dataActor = [
                    'name' => $data['name']
                ]; 
                $directorData = $this->_actorFactory->create();
                $directorData->setData($dataActor)->save();

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $tableNameActor = $resource->getTableName('magenest_actor');
                $connection = $resource->getConnection();
                $sqlActor = "select actor_id FROM ". $tableNameActor . " where name = '" . $data['name'] . "'";
                $resultActorId = $connection->fetchAll($sqlActor);

                $sql = "insert into magenest_movie_actor (`movie_id`, `actor_id`) values (".$data['history']['movie']." , ".$resultActorId[0]['actor_id'].")";
                $connection->query($sql);
            }
            
        } catch (\Exception $e) {
            var_dump($e);die();
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        $this->messageManager->addSuccessMessage("Save Success" . ' ' .  $data['name']);
        return $resultRedirect;
	}
}