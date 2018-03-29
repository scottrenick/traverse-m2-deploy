<?php

namespace Traverse\Retargeting\Model\Checkout\CustomerData;

class Cart extends \Magento\Checkout\CustomerData\Cart
{

    /**
     * @var Traverse\Retargeting\Helper\Data
     */
    protected $helper;
    
    /**
     * @var Traverse\Retargeting\Model\DataLayer
     */
    protected $dataLayer;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Catalog\Model\ResourceModel\Url $catalogUrl
     * @param \Magento\Checkout\Model\Cart $checkoutCart
     * @param \Magento\Checkout\Helper\Data $checkoutHelper
     * @param \Magento\Checkout\CustomerData\ItemPool $itemPoolInterface
     * @param \Magento\Framework\View\LayoutInterface $layout
     * @param \Traverse\Retargeting\Model\DataLayer $dataLayer
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Model\ResourceModel\Url $catalogUrl,
        \Magento\Checkout\Model\Cart $checkoutCart,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \Magento\Checkout\CustomerData\ItemPool $itemPoolInterface,
        \Magento\Framework\View\LayoutInterface $layout,
        \Traverse\Retargeting\Helper\Data $helper,
        \Traverse\Retargeting\Model\DataLayer $dataLayer,
        array $data = []
    ) {
        parent::__construct($checkoutSession, $catalogUrl, $checkoutCart, $checkoutHelper, $itemPoolInterface, $layout,$data);
        $this->helper = $helper;
        $this->dataLayer = $dataLayer;
    }
/*
    public function getSectionData()
    {
        $totals = $this->getQuote()->getTotals();
        $subtotalAmount = $totals['subtotal']->getValue();
        $data = [
            'summary_count' => $this->getSummaryCount(),
            'subtotalAmount' => $subtotalAmount,
            'subtotal' => isset($totals['subtotal'])
                ? $this->checkoutHelper->formatPrice($subtotalAmount)
                : 0,
            'possible_onepage_checkout' => $this->isPossibleOnepageCheckout(),
            'items' => $this->getRecentItems(),
            'extra_actions' => $this->layout->createBlock(\Magento\Catalog\Block\ShortcutButtons::class)->toHtml(),
            'isGuestCheckoutAllowed' => $this->isGuestCheckoutAllowed(),
            'website_id' => $this->getQuote()->getStore()->getWebsiteId()
        ];

        $this->dataLayer->add('section_data',$data);

        return $data;
    }
*/


}
