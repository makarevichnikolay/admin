var PagesUpdate = {};

PagesUpdate.transforms = {
    item:[
        {tag:'li', class:'images-box', children:[
            {tag:'div', class:'thumbnail', children:[
                {tag:'img', src:'${src}'},
                {tag:'form', class:'pages-form', 'method':'post', children:[
                    {tag:'fieldset', children:[
                        {tag:'input', 'type':'text', 'name':'title', 'value':'${title}'},
                        {tag:'div', html:'<button class="btn pull-left save-image" data-id="${id}" type="button">' +
                            '<i class="icon-ok"></i></button>' +
                            '<button class="btn pull-right delete-image" data-id="${id}"  type="button">' +
                            '<i class="icon-remove"></i></button>'
                        }
                    ]}
                ]
                }
            ]
            }
        ]
        }
    ]
};

PagesUpdate.renderImage =  function (data){
    $('#result').json2html(data,PagesUpdate.transforms.item);
}

PagesUpdate.validMaxCount = function (cur,max){
    if(cur < max){
        $('#count').html('<i>загружено</i> <span class="badge badge-success"><span id="curCount">'+cur+'</span> c ' + max+'</span>');
    }else{
        setTimeout(function(){
            $('#ImagesUpload > .qq-uploader > .qq-upload-button').addClass('disabled');
            $('#ImagesUpload > .qq-uploader > .qq-upload-button >input').on('click',function(){return false;})
            $("#images-upload-list").css('display','none');
        },1000)
        $('#count').html('<i>загружено</i> <span class="badge badge-important"><span id="curCount">'+cur+'</span> c ' + max+'</span>');
    }
}

PagesUpdate.getAllImages = function getAllImages(){
    $.ajax({
        type: "POST",
        url: GetImagesJSON
    }).done(function( data ) {
            var result = $.parseJSON(data);
            PagesUpdate.validMaxCount(result['curCount'], result['maxCount']);
            for(var value in result){
                PagesUpdate.renderImage(result[value]);
            }
        });
}

PagesUpdate.deleteImage = function (data){
    $.ajax({
        type: "POST",
        url: deleteImageUrl,
        data:data
    }).done(function( data ) {
            $("#ImagesUpload > .qq-uploader > .qq-upload-button >input").unbind('click');
            $('#ImagesUpload > .qq-uploader > .qq-upload-button').removeClass('disabled');
            var count =$('#curCount').html();
            $('#curCount').html(--count).parent().removeClass('badge-important').addClass('badge-success');
        });
}


PagesUpdate.updateImage = function (data){
    $.ajax({
        type: "POST",
        url: updateImageUrl,
        data:data
    });
}



PagesUpdate.init = function(){
    this.getAllImages();
    $(document).on('click', '.save-image',function(e){
        var title =$(this).parent().siblings('input').val();
        var id = $(this).data('id');
        var data = {id:id,title:title};
        PagesUpdate.updateImage(data);
        $(this).addClass('save-image-ok').delay(1000).queue(function() {
            $(this).removeClass('save-image-ok');
            $(this).dequeue();
        });
    } );

    $(document).on('click','.delete-image',function(e){
        var id = $(this).data('id');
        var data = {id:id};
        PagesUpdate.deleteImage(data);
        $(this).closest('li.images-box').remove();
    });

}