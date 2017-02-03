(function($) {
    "use strict";
    $(function() {
        var forms = ".muauth-wrap form";
        if (typeof zerospam.key != "undefined") {
            $(forms).on("submit", function() {
                $("<input>").attr("type", "hidden").attr("name", "zerospam_key").attr("value", zerospam.key).appendTo(forms);
                return true;
            });
        }
    });
})(jQuery);