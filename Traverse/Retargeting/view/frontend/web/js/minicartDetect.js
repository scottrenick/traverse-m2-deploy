define([
    "jquery"
], function($) {
    "use strict";

    var det = {
        run: function() {
            var self = this;
            var response;
            $( document ).ajaxComplete(function( event, request, settings ) {
                response = self.callType(settings.data, settings.type, settings.url);
                if( response == 'update' || response == 'remove') {
                    setTimeout(function(){
                        $.ajax({
                            url: '/traverse/cart/data',
                            type: 'post',
                            dataType: 'json',
                            success: function(res) {
                                if( res == null || typeof res === 'undefined' ) {
                                    var data = $('#tr-data-cart').data();
                                    var cart_data = data.trdata.cart;
                                    if( typeof (data.trdata.cart) != 'undefined' ) {
                                        cart_data['products'] = [];
                                        var payload =
                                        {
                                          type: "cart",
                                          eventUrl: data.trdata.event_url,
                                          cart: cart_data
                                        }
                                        TraverseRetargeting.event(payload);
                                    }

                                } else {
                                    TraverseRetargeting.event( res );
                                }
                            }
                        });
                    }, 3000);
                }
            });
        },
        
        callType: function(data, type, url) {
            var rtn = 'other';
            if( data !== undefined && type == 'POST' ) {
              if(
                data.indexOf('item_id') !== -1 &&
                data.indexOf('item_qty') !== -1 &&
                data.indexOf('form_key') !== -1 &&
                url.indexOf('updateItemQty') !== -1 
              ) { rtn = 'update' }
              if(
                data.indexOf('item_id') !== -1 &&
                data.indexOf('form_key') !== -1 &&
                url.indexOf('removeItem') !== -1 
              ) { rtn = 'remove' }
            } 
            return rtn;
        }
    }


    return det;        
});
