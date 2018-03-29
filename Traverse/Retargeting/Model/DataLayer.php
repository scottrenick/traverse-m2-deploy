<?php
namespace Traverse\Retargeting\Model;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Session\SessionManager as SessionManager;
use Traverse\Retargeting\Helper\Data;

/**
 * Class \Traverse\Retargeting\Model\DataLayer
 */
class DataLayer extends \Magento\Framework\Model\AbstractModel
{
    protected $checkoutSession;
    protected $session;
    protected $data_layer;
    protected $cart_obj;
    
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        CheckoutSession $checkoutSession,
        SessionManager $sessionManager,
        Data $helper
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->session = $sessionManager;
        $this->data_layer = [];
        $this->cart_obj = [
            'type' => 'cart',
            'eventUrl' => $_SERVER['REQUEST_URI'],
        ];
        $this->helper = $helper;
        parent::__construct($context, $registry);
    }

    public function setCartStatus() {
            $session =  $this->session->getData('trDataLayer');
            $changed = $this->isCartChanged();

//file_put_contents('/tmp/diff.log',"setCartStattus isCartChanged---------------------\n", FILE_APPEND);
//file_put_contents('/tmp/diff.log',print_r($changed,true), FILE_APPEND);

            $this->data_layer = $session;
            $this->data_layer['cartChanged'] = $changed;

            // update previous session state on 'orig'
            if( array_key_exists('current', $this->data_layer) ) {
                $this->data_layer['orig'] = $this->data_layer['current'];
            }
            
            $this->session->setData('trDataLayer', $this->data_layer );
    }

    public function isCartChanged() {
        $rtn = false;
/*
        $session =  $this->session->getData('trDataLayer');
        $orig = array_key_exists('orig',$session) ? $session['orig'] : [];
        $new = array_key_exists('current',$session) ? $session['current'] : [];
*/
        $dl =  $this->data_layer;
        $orig = array_key_exists('orig',$dl) ? $dl['orig'] : [];
        $new = array_key_exists('current',$dl) ? $dl['current'] : [];
        
        $diff = $this->check_cart_diff($new,$orig);       
        
        if( ! empty( $diff )) {
            $rtn = true;
        }

        return $rtn;
    }

    protected function check_cart_diff($current, $original){
        $prods1 = $this->get_cart_product($current); 
        $prods2 = $this->get_cart_product($original);

        // check initial load conditions
        if(! array_key_exists('cartContainer', $current)) { // no cart items loaded yet, nothing to compare
            return false;
        }
        
        if(! array_key_exists('cartContainer', $original)) { // current has cart items, orig doesn't, so there is a diff
            return true;
        }

        // if both current and original have products, do the final compare
        $prods1 = $prods1['cartContainer'];
        $prods2 = $prods2['cartContainer'];

        $ser_prod_1 = array_map('serialize', $prods1);
        $ser_prod_2 = array_map('serialize', $prods2);
        $diff = array_map('unserialize', array_merge(array_diff($ser_prod_1,$ser_prod_2), array_diff($ser_prod_2,$ser_prod_1)));
        return count($diff) > 0;
        //return array_map('unserialize',
        //array_diff(array_map('serialize', $prods1), array_map('serialize', $prods2)));
    }

    protected function get_cart_product($cart_item) {
        return array_map(
            function($element){
                if(array_key_exists('cart', $element) && (array_key_exists('products', $element['cart']))) {
                    return $element['cart']['products'];
                } else {
                    return array();
            }
        }, $cart_item);
    }

    public function add($key,$value) {
        //$this->session->clearStorage();
     
        if(!array_key_exists('trDataLayer', $this->session->getData() )) {
            $this->session->setData('trDataLayer', [ 'cartChanged'=>0, 'orig'=>[], 'current'=>[] ]);
        }
        $sess_data =  $this->session->getData('trDataLayer');
        
        // 'cache' original data
/*
        if( array_key_exists('current', $sess_data) ) {
            $this->data_layer['orig'] = $sess_data['current'];
        }
*/
        
        $this->data_layer['current'] = $sess_data['current'];

        $this->data_layer['current'][$key] = $value; 
// correnct?        $this->data_layer['cartChanged'] = $sess_data['cartChanged'];
        $this->session->setData('trDataLayer',$this->data_layer);
    }

    public function cartUpdate() {
file_put_contents('/tmp/diff.log',"\n Hit Cart update---------------------\n", FILE_APPEND);
file_put_contents('/tmp/diff.log',print_r( $_SERVER['REQUEST_URI'],true), FILE_APPEND);

        $quote = $this->checkoutSession->getQuote();
        
        if( ! $quote->hasItems() ) {
            return false;
        } 

        if( $this->isExcludedCartEvent() === false ) {
            return false;
        }

        $id = $quote->getId();
        $items = $quote->getItems();
        $this->cart_obj['cart']
             = [
                'id' => "$id", 
                'link' => $this->helper->getCartLink(),
                'products' => []
            ];
        
        foreach( $items as $item ) {
            $this->cart_obj['cart']['products'][] = [
                'id' => $item->getSku(),
                'quantity' => $item->getQty(),
                'price' => $item->getPrice(),
                'currency'=> $this->helper->getCurrencyCode()
            ];
        }

        $this->add('cartContainer',$this->cart_obj);
        $this->setCartStatus();
        return true;
    }

    public function getData($key = '', $index = null) {
        $rtn = $this->data_layer;
        if($key !== '') {
            if(array_key_exists($key, $this->data_layer)) {
                $rtn = $this->data_layer[$key];
            } else {
                $rtn = [];
            }
        }
        return $rtn;
    }

    public function getJson() {
        return json_encode($this->data_layer, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES);
    }

    public function debugLog() {
//        file_put_contents('/tmp/display.txt',print_r($_SERVER, true), FILE_APPEND);
        file_put_contents('/tmp/display.txt',print_r($this->getData(), true), FILE_APPEND);
    }
    
    public function isExcludedCartEvent() {
        $event = $this->cart_obj['eventUrl'];
        if( strpos($event,'/customer/section/load/') === false) {
            return true;
        }
        return false;
    }
    
}
