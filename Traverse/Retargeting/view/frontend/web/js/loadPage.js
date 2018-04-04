define([
    "jquery",
    "jquery/ui",
    "Magento_Checkout/js/view/minicart"
], function($, minicart) {
    "use strict";
    return function() {
        var impression = 
        {
            type: "impression",
            eventUrl: window.location.href 
        }        
        
        TraverseRetargeting.event(impression);

        var data = $('body').data('trCategory');
        if( data ) {
            // fix the json syntax
            data = data.replace(/\'/g, "\"");
            var jdata = $.parseJSON(data);
            var payload = 
            {
              type: "click",
              eventUrl: jdata.event_url,
              category: {
                id: jdata.id,
                name: jdata.name,
                description: jdata.description,
                link: jdata.url,
              }
            }

            TraverseRetargeting.event(payload);
        } 
/*
        minicart.on('contentUpdated', function() {
            alert('update');
        });

        var cartinfo = trDataLayer;
        if( cartinfo.cartChanged ) {
            TraverseRetargeting.event(cartinfo.current.cartContainer);
        }
*/
    }
});
