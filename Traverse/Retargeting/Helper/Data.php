<?php

namespace Traverse\Retargeting\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper {
    
    /**
     * @var array
     */
    protected $_options;

   /**
     * @var \Magento\Framework\Escaper $escaper
     */
    protected $_escaper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Magento\Framework\View\Element\BlockFactory
     */
    protected $_blockFactory;

    /**
     * @var array
     */
    protected $_storeCategories;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category
     */
    protected $_resourceCategory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var \Magento\Checkout\Model\Session\SuccessValidator
     */
    protected $_checkoutSuccessValidator;
    
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;

    /**
     * @var Magento\Integration\Model\IntegrationService
     */
    protected $_integration;
    
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_session;
    
    /**
     * @var Magento\Framework\UrlInterface
     */
    protected $_urlInterface;
    

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Category $resourceCategory,
        \Magento\Framework\View\Element\BlockFactory $blockFactory,
        \Magento\Framework\Escaper $escaper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\Session\SuccessValidator $checkoutSuccessValidator,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Integration\Model\IntegrationService $integration,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\UrlInterface $urlInterface
    )
    {
        parent::__construct($context);
        $this->_options = $this->scopeConfig->getValue('traverse_retargeting', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $this->_registry = $registry;
        $this->_resourceCategory = $resourceCategory;
        $this->_blockFactory = $blockFactory;
        $this->_storeCategories = [];
        $this->_orderRepository = $orderRepository;
        $this->_escaper = $escaper;
        $this->_storeManager = $storeManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_checkoutSuccessValidator = $checkoutSuccessValidator;
        $this->_backendUrl = $backendUrl;
        $this->_integration = $integration;
        $this->_session = $session;
        $this->_urlInterface = $urlInterface;
    }

    /**
     * @return boolean
     */
    public function isEnabled( $section = null)
    {
        $rtn = false;
        switch( $section ) {
            case null: $rtn =  $this->isExtensionEnabled(); break;
            case 'cartAbandon' : $rtn =  $this->isExtensionEnabled() && isSiteAbandonEnabled(); break;
            case 'siteAbandon' : $rtn =  $this->isExtensionEnabled() && isCartAbandonEnabled(); break;
        }
        return $rtn;
    }
    
    /**
     * @return boolean
     */
    public function isExtensionEnabled()
    {
        return $this->_options['general']['enable'];
    }
    
    /**
     * @return boolean
     */
    public function isSiteAbandonEnabled()
    {
        return $this->_options['general']['enable_site_abandon'];
    }
    
    /**
     * @return boolean
     */
    public function isCartAbandonEnabled()
    {
        return $this->_options['general']['enable_cart_abandon'];
    }

    public function getCurrencyCode() {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

    public function getTrProductData($product) {
        $event_url = $this->getEventUrl();
        $prod_id = $product->getId();
        $prod_sku = $product->getSku();
        $prod_url = $product->getProductUrl();
        $prod_price = $product->getFinalPrice();
        $prod_currency = $this->getCurrencyCode();
        $prod_name = urlencode($product->getName());
        $prod_image = $product->getImage();
        $prod_desc = urlencode($product->getDescription());

		$data = ['event_url'=>$event_url, 'id'=>$prod_id, 'sku'=>$prod_sku, 'prod_url'=>$prod_url, 'price'=>$prod_price, 'currency'=>$prod_currency,'name'=>$prod_name,'image'=>$prod_image,'description'=>$prod_desc];

        return json_encode($data);
    }
    
    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->_session->getSessionId();
    }
    
    /**
     * @return string
     */
    public function getEventUrl()
    {
        return $this->_urlInterface->getCurrentUrl();
    }
    
    /**
     * @return string
     */
    public function getHomeUrl()
    {
        return $this->_urlInterface->getBaseUrl();
    }
    
    /**
     * @return string
     */
    public function getCartLink()
    {
        return $this->_storeManager->getStore()->getBaseUrl() . 'checkout/cart/';
    }
    
    /**
     * @return string
     */
    public function getPreviousUrl()
    {
        $rtn = $this->getHomeUrl();
        if( array_key_exists( 'HTTP_REFERER', $_SERVER ) ) {
            $rtn = $_SERVER['HTTP_REFERER'];
        }
        return $rtn;
    }
    
    /**
     * @return string
     */
    public function getPropertyId()
    {
        return $this->_options['general']['tr_prop_id'];
    }
    
    /**
     * @return string
     */
    public function enableDebug()
    {
        return $this->_options['general']['tr_enable_debug'];
    }
    
    /**
     * @return string
     */
    public function getDataLayerScript()
    {
        $script = '';

        if (!($block = $this->createBlock('Core', 'datalayer.phtml'))) {
            return $script;
        }

//        $this->addDefaultInformation();
//        $this->addCategoryPageInformation();
//        $this->addSearchResultPageInformation();
//        $this->addProductPageInformation();
//        $this->addCartPageInformation();
//        $this->addCheckoutInformation();
//        $this->addOrderInformation();

        $html = $block->toHtml();

        return $html;
    }

    /**
     * @return string
     */
    public function displayJsClassCode($target,$jsclass) {
        $initCode = '<script type="text/x-magento-init"> { "';
        $initCode .= $target . '": { "';
        $initCode .= $jsclass . '": {} } } </script>';
        echo $initCode;
    }
    
    /**
     * @return string
     */
    public function displayInitCode() {
        $sess_id = $this->getSessionId();
        $prop_id = $this->getPropertyId();
        $debug = $this->enableDebug() ? 'true' : 'false';
        $initCode =<<<EOD
<script>
    require(
    ["jquery"], 
    function($){
        $( function () {
            TraverseRetargeting.init({
              propertyId: "$prop_id",
              sessionId: "$sess_id",
              debug: $debug
            });
        });
    });
</script>

EOD;
        echo $initCode;
    }

    public function getJsonDataInsert($array) {
        $jsonData = json_encode($array);
        $dataIns = 'data-tr-data=' . $jsonData;
        $code = $dataIns;
        return $code;
    }

    public function displayJsonDataDiv($array, $divid = 'tr-data-container') {
        $jsonData = json_encode($array);
        $dataIns = 'data-trdata=' . $jsonData;
        $code = "<span id='" . $divid ."' " . $dataIns . " />";
        echo $code;
    }

    public function getIntegrationLink() {
        $integration = $this->_integration->findByName('Traverse Api');
        $url = $this->_backendUrl->getUrl("adminhtml/integration");
        
        if(! $integration->isEmpty()) {
            $int_id = $integration->getIntegrationId();
            $url = $this->_backendUrl->getUrl("adminhtml/integration/edit/id/$int_id");
        }
        
        return '<a href="' . $url . '">Integration Credential</a>';
    }

    /**
     * @param $blockName
     * @param $template
     * @return bool
     */
    protected function createBlock($blockName, $template)
    {
        if ($block = $this->_blockFactory->createBlock("\Traverse\Retargeting\Block" . "\\" . $blockName)
            ->setTemplate('Traverse_Retargeting::' . $template)
        ) {
            return $block;
        }

        return false;
    }

}
