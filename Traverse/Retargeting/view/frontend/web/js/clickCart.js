define([
    "jquery",
    "jquery/ui"
], function($) {
    "use strict";

    $.widget('mage.clickCart', {
        _create: function() {
            //bind click event of elem id
            this.element.on('click', function(e){
                setTimeout(function(){
                    $.ajax({
                        url: '/traverse/cart/data',
                        type: 'post',
                        dataType: 'json',
                        success: function(resp) {
                            TraverseRetargeting.event( resp );
                        }
                    });
                }, 3000);
            });
        },

    });
    return $.mage.clickCart;
});
