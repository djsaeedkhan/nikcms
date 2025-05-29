<?php
use Cake\Routing\Router;
?>
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false"  aria-hidden="true" >
    <div class="modal-dialog  modal-lg" role="document"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?= __d('Admin', 'مدیریت گالری')?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
            <button id="set_post_cover" class="btn btn-secondary btn-sm pull-left"></button>
        </div>
    </div></div>
</div>
<script nonce="<?=get_nonce?>">
    /* ------------------------------------------------------------ */
    var act ;
    var dest ;
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        act = button.data('action');
        dest = button.data('dest');
        $(this).find('.modal-title').text(button.data('title'));
        $(".modal-body").html('<br><p class="text-center"> <?= __d('Admin', 'در حال دریافت اطلاعات')?></p><br>');
        $("#exampleModal").modal("show");

        if(act =='select_gallery'){
            $("#set_post_cover").html("<?= __d('Admin', 'گذاشتن در متن')?>");
        }
        else if(act =='select_thumbnail'){
            $("#set_post_cover").html("<?= __d('Admin', 'انتخاب به عنوان تصویر شاخص')?>"); 
        }
        else if(act == 'select_src'){
            $("#set_post_cover").html("<?= __d('Admin', 'انتخاب تصویر')?>"); 
        }

        $.ajax({
            type : 'GET',
            data: 'action='+button.data('action'),
            url : "<?= Router::url(['plugin'=>'Admin','controller' => 'Medias', 'action' => 'Gallery'],false) ?>",
            success : function(data){
                $(".modal-body").html(data);
                $("#exampleModal").modal("show");
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                $(".modal-body").html('<br><p class="text-center"><?= __d('Admin', 'متاسفانه امکان دریافت اطلاعات وجود ندارد')?></p><br>');
                $("#exampleModal").modal("show");  
            }
        });
    });
    /* ------------------------------------------------------------ */
    $('#set_post_cover').on('click', function (event) {
        if($('#post_cover_id').val()==''){
            alert('<?= __d('Admin', 'تصویری انتخاب نشده است - ')?>');
            return false;
        }

        if(act =='select_gallery'){
            //$("#post_image_cover").attr("src",);
            var ed = tinyMCE.get('edittextarea');               // get editor instance
            var range = ed.selection.getRng();                  // get range
            var newNode = ed.getDoc().createElement ( "img" );  // create img node
            newNode.src=$('#post_cover_image').val();           // add src attribute
            range.insertNode(newNode); 
            ChangeEffect();
        }
        else if(act =='select_thumbnail'){
            $("#post_image_cover").attr("src",$('#post_cover_image').val());
            ChangeEffect();
            $("#upload2").html("[<?= __d('Admin', 'تغییر تصویر شاخص')?>]<br>");
            $("#delete_thumimg").html("[<?= __d('Admin', 'حذف تصویر')?>]");
            $("#post_metas__thumbnail").val($('#post_cover_id').val());
        }
        else if(act == 'select_src'){
            $("#"+dest).val($('#image_full').val());
            ChangeEffect2();
        }
    });
    function ChangeEffect(){
        $("#set_post_cover").html("<?= __d('Admin', 'درحال انجام ...')?>");
        $("#set_post_cover").removeAttr('class');
        $("#set_post_cover").attr('class','btn btn-sm btn-success');

        setTimeout(function() {
            $("#set_post_cover").html("<?= __d('Admin', 'انجام شد')?>");
            $("#set_post_cover").removeAttr('class');
            $("#set_post_cover").attr('class','btn btn-sm btn-success');
        }, 500);

        setTimeout(function() {
            //$("#set_post_cover").html("انتخاب به عنوان تصویر شاخص");
            $("#set_post_cover").removeAttr('class');
            $("#set_post_cover").attr('class','btn btn-sm btn-secondary');
            $("#exampleModal").modal("hide");
        }, 2000);
    }
    function ChangeEffect2(){
        $("#set_post_cover").html("<?= __d('Admin', 'درحال انجام ...')?>");
        $("#set_post_cover").removeAttr('class');
        $("#set_post_cover").attr('class','btn btn-sm btn-success');

        setTimeout(function() {
            $("#set_post_cover").html("<?=  __d('Admin', 'انجام شد')?>");
            $("#set_post_cover").removeAttr('class');
            $("#set_post_cover").attr('class','btn btn-sm btn-success');
        }, 500);

        setTimeout(function() {
            //$("#set_post_cover").html("انتخاب به عنوان تصویر شاخص");
            $("#set_post_cover").removeAttr('class');
            $("#set_post_cover").attr('class','btn btn-sm btn-secondary');
            $("#exampleModal").modal("hide");
        }, 500);
    }
</script>