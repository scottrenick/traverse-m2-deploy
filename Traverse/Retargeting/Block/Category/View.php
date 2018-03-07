<?php
namespace Traverse\Retargeting\Block\Category;


class View extends \Magento\Catalog\Block\Category\View
{
    protected $helper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param \Traverse\Retargeting\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Traverse\Retargeting\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $layerResolver, $registry, $categoryHelper);
        $this->helper = $helper;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $category = $this->getCurrentCategory();
        $isEnabled = $this->helper->isEnabled();
        if ($isEnabled && $category) {
            $cat_id = $category->getId();
            $cat_name = urlencode($category->getName());
            $cat_link = $category->getUrl();
            $cat_desc = urlencode($category->getDescription());
            $evt_url = $this->helper->getPreviousUrl();
            $data = "{'event_url':'$evt_url', 'id':'$cat_id', 'name':'$cat_name', 'url':'$cat_link', 'description':'$cat_desc'}";
            $this->pageConfig->setElementAttribute("body", 'data-tr-category', $data);
        }
        return $this;
    }
}
