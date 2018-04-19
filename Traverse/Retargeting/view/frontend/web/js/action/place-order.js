define([
    'jquery',
], function ($) {
    'use strict';
    
    return function (paymentData, messageContainer) {
        var eventdata = $('#checkout-success-trdata').data('tr-data');
        TraverseRetargeting.event( eventdata );
        return true;
    };
});
