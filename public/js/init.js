(function ($) {
    $(function () {

        $('.sidenav').sidenav();
        $('.parallax').parallax();
        $(".dropdown-trigger").dropdown({
            hover: false,
            constrainWidth: false
        });
        $('.modal').modal();

    }); // end of document ready
})(jQuery); // end of jQuery name space
