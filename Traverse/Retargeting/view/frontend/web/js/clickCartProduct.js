define([
    "jquery",
    "jquery/ui"
], function($) {
    "use strict";

    $.widget('mage.clickCartProduct', {

        _create: function() {
            //bind click event of elem id
            this.element.on('click', function(e){
console.log('product click');
                // don't send the event if the click is on the Add To Cart button
                var all_data = $(this).find('img').data('trData');
                var isButton = ($(e.target).is(':button') || (e.target.tagName.toLowerCase() == 'span' && $(e.target).parent().is(':button')));
                var isSwatch = $(e.target).hasClass('swatch-option');
                if (! isButton && ! isSwatch ) {

                    var payload = 
                    {
                      type: "click",
                      eventUrl: all_data.event_url,
                      targetUrl: all_data.prod_url,
                      product: {
                        id: all_data.sku,
                        name: all_data.name,
                        image: all_data.image,
                        price: all_data.price,
                        description: all_data.description,
                        url: all_data.prod_url,
                        currency: all_data.currency
                      }
                    }
                    TraverseRetargeting.event(payload);
                }

            });
        },

    });
    return $.mage.clickCartProduct;
});
