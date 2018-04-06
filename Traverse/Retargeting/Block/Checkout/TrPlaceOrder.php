<?php
namespace Traverse\Retargeting\Block\Checkout;

/**
 * Class \Traverse\Retargeting\Block\Checkout\TrPlaceOrder
 */
class TrPlaceOrder extends \Traverse\Retargeting\Block\TrBase
{
    protected $storeManager;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Pricing\Helper\Data $pricingHelper
     * @param \Magento\Catalog\Helper\Data $catalogData
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Catalog\Model\Product\Option $option
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Stdlib\ArrayUtils $arrayUtils
     * @param \Traverse\Retargeting\Helper\Data $helper
     * @param \Traverse\Retargeting\Model\DataLayer $datalayer
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Magento\Catalog\Helper\Data $catalogData,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Catalog\Model\Product\Option $option,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        \Traverse\Retargeting\Helper\Data $helper,
        \Traverse\Retargeting\Model\DataLayer $datalayer,
//        \Magento\Directory\Model\Currency $currency, 
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        parent::__construct(
            $context,$pricingHelper,$catalogData,$jsonEncoder,
            $option,$registry,$arrayUtils,$helper,$datalayer,$data);
    }

    public function displayDataDiv() {

        $event_url = $this->helper->getEventUrl();
        $cart_url = $this->_storeManager->getStore()->getBaseUrl() . '/checkout/cart';
        $prod_currency = $this->storeManager->getStore()->getCurrentCurrencyCode();
        $event_data = array( 'event_url'=>$event_url, 'currency'=>$prod_currency, 'cart_url'=>$cart_url );
        $this->helper->displayJsonDataDiv($event_data, 'tr-data-event'); 
    }
}
