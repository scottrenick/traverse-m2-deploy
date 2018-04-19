<?php
namespace Traverse\Retargeting\Controller\Cart;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Session\SessionManager as SessionManager;
use Traverse\Retargeting\Helper\Data as HelperData;

/**
 * @package Traverse\Retargeting\Controller\Cart
 */

class Data extends \Magento\Framework\App\Action\Action
{
    protected $checkoutSession;
    protected $session;
    protected $helper;
    protected $cart_obj;
   
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        CheckoutSession $checkoutSession,
        SessionManager $sessionManager,
        HelperData $helper
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->session = $sessionManager;
        $this->cart_obj = [
            'type' => 'cart'
        ];
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('/');
            return;
        }

        $cart_obj = null;
        $quote = $this->checkoutSession->getQuote();

        if( ! $quote->hasItems() ) {
            return false;
        }

        $id = $quote->getId();
        $items = $quote->getItems();
        $this->cart_obj['eventUrl'] = $this->helper->getPreviousUrl();
        $this->cart_obj['cart']
             = [
                'id' => "$id",
                'link' => $this->helper->getCartLink(),
                'products' => []
            ];
        $this->cart_obj['cart']['products'] = $this->helper->getTrCartProductArray($items,false);

        $jsonData = json_encode($this->cart_obj);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($jsonData);
    }
}

