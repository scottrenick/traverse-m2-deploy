define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/place-order'
], function ($,quote, urlBuilder, customer, placeOrderService) {
    'use strict';
    
    var submitTr = function(cartdata) {
        var eventdata = $('#tr-data-event').data('trdata');
        if( typeof eventdata != 'undefined' ) {

            var trquotedata = window.checkoutConfig.quoteItemData;
            var trcustdata = window.checkoutConfig.customerData;
            var tremail = cartdata.email ? cartdata.email : trcustdata.email
            
            var trpayload = 
            {
              type: 'purchase',
              eventUrl: eventdata.event_url,
              email: tremail,
              cart: {
                id: cartdata.cartId,
                link: eventdata.cart_url
              }
            }

            var products = [];
            $(trquotedata).each( function(idx,item) {
                var prod = {'id':item.product.sku, 
                            'quantity':item.qty, 
                            'price':item.product.price, 
                            'currency':eventdata.currency,
                            'name':item.name,
                            'image':item.product.thumbnail,
                            };
                products.push(prod);
            });

            trpayload.cart.products = products;
            TraverseRetargeting.event( trpayload );        
        }
    };

    return function (paymentData, messageContainer) {
        var serviceUrl, payload;

        payload = {
            cartId: quote.getQuoteId(),
            billingAddress: quote.billingAddress(),
            paymentMethod: paymentData
        };

        if (customer.isLoggedIn()) {
            serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
        } else {
            serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
                quoteId: quote.getQuoteId()
            });
            payload.email = quote.guestEmail;
        }
        submitTr(payload); 
        return placeOrderService(serviceUrl, payload, messageContainer);
    };
});
