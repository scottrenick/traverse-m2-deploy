<?php
namespace Traverse\Retargeting\Block;

/**
 * Class \Traverse\Retargeting\Block\TrBase
 */
class TrBase extends \Magento\Catalog\Block\Product\View\Options
{
    /**
     * @var \Traverse\Retargeting\Helper\Data
     */
    protected $helper;

    /**
     * @var \Traverse\Retargeting\Model\DataLayer
     */
    protected $datalayer;

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
        array $data = []
    ) {
        $this->helper = $helper;
        $this->datalayer = $datalayer;
        parent::__construct($context,$pricingHelper,$catalogData,$jsonEncoder,$option,$registry,$arrayUtils,$data);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helper->isEnabled();
    }

    /**
     * @return string
     */
    public function displayJsClassCode($target,$jsclass) {
        $this->helper-> displayJsClassCode($target,$jsclass);
    }


}
