<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Customer\Model\Session;

/**
 * Customer edit form block
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class MembershipRenewals extends Template
{

    const XML_RULE_CONFIG = 'setting/customer_rule/';

     /**
     * @var Session
     */
    protected $_session;
    /**
     * @var
     */
    protected $request_interface;

    protected $customer;

    protected $serialize;


    /**
     * MembershipRenewals constructor.
     * @param \SkyPremium\MembershipRenewals\Helper\Data $helper
     * @param Context $context
     * @param array $data
     * @param Session $session
     */
    public function __construct(
        Context $context,
        array $data = [],
        Session $session,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Framework\Serialize\Serializer\Json $serialize
    )
    {
        parent::__construct($context, $data);
        $this->_session = $session;
        $this->customer = $customer;
        $this->serialize = $serialize;
    }

    /**
     * @return mixed|string
     */
    public function getCustomerId()
    {
        $customer_id = '';
        $customer = $this->_session->getCustomer();
        if ($customer) {
            $customer_id = $customer->getId();
        }
        return $customer_id;
    }

    /**
     * @return mixed|string
     */
    public function getCustomerGroupId()
    {
        $customerGroupId = '';
        $customer = $this->_session->getCustomer();
        if ($customer) {
            $customerGroupId = $customer->getGroupId();
        }
        return $customerGroupId;
    }

    public function getLoadProduct()
    {
        $customer_id = $this->getCustomerId();
        return $this->customer->load($customer_id);
    }

    public function checkLogged()
    {
        if($this->_session->isLoggedIn()){
            return true;
        }else{
            return false;
        }
    }

    public function getConfigRule()
    {
        $productcostconfig = $this->_scopeConfig->getValue(
            self::XML_RULE_CONFIG . 'customer_text',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if($productcostconfig == '' || $productcostconfig == null)
            return;

        $unserializedata = $this->serialize->unserialize($productcostconfig);

        $productcostarray = array();
        foreach($unserializedata as $key => $row)
        {
            $productcostarray[] = $row;
        }

        return $productcostarray;
    }
}