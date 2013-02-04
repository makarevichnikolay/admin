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