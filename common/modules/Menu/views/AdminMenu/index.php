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
    <div class="dd" id="nestable"></div>
</div>

<script>
   var transforms = {
       dd_list: [
           {tag:'ol',class:'dd-list',children:function() {return($.json2html(this.dd_item,transforms.dd_item));}}
       ],
       children:[
           {tag:'div',class:'dd-handle',html:'<span class="label label-info">${label}</span>'},
           {tag:'div',class:'dd-control',html:'<div class="pull-right">' +
                   '<button class="btn btn-mini btn-info" type="button" onclick="openUpdate(${id});">' +
                   '<i class="icon-pencil icon-eye-open icon-white"></i></button> ' +
                   '<button class="btn btn-mini btn-success" type="button" onclick="openUpdate(${id});">' +
                   '<i class="icon-pencil icon-white"></i></button> ' +
                   '<button class="btn btn-mini btn-danger" type="button"><i class="icon-remove icon-white"></i></button></div>'}
       ],
       children_list:[
           {tag:'div',class:'dd-handle',html:'<span class="label label-info">${label}</span>'},
           {tag:'div',class:'dd-control',html:'<div class="pull-right">' +
                   '<button class="btn btn-mini btn-info" type="button" onclick="openUpdate(${id});">' +
                   '<i class="icon-pencil icon-eye-open icon-white"></i></button> ' +
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
                    showHideModal();
                });
        return false;
    }

    function openUpdate(id){
        alert(id);
    }

    function renderMenu(){
        $.ajax({
            type: "POST",
            url: '<?php echo $this->createUrl('/Menu/AdminMenu/GetMenuJSON') ?>'
        }).done(function( data ) {
                    $('#nestable').html('')
                      .json2html(data,transforms.dd_list)
                      .nestable({group: 1
                                })
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


 function showHideModal(){
     $('.admin-modal').toggleClass('in out');
 }


    $(document).ready(function()
    {
        renderMenu();
        $('#nestable').on('change', function(){sendMenu();});
        $('.close').on('click', function () {
            showHideModal();
        });
    });
</script>