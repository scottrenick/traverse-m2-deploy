<?php

namespace Traverse\Retargeting\Plugin;

class QuoteSaveAfterPlugin
{


    /**
     * @var QuoteSaveAfterPlugin
     */
    protected $_helper;

    public function __construct(\Traverse\Retargeting\Helper\Data $helper)
    {
        $this->_helper = $helper;
    }


    public function beforeExecute(\Magento\Checkout\Observer\SalesQuoteSaveAfterObserver $subject, $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        die($quote->getId()); 
    }

}
