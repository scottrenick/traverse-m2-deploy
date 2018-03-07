<?php
namespace Traverse\Retargeting\Block\Product;

/**
 * Class \Traverse\Retargeting\Block\Product\TrAddToCart
 */
class TrAddToCart extends \Traverse\Retargeting\Block\TrBase
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
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        parent::__construct(
            $context,$pricingHelper,$catalogData,$jsonEncoder,
            $option,$registry,$arrayUtils,$helper,$datalayer,$data);
    }

    public function displayInitCode() {
        $this->helper->displayInitCode();
    }

    public function displayDataDiv() {
        $prod = $this->getProduct();
        $event_url = $this->helper->getEventUrl();
        $prod_url = $prod->getProductUrl(); 
        $prod_id = $prod->getId();
        $prod_sku = $prod->getSku();
        $prod_price = $prod->getPrice();
        $prod_currency = $this->storeManager->getStore()->getCurrentCurrencyCode();
        $prod_data = array(
                    //'prod_id'=>$prod_id,
                    'id'=>$prod_sku,
                    'price'=>$prod_price,
                    'currency'=>$prod_currency); 
        $event_data = array(
                        'event_url'=>$event_url,
                        'target_url' =>$prod_url
                    );
        $this->helper->displayJsonDataDiv($prod_data, 'tr-data-product'); 
        $this->helper->displayJsonDataDiv($event_data, 'tr-data-event'); 
    }
}
