define([
    "jquery",
    "jquery/ui"
], function($) {
    "use strict";

    $.widget('mage.clickCartAdd', {
        _create: function() {
            //bind click event of elem id
            this.element.on('click', function(e){
           
            // Don't send to Retargeting if all attributes not selected 
            var selected_options = $('.swatch-attribute-selected-option');
            
            var all_selected = true;
            selected_options.each( function(idx,el) {
                if( el.innerHTML == '' ) {
                    all_selected = false;
                }
            });
            
            if( all_selected ) {
                    var prod_data = $('#tr-data-product').data('trdata')
                    var event_data = $('#tr-data-event').data('trdata')
                    var qty = $('.product-add-form #qty').val();
                    var price = $('.price-final_price .price-wrapper').attr('data-price-amount');
                    prod_data.quantity = qty;
                    prod_data.price = price;

                    var payload =          
                    {
                      type: "cart",
                      eventUrl: event_data.event_url,
                      targetUrl: event_data.target_url,
                      product: prod_data
                    };
                    TraverseRetargeting.event( payload );
                } 
            });
        }
    });
    
    return $.mage.clickCartAdd;
});
