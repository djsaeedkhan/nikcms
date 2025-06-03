<?php
use Cake\Routing\Router;
$path = $this->request->getAttribute("webroot") . $upload_path;
?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= (isset($comment['id'])?__d('Admin', 'ویرایش رسانه'):__d('Admin', 'آپلود رسانه'))?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?= $this->Form->create(null, ['type' => 'file','class'=>'col-sm-6']);?>
        <?= $this->Form->control('file', [
            'type' => 'file',
            'label'=>false,
            'id'=>'sortpicture',
            'templates'     => ['inputContainer' => ' {{content}} <span class="badge badge-danger upload_status"></span>'],
            'class' => 'form-control']);?>
            <bR>
        <?= $this->Form->control(
            __d('Admin', 'شروع آپلود'), [
            'type' => 'button',
            'id'=>'upload',
            'class' => 'btn btn-success',
            'label'=>false,
            ]);?>
    <?= $this->Form->end(); ?>
    <div class="clearfix"></div><br>
    <div class="col-sm-12">
        <div class="ajax_upload_box"></div>
    </div>
    <div class="clearfix"></div>
    </div>
</div>

<script nonce="<?=get_nonce?>">
$('#upload').on('click', function() {
        var file_data = $('#sortpicture').prop('files')[0];
        const csrfToken = document.querySelector('meta[name="csrfToken"]').getAttribute('content');
        var form_data = new FormData();
        if ($('#sortpicture').get(0).files.length === 0) {
            alert("No files selected.");
            return false;
        }                  
        form_data.append('file', file_data);
        $("#upload").html('در حال ارسال ...');
        $("#upload").attr("disabled", "disabled");
        $.ajax({
            url: "<?= Router::url(['controller' => 'Medias', 'action' => 'AjaxAdd'],false) ?>",
            dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success : function(data){
                var thumbnail;
                $("#upload").removeAttr("disabled");
                var retdata = (JSON.parse(data));
                if(typeof retdata['thumbnail'] === 'undefined')
                    thumbnail = (retdata['full']);
                else
                    thumbnail = (retdata['thumbnail']);

                var full = (retdata['full']);
                if( data == '0'){
                    $("#upload").html('submit');
                    $(".upload_status").html('<?=__d('Admin', 'متاسفانه آپلود انجام نشد')?>');
                    $("#upload").html('submit');
                    $("#sortpicture").val("");
                }
                else{
                    
                    $("#upload").html('<?=__d('Admin', 'شروع آپلود')?>');
                    if(typeof retdata['thumbnail'] === 'undefined') {
                        $(".ajax_upload_box").html('<div class="alert alert-warning col-sm-12" style="padding: 4px;">'+
                            full['name']+
                            ' <a target="_blank" href="<?= $path;?>'+full['name']+'" class="pull-left" style="padding: 5px;">[<?=__d('Admin', 'مشاهده فایل')?>]</a>'+
                        '</div>'+$(".ajax_upload_box").html());
                    }
                    else
                    {
                        $(".ajax_upload_box").html(''+
                        '<div class="alert alert-warning col-sm-12" style="padding: 4px;">'+
                            '<img class="card-img-top rounded" style="background:#FFF;width:30px;height:30px;" '+
                                'src="<?= $path;?>'+thumbnail['name']+'" data-holder-rendered="true"> '+
                            full['name']+
                            ' <a target="_blank" href="<?= $path;?>'+full['name']+'" class="pull-left" style="padding: 5px;">[<?=__d('Admin', 'مشاهده تصویر')?>]</a>'+
                        '</div>'+$(".ajax_upload_box").html());
                    }
                    $("#sortpicture").val("");
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(textStatus);
                $("#upload").removeAttr("disabled");
                $(".ajax_upload_box").html($(".ajax_upload_box").html()+'<div class="alert alert-danger"><?=__d('Admin', 'متاسفانه اپلود انجام نشد')?></div>');
                $("#upload").html('<?=__d('Admin', 'شروع آپلود')?>');
                $("#sortpicture").val("");
            }
        });
    /* ------------------------------------------------------------ */
    });
</script>