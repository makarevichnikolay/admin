var Pages = {};

Pages.init = function(){
    $('.admin-modal-show').on('click', function () {
        $('.admin-modal').show().toggleClass('in out');
        $('.admin-modal').scrollToMe();
    })
    $('.close').on('click', function () {
        $('.admin-modal').toggleClass('in out').hide();
    });
    $("#button-create-url-chunk").on("click",function() {
        $("#Pages_url").val(transliterate($("#Pages_title").val()));
        return false;
    });
}

