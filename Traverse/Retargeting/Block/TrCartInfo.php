<?php
namespace Traverse\Retargeting\Block;

/**
 * Class \Traverse\Retargeting\Block\TrCartInfo
 */
class TrCartInfo extends \Magento\Framework\View\Element\Template
{

    protected $checkoutSession;
    protected $helper;
    protected $cartObj;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Traverse\Retargeting\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\View\Element\Template\Context $context,
        \Traverse\Retargeting\Helper\Data $helper,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
        $this->cartObj = [];
        parent::__construct($context,$data);
    }

    public function displayCartData() {
        $data = [];

        $quote = $this->checkoutSession->getQuote();

        if( $quote->hasItems() ) {

            $id = $quote->getId();
            $items = $quote->getItems();
            $this->cartObj['cart']
                 = [
                    'id' => "$id",
                    'link' => $this->helper->getCartLink(),
                    'products' => []
                ];
            $this->cartObj['event_url'] = $this->helper->getEventUrl();
            $this->cartObj['cart']['products'] = $this->helper->getTrCartProductArray($items);
/*
            foreach( $items as $item ) {
                $this->cartObj['cart']['products'][] = [
                    'currency'=> $this->helper->getCurrencyCode(),
                    'description' => urlencode($item->getProduct()->getDescription()),
                    'id' => $item->getSku(),
                    'name' => urlencode($item->getProduct()->getName()),
                    'quantity' => $item->getQty(),
                    'price' => $item->getPrice(),
                    'url' => $item->getProduct()->getProductUrl()
                ];
            }
*/
            $data = $this->cartObj;
        }
//var_dump($data);
//die('---------------');

        $this->helper->displayJsonDataDiv($data, 'tr-data-cart');
    }


}
