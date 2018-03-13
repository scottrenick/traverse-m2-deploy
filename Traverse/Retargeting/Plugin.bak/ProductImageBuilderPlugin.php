<?php

namespace Traverse\Retargeting\Plugin;

class ProductImageBuilderPlugin
{

    public function beforeCreate(\Magento\Catalog\Block\Product\ImageBuilder $subject)
    {
//var_dump($subject);
//die("here");

 $subject->data['data']['custom_attributes'] .= "{'test':'test'}";
//    var_dump($data['data']['custom_attributes'], "");
//die('h-------------------');

    }

}
