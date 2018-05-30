define([
    "jquery",
    "jquery/ui"
], function($) {
    "use strict";

    $.widget('mage.clickCartIcon', {
        _create: function() {
            //bind click event of elem id
            this.element.on('click', function(e){
            var data = $('#tr-data-cart').data();
            if( typeof (data.trdata.cart) != 'undefined' ) {
                var cartdata =  data.trdata.cart;
                $(cartdata.products).each( function(idx, val) {
                    cartdata.products[idx].description = decodeURIComponent(val.description).replace(/\+/g, ' ');
                    cartdata.products[idx].name = decodeURIComponent(val.name).replace(/\+/g, ' ');
                });
                var payload =
                {
                  type: "click",
                  eventUrl: data.trdata.event_url,
                  targetUrl: window.checkout.shoppingCartUrl,
                  cart: cartdata
                }
                TraverseRetargeting.event(payload);
            } else  {
                    setTimeout(function(){
                        $.ajax({
                            url: '/traverse/cart/click',
                            type: 'post',
                            dataType: 'json',
                            success: function(res) {
                                TraverseRetargeting.event( res );
                            }
                        });
                    }, 3000);

            }

            });
        },

    });
    return $.mage.clickCartIcon;
});
