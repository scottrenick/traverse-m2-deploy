<?php
namespace Traverse\Retargeting\Observer;

use Magento\Framework\Event\ObserverInterface;

class CheckoutSuccessObserver implements ObserverInterface
{
    /**
     * @var \Traverse\Retargeting\Helper\Data 
     */
    protected $helper;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;
    
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;
    
    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quoteFactory;
    
    /**
     * @var  Array
     */
    protected $purchase_obj;
    protected $onepageController;


    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct( 
        \Traverse\Retargeting\Helper\Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Checkout\Controller\Onepage $onepageController
    )
    {
        $this->helper = $helper;
        $this->checkoutSession = $checkoutSession;
        $this->orderFactory = $orderFactory;
        $this->quoteFactory = $quoteFactory;
        $this->onepageController = $onepageController;
        $this->purchase_obj = [
            'type' => 'purchase'
        ];

    }
    
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->helper->isEnabled()) {
            return $this;
        }
        $opSession = $this->onepageController->getOnepage()->getCheckout();
        $orderId = $opSession->getLastOrderId();
        $purchase_obj = null;
        $order = $this->orderFactory->create()->load($orderId);
        $quoteFactory = $this->quoteFactory->create();
        $quote = $quoteFactory->load($order->getQuoteId());
        $quote->setIsActive(true);
        
        if( ! $quote->hasItems() ) {
            return false;
        }

        $id = $quote->getId();
        $items = $quote->getItemsCollection();
        $this->purchase_obj['eventUrl'] = $this->helper->getEventUrl();
        $this->purchase_obj['cart']
             = [
                'id' => "$id",
                'link' => $this->helper->getCartLink(),
                'products' => []
            ];
        $this->purchase_obj['cart']['products'] = $this->helper->getTrCartProductArray($items);
        $json_purchase = $this->helper->getJsonDataInsert($this->purchase_obj);
        $this->checkoutSession->setTrPurchaseData($this->helper->getJsonDataInsert($this->purchase_obj));
        return $this;
    }
}
