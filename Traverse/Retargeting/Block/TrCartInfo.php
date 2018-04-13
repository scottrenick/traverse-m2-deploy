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

            foreach( $items as $item ) {
                $this->cartObj['cart']['products'][] = [
                    'id' => $item->getSku(),
                    'quantity' => $item->getQty(),
                    'price' => $item->getPrice(),
                    'currency'=> $this->helper->getCurrencyCode()
                ];
            }
            $data = $this->cartObj;
        }

        $this->helper->displayJsonDataDiv($data, 'tr-data-cart');
    }


}
