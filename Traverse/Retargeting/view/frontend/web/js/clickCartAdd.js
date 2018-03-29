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
        }
    });
    
    return $.mage.clickCartAdd;
});
