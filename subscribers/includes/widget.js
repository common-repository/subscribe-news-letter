jQuery(document).ready(function ($) {
    $('.email').val('Enter your email to subscribe');
    $('.email').click(function () {
        if ($('.email').val() == 'Enter your email to subscribe') {
            $('.email').val('')
        }
    }).blur(function () {
        if ($('.email').val() == '') {
            $('.email').val('Enter your email to subscribe')
        }
    })

$('.subscribe').mouseenter(function(){
$(this).css('color','red');
}).mouseleave(function(){
$(this).removeAttr('style');
});


});
