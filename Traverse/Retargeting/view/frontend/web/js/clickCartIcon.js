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
                var payload =
                {
                  type: "click",
                  eventUrl: data.trdata.event_url,
                  targetUrl: window.checkout.shoppingCartUrl,
                  cart: data.trdata.cart
                }
                TraverseRetargeting.event(payload);
            }

            });
        },

    });
    return $.mage.clickCartIcon;
});
