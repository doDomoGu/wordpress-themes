$(function(){
    //nav 侧边导航
    _curNav = $('#nav .columns a.on');

    $('#nav .columns a').mouseenter(function(){
        $('#nav .columns a').removeClass('on');
        $(this).addClass('on');
    }).mouseleave(function(){
        $('#nav .columns a').removeClass('on');
        if($('#nav .columns a.on').length == 0){
            _curNav.addClass('on');
        }
    });
});