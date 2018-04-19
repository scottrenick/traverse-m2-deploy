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
                var all_data = $(this).closest('.item-info').find('img').data('trData');
                var isButton = ($(e.target).is(':button') || (e.target.tagName.toLowerCase() == 'span' && $(e.target).parent().is(':button')));
                var isSwatch = $(e.target).hasClass('swatch-option');
                if (! isButton && ! isSwatch ) {
                    var prod_name = all_data.name.replace(/\+/g, ' ');
                    var prod_desc = all_data.description.replace(/\+/g, ' ');
                    var payload = 
                    {
                      type: "click",
                      eventUrl: all_data.event_url,
                      targetUrl: all_data.prod_url,
                      product: {
                        id: all_data.sku,
                        name: prod_name,
                        image: all_data.image,
                        price: all_data.price,
                        description: prod_desc,
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
				if( swatch_attribs && swatch_attribs.length > 0 && selected_options.length < swatch_attribs.length ) {
					all_selected = false;
				}

                if( isButton && all_selected ) {
                    setTimeout(function(){
                        $.ajax({
                            url: '/traverse/cart/data',
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
    return $.mage.clickProduct;
});
