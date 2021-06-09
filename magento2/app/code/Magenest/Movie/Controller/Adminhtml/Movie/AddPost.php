<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Framework\Message\Manager;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magenest\Movie\Model\MovieFactory;
use Magenest\Movie\Model\PriceChairFactory;

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

    protected $_movieFactory;

    protected $_priceChairFactory;

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
        MovieFactory $movieFactory,
        PriceChairFactory $priceChairFactory,
		\Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
		Manager $messageManager,
		ScopeConfigInterface $scopeConfig
	)
	{
		$this->dataObjectHelper = $dataObjectHelper;
        $this->request = $request;
		$this->messageManager = $messageManager;
		$this->_scopeConfig = $scopeConfig;
        $this->_movieFactory = $movieFactory;
        $this->_priceChairFactory =  $priceChairFactory;
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
            $priceAndChair = $data['contact']['dynamic_rows_container']['dynamic_rows_container'];
                $dataMovie = [
                    'name' => $data['contact']['name'],
                    'description' => $data['contact']['description'],
                    'rating' => $data['contact']['rating'],
                    'director_id' =>$data['contact']['director_id']
                ];
                $movieData = $this->_movieFactory->create();
                $movieData->setData($dataMovie)->save();

                foreach($priceAndChair as $item){
                    $dataPrice = [
                        'movie_id' => $movieData->getData('movie_id'),
                        'chair_id' => $item['chair_id'],
                        'price_movie'=> $item['price_movie']
                    ];
                    $priceChair = $this->_priceChairFactory->create();
                    $priceChair->setData($dataPrice)->save();
                }
                $this->_eventManager->dispatch(
                    'controller_action_movie_save_after',
                    ['controller' => $this, 'movie' => $movieData]
                );

        } catch (\Exception $e) {
            var_dump($e);die();
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        $this->messageManager->addSuccessMessage("Save Success" . ' ' .  $data['contact']['name']);
        return $resultRedirect;
	}
}
