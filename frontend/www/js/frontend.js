/**
 * Created with JetBrains PhpStorm.
 * User: Veha
 * Date: 04.02.13
 * Time: 16:13
 * To change this template use File | Settings | File Templates.
 */
jQuery.fn.extend({
    scrollToMe: function () {
        if(jQuery(this).offset()){
            var x = jQuery(this).offset().top - 100;
            jQuery('html,body').animate({scrollTop: x}, 500);
        }

    }});

$(document).ready(function(){
    $(".menu .first > li").hover(function(){
        $(this).next().addClass('after-hover');
        $(this).removeClass('after-hover');
    },function(){
        $(this).next().removeClass('after-hover');
        $(".menu .first li.active").next().addClass('after-hover');
    });
    $(".menu .first > li.active").next().addClass('after-hover');

    $(".menu .second > li").hover(function(){
        $(this).next().addClass('after-hover');
        $(this).removeClass('after-hover');
    },function(){
        $(this).next().removeClass('after-hover');
        $(".menu .second li.active").next().addClass('after-hover');
    });
    $(".menu .second > li.active").next().addClass('after-hover');

});