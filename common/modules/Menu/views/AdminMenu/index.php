<?php
/* @var $this BackEndController */

$this->breadcrumbs=array(
    'Back End',
);
?>
<div class="btn-toolbar">
    <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
    'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'buttons'=>array(
        array('label'=>'Создать','icon'=>'icon-plus icon-white', 'items'=>array(
            array('label'=>'URL', 'url'=>$this->createUrl('/Menu/AdminMenu/Create') ,'linkOptions'=>array('onclick'=>'openCreate(this.href);return false;')),
            array('label'=>'Another action', 'url'=>'#'),
            array('label'=>'Something else', 'url'=>'#'),
            '---',
            array('label'=>'Separate link', 'url'=>'#'),
        )),
    ),
)); ?>
</div>

<div class="admin-modal fade out">
     <button type="button" class="close admin-close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <div id="result"></div>
</div>

<div class="cf nestable-lists">

</div>

<script>
   var transforms = {
       dd_list: [
           {tag:'ol',class:'dd-list',children:function() {return($.json2html(this.dd_item,transforms.dd_item));}}
       ],
       children:[
           {tag:'div',class:'dd-handle',html:'<span class="text-info">${label}</span> <span class="muted">URL: ${url}</span>'},
           {tag:'div',class:'dd-control',html:'<div class="pull-right">' +
                   '<a href="${url}" class="btn btn-mini btn-info" target="_blank" >' +
                   '<i class="icon-pencil icon-eye-open icon-white"></i></a> ' +
                   '<button class="btn btn-mini btn-success" type="button" onclick="openUpdate(${id});">' +
                   '<i class="icon-pencil icon-white"></i></button> ' +
                   '<button class="btn btn-mini btn-danger" type="button"><i class="icon-remove icon-white"></i></button></div>'}
       ],
       children_list:[
           {tag:'div',class:'dd-handle',html:'<span class="text-info">${label}</span> <span class="muted">URL: ${url}</span>'},
           {tag:'div',class:'dd-control',html:'<div class="pull-right">' +
                   '<a href="${url}" class="btn btn-mini btn-info" type="button" target="_blank">' +
                   '<i class="icon-pencil icon-eye-open icon-white"></i></a> ' +
                   '<button class="btn btn-mini btn-success" type="button" onclick="openUpdate(${id});">' +
                   '<i class="icon-pencil icon-white"></i></button> ' +
                   '<button class="btn btn-mini btn-danger" type="button"><i class="icon-remove icon-white"></i></button></div>'},
           {tag:'ol',class:'dd-list',children:function() {return($.json2html(this.children,transforms.dd_item));}}
       ],
       dd_item: [
           {tag:'li',class:'dd-item','data-id':'${id}',children:function(){if(this.children) return($.json2html(this,transforms.children_list)); else return($.json2html(this,transforms.children))}}
       ]
   };

    function openCreate(url){
        $.ajax({
            type: "POST",
            url: url
        }).done(function( data ) {
                  $('#result').html(data);
                    adminModal('show');
                });
        return false;
    }

    function openUpdate(id){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('/Menu/AdminMenu/Update'); ?>"+'/?id='+id
        }).done(function( data ) {
                $('#result').html(data);
                adminModal('show');
            });
        return false;
    }
    function renderMenu(){
        $.ajax({
            type: "POST",
            url: '<?php echo $this->createUrl('/Menu/AdminMenu/GetMenuJSON') ?>'
        }).done(function( data ) {
                $('#nestable').remove();
                $('.nestable-lists').append('<div class="dd" id="nestable"></div>');
                    $('#nestable')
                      .json2html(data,transforms.dd_list)
                      .nestable({group: 1})
                      .on('change', function(){sendMenu();});
        });
    }

   function sendMenu(){
       var data = $('#nestable').nestable('serialize');
       $.ajax({
           type: "POST",
           data:{data:window.JSON.stringify(data)} ,
           url: '<?php echo $this->createUrl('/Menu/AdminMenu/SortSave') ?>'
       }).done(function( data ) { });
   }


 function adminModal(params){
   if(params == 'hide'){
       $('.admin-modal').toggleClass('in out').hide();
   }else if(params == 'show'){
       $('.admin-modal').toggleClass('in out').show();
   }

 }


    $(document).ready(function()
    {
        renderMenu();
        $('.close').on('click', function () {
            adminModal('hide');
        });
    });
</script>