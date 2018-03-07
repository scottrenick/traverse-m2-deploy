<?php

namespace Traverse\Retargeting\Observer;
use Magento\Framework\Event\ObserverInterface;

class LayoutLoadBeforeObserver implements ObserverInterface {
    /**
     * @var \Magento\Framework\Event\Observer
     */
    //protected $_observer;

    /**
     * @param Magento\Framework\Event\Observer $observer
     */
/*
    public function __construct(
        Observer $observer
    {
        $this->_observer = $observer;
    }
*/

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
   public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $layout = $observer->getEvent()->getLayout();
//var_dump(get_class_methods($observer->getEvent()->getBlock()));
//die('===============');
/*
/$head = $layout->getBlock('header');
echo("<pre>");
//print_r($head);
print_r(get_class_methods($layout));
echo("</pre>");
die("\nssssssssssssssssmig");

        $xml = $layout->getXmlString();
$newxmlstring =  str_replace('<script src="requirejs/require.js"/>','<script src="https://static.traversedlp.com/v1/retargeting.js" src_type="url" />,script src="requirejs/require.js"/>',$xml);
var_dump(substr($xml,0,100));
die("----------------");
        //$newxml = $layout->generateXml($xml);
        //$observer->getEvent()->getLayout()->setXml($newxml);
        //$observer->getEvent()->getLayout()->loadstring($newxmlstring);
        var_dump($layout->loadstring($newxmlstring));
die("here");
//        $layout->setXml($layout->loadstring($newxmlstring));
*/
        return $this;
    }


}
