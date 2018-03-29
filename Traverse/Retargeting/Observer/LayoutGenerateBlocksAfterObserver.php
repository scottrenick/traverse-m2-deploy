<?php

namespace Traverse\Retargeting\Observer;
use Magento\Framework\Event\ObserverInterface;
use Traverse\Retargeting\Helper\Data;

class LayoutGenerateBlocksAfterObserver implements ObserverInterface {

    protected $_data;

    /**
     * @param Magento\Framework\Event\Observer $observer
     */
    public function __construct( 
        Data $data
    )
    {
        $this->_data = $data;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
   public function execute(\Magento\Framework\Event\Observer $observer)
    {
//file_put_contents('/tmp/datalayer.log', $_SERVER['PHP_SELF'], FILE_APPEND );

        $dl = $this->_data->getDataLayerScript();
        print_r($dl);
die('====================');
//        $layout = $observer->getEvent()->getLayout();

/*
$str = <<<EOD
<script>
    require(
    ["jquery"], 
    function($){
       console.log('----------------hfweeeee------------'); 
       console.log('----------------heeeee------------'); 
    });
</script>
EOD;

echo($str);


        $layout = $observer->getEvent()->getLayout();
echo("<pre>");
       var_dump($layout);
echo("</pre>");
die( '-===============');
$head = $layout->getBlock('head');
echo("<pre>");
print_r($head);
//print_r(get_class_methods($layout));
echo("</pre>");
die("\nssssssssssssssssmig");
        $xml = $layout->getXmlString();
print_r(substr($xml,0,100));
die("----------------");
$newxmlstring =  str_replace('<script src="requirejs/require.js"/>','<script src="https://static.traversedlp.com/v1/retargeting.js" src_type="url" />,script src="requirejs/require.js"/>',$xml);
        $newxml = $layout->generateXml();
        $layout->generateXml($xml);
       // $observer->getEvent()->getLayout()->setXml($newxml);
*/
        return $this;
    }


}
