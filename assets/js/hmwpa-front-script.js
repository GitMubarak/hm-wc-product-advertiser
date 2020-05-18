(function($, window) {

    // USE STRICT
    "use strict";

    var defaultShowValue = "true";
    var showScrollAdd = "true";
    var refreshId = null;

    // now call the scroll function
    $(window).scroll(function() {
        var lastScreen = $(window).scrollTop() + $(window).height() < $(document).height() * 1.00 ? false : true;
        //alert(lastScreen);
        if (!lastScreen) {
            if (showScrollAdd == "true") {
                $("#hmwpa_scroll_box").show().stop().animate({ right: "0px" });
                if (refreshId != null) {
                    clearInterval(refreshId);
                }
                loader();
            }
        }
        if (lastScreen) {
            $("#hmwpa_scroll_box").stop().animate({ right: "-400px" });
        }
    }); //end of scroll

    function loader() {
        var data = { action: 'load_scroll_post' };
        if (defaultShowValue == "true") {
            if (refreshId == null) {
                $.post(wsAjaxObject.ajaxurl, data, function(response) {
                    $("#hmwpa_scroll_box").html(response);
                });
                refreshId = setInterval(function() {
                    $.post(wsAjaxObject.ajaxurl, data, function(response) {
                        $("#hmwpa_scroll_box").html(response);
                    });
                }, 5000);
            } else {
                refreshId = setInterval(function() {
                    $.get(wsAjaxObject.ajaxurl, data, function(response) {
                        $("#hmwpa_scroll_box").html(response);
                    });
                }, 5000);
            }
            $.ajaxSetup({ cache: false });
        }
    }

})(jQuery, window);