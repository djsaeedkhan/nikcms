<?php
use Cake\Routing\Router;

set_time_limit(6000);
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 3000);

$path = $this->request->getAttribute("webroot") . $upload_path;
function getMaximumFileUploadSize(){
    return min((ini_get('post_max_size')), (ini_get('upload_max_filesize')));  
}?>
<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= (isset($comment['id'])?__d('Admin', 'ویرایش رسانه'):__d('Admin', 'آپلود رسانه'))?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link(
                            __d('Admin', 'آپلود دستی'),
                            ['action'=>'Add2'],
                            ['class'=>'btn btn-sm btn-primary mr-1']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-left col-md-4 col-12 mb-2">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
        <div class="row" style="justify-content: flex-end;margin-left: 5px;">
            <?= $this->Form->control('parent_id', ['id'=>'parent_id',
                'options' => $parentCategory,
                'empty'=>'--  '.__d('Admin', 'دسته بندی').' --',
                'label'=>false,
                'default'=>$this->request->getQuery('parent_id'),
                'class' => 'form-control form-control-sm',]);?>

            <?= $this->Form->button(
                __d('Admin', 'آپلود در این دسته'),
                ['class'=>'btn btn-sm btn-success']);?>
        </div>
        <?= $this->Form->end(); ?>

        <script nonce="<?=get_nonce?>" type="text/javascript">
        $(document).ready(function() {
            $('#parent_id').on('change', function() {
                this.form.submit();
            });
        });
        </script>

    </div>
    
</div>


<!-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> -->
<!-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> -->
<script>
// Note that the name "myDropzone" is the camelized
// id of the form.
Dropzone.autoDiscover = true;
Dropzone.options.myDropzone = {
    maxFilesize: 209715200,
    maxFiles: 100,
    timeout: null,
    parallelUploads:10,
    uploadMultiple: true,
    autoQueue:true,
    url: "<?= Router::url('/admin/medias/add/');?>",
    autoProcessQueue:true,
    paramName: "file",
    init: function () {
        this.on("success", function (file) {
            console.log("success > " + file.name);
        });
        this.on("error", function (file) {
            console.log("Err > " + file.name);
        });
    },


    complete: function(file) {
        console.log(file);
        var name = file['name'];
        var filename = '<?= $path?>'+ file['upload']['filename'];
        if(file['xhr']['response'] == ''){ alert('در آپلود فایل مشکلی پیش آمده است');}
        else{
            $('.show_result').append(`<div class="col-sm-12"><div class="alert alert-success mb-1">
                <img class="card-img-top rounded" style="background:#FFF;width:40px;height:40px;"
                    src="`+filename+`" data-holder-rendered="true">
                `+name+`
                <a target="_blank" href="`+filename+`" class="pull-left1" style="padding: 5px;">[مشاهده فایل]</a>
            </div></div>`);
        }
    },

    // Configuration options go here
    
}
</script>
<?= $this->Form->create(null,[
    'class'=>'dropzone dropzone-area',
    //'style'=>'min-height: initial;',
    'id'=>'my-dropzone',
    'type'=>'file'])?>
        <div class="dz-message">
            <?= __d('Admin', 'پرونده (فایل) ها را اینجا رها کنید<br> یا برای بارگذاری کلیک کنید.')?>
        </div>
    <!-- <input type="file" name="file" /> -->
</form>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- <form action="#" class="dropzone dropzone-area" id="dpz-multiple-files">
                    <div class="dz-message">
                        <?= __d('Admin', 'پرونده (فایل) ها را اینجا رها کنید<br> یا برای بارگذاری کلیک کنید.')?></div>
                </form> -->
                <div class="show_result row"></div>

                
            </div>
        </div>
    </div>
</div>

<?php /*<div class="card">
    <div class="card-body">
        <?= $this->Form->create(null, ['type' => 'file','class'=>'col-sm-6']);?>
        <?= $this->Form->control('file', [
            'id'=>'FilUploader',
            'type' => 'file','label'=> false,'class' => 'form-control']);?>
        <?= $this->Form->button(__d('Admin', 'شروع آپلود'), ['class'=>'btn btn-success mt-4']);?>
        <?= $this->Form->end(); ?>
    </div>

    <?php if(isset($filename) and $filename !=''):?>
        <div class="alert alert-warning" style="margin:10px">
            <?php
            $ext = explode(".", $filename);
            $ext = strtolower(end($ext));
            if(in_array($ext,['jpg','jpeg','png'])){
                echo '<img class="card-img-top rounded" style="background:#FFF;width:40px;height:40px;"
                        src="'.$path.$filename.'" data-holder-rendered="true">';
            }?>
            <?=$filename?>
            <a target="_blank" href="<?= $path.$filename?>" class="pull-left1" style="padding: 5px;">[مشاهده فایل]</a>
        </div><br>
    <?php endif?>
</div>
*/?>

<div class="row">
    <div class="col-sm-7 alert alert-warning" style="margin-right:15px;font-size:15px;color:#000 !Important">
        پسوند های مجاز :svg zip  rar  jpg  jpeg  png  gif  pdf  docx  doc  xls  xlsx  mp4  mp3
    </div>
    <div class="col-sm-4 alert alert-warning" style="margin-right:15px;font-size:15px;color:#000 !Important">
        حداکثر قابل اپلود: <span style="font-family: tahoma;"><?=getMaximumFileUploadSize();?></span>
    </div>

</div>


<script nonce="<?=get_nonce?>" type="text/javascript">
//Dropzone.autoDiscover = false;
//Dropzone.autoDiscover = false;

/* $(function() {
    //var myDropzone = new Dropzone("#dpz-multiple-files");
    var myDropzone = $("#dpz-multiple-files");
    $("#dpz-multiple-files").dropzone({
        ///paramName: 'file', // The name that will be used to transfer the file
        //clickable: true,
        timeout: 0,
        maxFilesize: 1000,
    })
    .on("addedfile", function(file) {})
    .on("complete", function(file) {
        var name = file['xhr']['response'];
        var filename = '<?=$path?>'+ file['xhr']['response'];
        if(file['xhr']['response'] == ''){ alert('در آپلود فایل مشکلی پیش آمده است');}
        else{
            $('.show_result').append(`<div class="col-sm-12"><div class="alert alert-success mb-1">
                <img class="card-img-top rounded" style="background:#FFF;width:40px;height:40px;"
                    src="`+filename+`" data-holder-rendered="true">
                `+name+`
                <a target="_blank" href="`+filename+`" class="pull-left1" style="padding: 5px;">[مشاهده فایل]</a>
            </div></div>`);
        }
    });
}) */
/* var multipleFiles = $('#dpz-multiple-files');
multipleFiles.dropzone({
    paramName: 'file', // The name that will be used to transfer the file
    maxFilesize: 0.5, // MB
    clickable: true
  });

  Dropzone.options.multipleFiles = {
  init: function() {
    this.on("addedfile", function(file) { alert("Added file."); });
  }
}; */

 /*  multipleFiles.on("complete", function(file) {
  console.log("ss");
});
 */
$(function() {
    $('#FilUploader').change(function() {
        var fileExtension = ['webp','svg','zip','rar','jpg','jpeg','png','gif','pdf','docx','doc','xls','xlsx','mp4','mp3'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("فایل آپلودی دارای پسوند غیرمجاز می باشد و آپلود نخواهد شد");
        }
    });
})
</script>
<style>
.dropzone .dz-message:before {
    position: initial;
}
</style>

