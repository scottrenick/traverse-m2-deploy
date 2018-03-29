<?php

namespace Traverse\Retargeting\Observer;
use Magento\Framework\Event\ObserverInterface;
use Traverse\Retargeting\Helper\Data;
use Traverse\Retargeting\Model\DataLayer;

class ControllerFrontSendResponseBeforeObserver implements ObserverInterface {

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
file_put_contents('/tmp/diff.log',"Hit-------------\n", FILE_APPEND);
        $this->datalayer->cartUpdate();
    }
}
