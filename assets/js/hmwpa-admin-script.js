(function($) {

    // USE STRICT
    "use strict";

    $.each(hmwpaAdminScript.hmwpaIdsOfColorPicker, function(index, value) {
        $(value).wpColorPicker();
    });

    //====================================================
    $('.hmwpa-closebtn').on('click', function() {
        this.parentElement.style.display = 'none';
    });

})(jQuery);