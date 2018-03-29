<?php
namespace Traverse\Retargeting\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Traverse\Retargeting\Helper\Data;

class Token extends \Magento\Config\Block\System\Config\Form\Field {    
	
	
 /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context, 
        Data $helper,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_helper = $helper;
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $link = $this->_helper->getIntegrationLink();
        $element->setText($link);
        return $element->getElementHtml();
    }
}
