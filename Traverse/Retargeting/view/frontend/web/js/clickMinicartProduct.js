define([
        "jquery",
        "jquery/ui"
], function($) {
"use strict";

$.widget('mage.clickMinicartProduct', {

    _create: function() {
        //bind click event of elem id
        this.element.on('click', function(e){
            var cntnr = $(e.target).closest('.product');
            var src = cntnr.find('.product-image-photo').prop('src');;
            var eUrl =  window.location.href;
            var tUrl = cntnr.find('.product-item-name').find('a').prop('href');;
            var imgname = src.slice(src.lastIndexOf('/') + 1);
            var data = $('#tr-data-cart').data();
            if( typeof (data.trdata.cart) != 'undefined' ) {
            var cartdata =  data.trdata.cart;
            var prod ='';

            $(cartdata.products).each( function(idx, val) {
                    var valimgpath =  val.image;
                    var valimgname = valimgpath.slice(valimgpath.lastIndexOf('/') + 1);
                    if(valimgname == imgname) {
                    prod = val;
                    return false;
                    }
                    });

            var prod_name = prod.name.replace(/\+/g, ' ');
            var prod_desc = prod.description.replace(/\+/g, ' ');
            var payload =
            {
                  type: "click",
                  eventUrl: eUrl,
                  targetUrl: tUrl,
                  product: {
                    id: prod.id,
                    name: prod_name,
                    image: prod.image,
                    price: prod.price,
                    description: prod_desc,
                    url: prod.url,
                    currency: prod.currency
                 }
            }
            TraverseRetargeting.event(payload);
        }

        });
    },

    });
    return $.mage.clickMinicartProduct;
});
