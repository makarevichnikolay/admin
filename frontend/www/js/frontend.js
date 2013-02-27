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

function startTime()
{
    var name_month=new Array ("січня","лютого","березня", "квітня","травня", "червня","липня","серпня", "вересня","жовтня", "листопада","грудня");
    var name_day=new Array ("Неділя","Понеділок","Вівторок", "Середа","Четвер", "П’ятниця","Субота");
    var tm=new Date();
    var h=tm.getHours();
    var m=tm.getMinutes();
    var s=tm.getSeconds();
    m=checkTime(m);
    s=checkTime(s);
    document.getElementById('date').innerHTML=name_day[tm.getDay()]+", "+tm.getDate()+" "+name_month[tm.getMonth()]+" "+tm.getFullYear();
    document.getElementById('time').innerHTML=h+":"+m+":"+s;
    t=setTimeout('startTime()',500);
}
function checkTime(i)
{
    if (i<10)
    {
        i="0" + i;
    }
    return i;
}
var menuActive,menuParentActive;

$(document).ready(function(){
    if(menuActive){
        $('.menu  li[data-id="'+menuActive+'"]').addClass('active');
    }
    if(menuParentActive){
        $('.menu  li[data-id="'+menuParentActive+'"]').addClass('active');
    }
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
    startTime();
});