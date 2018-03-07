define([
    "jquery",
    "jquery/ui"
], function($) {
    "use strict";

    $.widget('mage.clickProduct', {
        _create: function() {
            //bind click event of elem id
            this.element.on('click', function(e){
                // don't send the event if the click is on the Add To Cart button
                var all_data = $(this).find('img').data('trData');
                var isButton = (e.target.tagName.toLowerCase() == 'span' || $(e.target).parent().is(':button'));
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
				
				// Don't send to Retargeting if all attributes not selected 
				var swatch_attribs = $(this).find('.swatch-attribute');
				var selected_options = $(this).find('.swatch-attribute-options > .selected');
				var all_selected = true;
				if( swatch_attribs.length > 0 && selected_options.length < swatch_attribs.length ) {
					all_selected = false;
				}

                if( isButton && all_selected ) {

					var prod_data = [{'id':all_data.sku,'quantity':1,'price':all_data.price,'currency':all_data.currency,'name':all_data.name,'image':all_data.image,'description':all_data.description,'url':all_data.prod_url}];

                    var cartpayload =
                    {
                      type: "cart",
                      eventUrl: all_data.event_url,
                      targetUrl: all_data.prod_url,
                      product: prod_data
                    };
                    TraverseRetargeting.event( cartpayload );
                } 
            });
        }
    });
    return $.mage.clickProduct;
});
