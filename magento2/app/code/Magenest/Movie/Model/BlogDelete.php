<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Integration\Model\Oauth\TokenFactory;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magenest\Movie\Model\BlogFactory;
/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BlogDelete implements \Magenest\Movie\Api\BlogDeleteInterface
{
    protected $request;

    /**
     * @var \Magento\Integration\Model\Oauth\Token
     */
    protected $tokenFactory;

    protected $_blogFactory;


    /**
     * @param TokenFactory $tokenFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @codeCoverageIgnore
     */
    public function __construct(
        TokenFactory $tokenFactory,
        BlogFactory $blogFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magenest\Movie\Api\Data\InfoResultInterface $infoResult
    ) {
        $this->tokenFactory = $tokenFactory;
        $this->_blogFactory = $blogFactory;
        $this->_infoResult = $infoResult;
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     * @param string[] $data
     * @param int $Id
     * @return array|\Magenest\Movie\Api\Data\InfoResultInterface
     */
    public function Delete($id)
    {
        try{
            $result = $this->_infoResult;
            $blogData = $this->_blogFactory->create();
            if($id){
				$blogData->load($id);
				$blogData->delete();
            }
            $result->setCode(200);
            $result->setData([]);
            $result->setMessage("Delete Data Blog success.");
            return $result;
        }catch(\Exception $e){
            $result->setCode(400);
            $result->setData([]);
            $result->setMessage("Error:".$e->getMessage());
            return $result;
        }
    }
}