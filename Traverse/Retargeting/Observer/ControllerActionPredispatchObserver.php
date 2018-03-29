<?php

namespace Traverse\Retargeting\Observer;
use Magento\Framework\Event\ObserverInterface;
use Traverse\Retargeting\Helper\Data;
use Traverse\Retargeting\Model\DataLayer;

class ControllerActionPredispatchObserver implements ObserverInterface {

    protected $data;
    
    protected $datalayer;

    /**
     * @param Magento\Framework\Event\Observer $observer
     */
    public function __construct( 
        DataLayer $datalayer,
        Data $data
    )
    {
        $this->data = $data;
        $this->datalayer = $datalayer;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
   public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->datalayer->cartUpdate();
    }
}
