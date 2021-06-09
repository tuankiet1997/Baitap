<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Customer\Model\Session;
use Magento\Checkout\Model\Session as CheckoutSession;

/**
 * Customer edit form block
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class TimeShiping extends Template
{

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
     * @var CheckoutSession
     */
    private $checkoutSession;

    protected $quoteFactory;
    


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
        \Magento\Framework\Serialize\Serializer\Json $serialize,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        CheckoutSession $checkoutSession
    )
    {
        parent::__construct($context, $data);
        $this->_session = $session;
        $this->customer = $customer;
        $this->serialize = $serialize;
        $this->quoteFactory = $quoteFactory;
        $this->checkoutSession = $checkoutSession;
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
     * Checkout quote id
     *
     * @return int
     */
    public function getQouteId()
    {
        return (int)$this->checkoutSession->getQuote()->getId();
    }

    public function getQuoteData()
    {
        $quote = $this->quoteFactory->create()->load($this->getQouteId());
        return $quote;
    }
}