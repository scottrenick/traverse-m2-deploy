define([
    "jquery",
    "jquery/ui"
], function($) {
    "use strict";

    $.widget('mage.clickLink', {
        _create: function() {
            //bind click event of elem id
            this.element.on('click', function(e){
            console.log(e);
/*
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
                        url: all_data.url,
                      }
                    }

                    TraverseRetargeting.event(payload);
*/
				
            });
        }
    });
    return $.mage.clickLink;
});
