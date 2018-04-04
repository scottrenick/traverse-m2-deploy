define([], function () {
    'use strict';
   
    console.log("Called this Hook."); 
    
    return function(targetModule){
        return targetModule;
    };
});
