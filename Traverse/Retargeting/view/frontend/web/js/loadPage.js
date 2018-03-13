define([
    "jquery",
    "jquery/ui"
], function($) {
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
    }
});
