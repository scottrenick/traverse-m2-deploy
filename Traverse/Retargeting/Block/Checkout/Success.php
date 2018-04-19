<?php
namespace Traverse\Retargeting\Block\Checkout;

class Success extends \Magento\Checkout\Block\Success
{

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;


    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
 	 * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\OrderFactory $orderFactory,
 		\Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        parent::__construct($context, $orderFactory,$data);
		$this->checkoutSession = $checkoutSession;
    }

	public function getTrData() {
		return $this->checkoutSession->getTrPurchaseData();
	}

}
