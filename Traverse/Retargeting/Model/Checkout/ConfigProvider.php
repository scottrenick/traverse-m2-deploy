<?php

namespace Traverse\Retargeting\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** 
     *@var LayoutInterface  
     */
    protected $_layout;
    
    /** 
     *@var Traverse\Retargeting\Helper
     */
    protected $_helper;

    public function __construct(
        LayoutInterface $layout,
        \Traverse\Retargeting\Helper\Data $helper
    )
    {
        $this->_layout = $layout;
        $this->_helper = $helper;
    }

    public function getConfig()
    {
        return array();
        return [
            'tr.place.order' => $this->_helper->createBlock('Checkout\TrPlaceOrder','checkout/place_order.phtml')
        ];
    }
}
