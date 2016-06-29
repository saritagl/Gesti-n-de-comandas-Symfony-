$(document).ready(function(){
    $('.menu-item img').animate({opacity: 1}, {duration: 1000});
    $('.menu-item h3, .menu-item p').fadeOut(0);

    $('.menu-item').hover(
        function(){
            $(this).find('h3, p').fadeIn('slow');
            $(this).find('.fader').fadeTo('slow', 0.3);
        },
        function(){
            $(this).find('h3, p').fadeOut('fast');
            $(this).find('.fader').fadeTo('fast', 0);
            $(this).animate({ 'background-color': 'rgba(0, 0, 0, 0.0)' },1000);
        }
    );

});
