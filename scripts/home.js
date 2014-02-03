$(document).ready(function(){
    $('#sfNav').superfish();
    externalLinks();
    dynamicFaq();
});
    function externalLinks(){
        $('a.new_window').bind('click', function(e) {
            var location = $(this).attr('href');
                window.open(location);
            e.preventDefault();
        });
    };
    function dynamicFaq(){
        $('.hide').hide();
        $('img').bind('click', function(){
            $(this).toggleClass('open');
            $(this).next().slideToggle();
        });
    };


