define([
    "jquery",
    "Traverse_Retargeting/js/minicartDetect"
], function($, Detect) {
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
    
        Detect.test();
/*
$( document ).ajaxComplete(function( event, request, settings ) {
  console.log('-----------');
  console.log(settings);
  console.log(settings.data);
  console.log(settings.type);
  console.log(settings.url);
  console.log('-----------');
});

        var miniCart = $('[data-block=\'minicart\']');
        miniCart.on('click',function(e){
            console.log(e.target);
        });

        var updateButton = $('.update-cart-item');
            console.log(updateButton);
        updateButton.on('click', function(e) {
            console.log(e.target);
        });
*/

    }
});
