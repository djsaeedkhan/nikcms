<?php use Cake\Routing\Router;?>

<div class="content-header row">
    <div class="content-header-right col-md-7 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'مدیریت رسانه');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link(__d('Admin', 'افزودن رسانه'),
                            ['action'=>'Add'],
                            ['class'=>'btn btn-sm btn-primary mr-1']);?>

                        <span id="dbutton" class="btn btn-sm btn-warning">
                            <?= __d('Admin', 'حذف')?>
                        </span>
                        <?= $this->Auths->link(
                            __d('Admin', 'حذف انتخاب شده ها'),
                            '#',
                            ['class'=>'btn btn-sm btn-danger dlistbutton dbutton2 d-none']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header-left text-md-left col-md-5 col-12">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
        <div class="row" style="justify-content: flex-end;margin-left: 5px;">
            <?= $this->Form->control('parent_id', [
                'options' => $parentCategory,
                'empty'=>'--  '.__d('Admin', 'دسته بندی').' --',
                'label'=>false,
                'default'=>$this->request->getQuery('parent_id'),
                'class' => 'form-control form-control-sm',]);?>

            <?= $this->Form->control('text', [
                'label'=>false,
                'type' => 'text', 
                'class' => 'form-control form-control-sm',
                'placeholder'=>__d('Admin', 'عنوان را وارد کنید'),
                'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):'') ]);?>

            <?= $this->Form->button(__d('Admin', 'جستجو'),['class'=>'btn btn-sm btn-success']);?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>

<?= $this->Form->create(null, [
    'url'=>['action'=>'delete','list'],
    'type' => 'post','id'=>'dall','validate'=>false]); ?>
<div class="row ">
    
    <?php 
foreach ($medias as $media):
    $extension = strtolower(pathinfo($media->title, PATHINFO_EXTENSION));
    $path = $this->request->getAttribute("webroot") . $upload_path;
    $file_size = '';

    $other_size = null;
    $meta = $this->Func->Metalist($media);
    unset($meta['full']);
    if(count($meta)):
        foreach($meta as $tmp_key=>$tmp_val){
            $other_size .='<div class="input text" style="margin-bottom: 10px;direction: ltr;">
                <label style="margin:0;text-transform: capitalize;">'.$tmp_key.': </label>
                <input type="text" name="name" class="selectall form-control"style="direction: ltr;padding: 4px;" value="'.Router::url('/',true) . $upload_path.$tmp_val.'">
            </div>';
        }
    endif;

    $full = Router::url('/',true) . $upload_path . $media->title;
    $file_size = "unknown";//FileSizeConvert(remote_filesize ($full));

    if(in_array($extension,['jpg','jpeg','png','gif'])){
        $thumbfile = $this->Func->show_post_thumbnail($media);
        $thumb =  $path .$thumbfile ;
        $medium = $path . $this->Func->show_post_thumbnail($media, 'medium');
    }
    else{
        $thumbfile = "ext-$extension.png";
        $thumb = $medium = $this->request->getAttribute("webroot").'admin/img/'. $thumbfile ;
    }
    if($thumbfile == '' /* or  !file_exists(WWW_ROOT.'uploads/'.$thumbfile) */){
        $thumb = $full;
    };
    ?>
    <div class="col-md-2">
        <div class="card mb-2 box-shadow">
            <input type="checkbox" class="dlistbutton d-none" name="<?= $media->id;?>">
            <a data-toggle="modal" data-target="#exampleModal"
                title="<?= $media->title;?>"
                data-id="<?= $media->id;?>" 
                data-srcimg="<?= $medium;?>" 
                data-other_size='<?= $other_size;?>'
                data-extension="<?= $extension;?>" 
                data-srcfull="<?= $full;?>" 
                data-title="<?= $media->title;?>" 
                data-type="<?= $media->title;?>" 
                data-size="<?= $file_size;?>" 
                data-date="<?= str_replace('-','/',$this->Query->the_time($media))?>" 
                style="height1:150px; width: 100%; background:#FFF;cursor:pointer;">
                <img 
                    class="card-img-top img-thumbnail" 
                    style="background:#FFF;font-size: 12px;" 
                    title="<?=$media->title;?>" 
                    src="<?= @$thumb;?>"
                    srcfull="<?= $media->id;?>"
                    imgfull = '<?=$full;?>'
                    alt="<?= $thumb == ' '?__d('Admin', 'فایل پیدا نشد'):$media->title;?>" 
                    data-holder-rendered="true">
            </a>
        </div>
    </div>
    <?php endforeach;?>
</div>
<?= $this->Form->end(); ?>
<!--------------------->

<div class="paginator">
    <p class="float-left pt-1">
        <?= $this->Paginator->counter(['format' => __d('Admin', 'صفحه {{page}} از {{pages}} / درحال نمایش {{current}} رکورد از {{count}} ')]) ?>
    </p>

    <ul class="pagination pagination-rounded pagination mt-4">
        <?php
        $this->Paginator->setTemplates([
            'prevDisabled' => '<li class="page-item disabled"><a class="page-link disabled" href="{{url}}">قبلی</a></li>',
            'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">قبلی</a></li>',
            'nextDisabled' => '<li class="page-item disabled"><a class="page-link disabled">بعدی</a></li>',
            'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">بعدی</a></li>',
            'first' => '<li class="page-item"><a class="page-link" href="{{url}}">اولین</a></li>',
            'last' => '<li class="page-item"><a class="page-link" href="{{url}}">آخرین</a></li>',
            'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>'
        ]);
        ?>
        <?= $this->Paginator->first('<< ' . __d('Admin', 'اولین'),['class'=>'page-link']) ?>
        <?= $this->Paginator->prev('< ' . __d('Admin', 'قبلی'),['class'=>'page-link']) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__d('Admin', 'بعدی') . ' >',['class'=>'page-link']) ?>
        <?= $this->Paginator->last(__d('Admin', 'آخرین') . ' >>',['class'=>'page-link']) ?>
    </ul>
</div>


<?php $this->start('modal');?>
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=__d('Admin', 'پیام جدید')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer" style="display: block1;">
        <?= $this->Form->postlink(
            __d('Admin', 'حذف برای همیشه'),
            ['action'=>'delete'],
            [
                'confirm'=> __d('Admin', 'برای حذف مطمئن هستید؟'),
                'class'=>'btn btn-sm btn-danger delete-itm',
                'target'=>'_parent']);?>

        <?= $this->Auths->link(
            __d('Admin', 'نمایش'),
            '/',
            ['class'=>'btn btn-sm btn-dark','target'=>'_blank','id'=>'viewitm']);?>
            
       <!-- <?= $this->html->link(
            __d('Admin', 'ادیتور'),
            '/',
            ['class'=>'btn btn-sm btn-dark','target'=>'_blank','id'=>'edititm']);?> -->

       <?php /*$this->Auths->link('ویرایش','/',
            ['class'=>'btn btn-light pull-left','target'=>'_blank','id'=>'viewitm']); */?>
                         
      </div>
        </div>
    </div>
</div>
<script nonce="<?=get_nonce?>">

$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    $(this).find('.modal-title').text(button.data('title'));
    //modal.find('form').attr('action','/'+button.data('id'));
    //$(".modal-title").html('sasd');
    /* $(".modal-body").html('<br><p class="text-center">در حال دریافت اطلاعات</p><br>');
    $("#exampleModal").modal("show");
    $.ajax({
        type : 'GET',
        data: '123',
        url : "<?= Router::url(['controller' => 'Medias', 'action' => 'view',188],false) ?>",
        success : function(data){
            $(".modal-body").html(data);
            $("#exampleModal").modal("show");
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            $(".modal-body").html('<br><p class="text-center">متاسفانه امکان دریافت اطلاعات وجود ندارد</p><br>');
            $("#exampleModal").modal("show");  
        }
    }); */
    $('form').prop('action',$("form").attr("action") +'/'+button.data('id'));
    $('#viewitm').prop('href',button.data('srcfull'));
    $('#edititm').prop('href','<?= Router::url(['action'=>'edit','?'=>['type'=>'editor']])?>'+'&id=' + button.data('id'));

    $(".modal-body").html(''+
    '<div class="row">'+
        '<div class="col-md-7 text-center">'+
            '<img src="'+button.data('srcimg')+'"  class="img-thumbnail img-responsive" style="max-height:350px;max-width: inherit;">'+
        '</div>'+
        '<div class="col-md-5 ml-auto">'+
            '<div class="filename padd5" style="word-wrap: break-word;margin-bottom:10px;"><strong><?=__d('Admin', 'نام پرونده')?>: </strong>'+button.data('title')+
            ' <a href="<?= Router::url(['action' => 'view'],false);?>/'+button.data('id')+'">[<?=__d('Admin', 'ویرایش')?>]</a>'+
            '</div>'+
            '<div class="filename"><strong><?=__d('Admin', 'نوع پرونده')?>: </strong>'+button.data('extension')+'</div>'+
            '<div class="uploaded"><strong><?=__d('Admin', 'حجم پرونده')?>: </strong><div style="font-family: sans-serif;display: inline-block;direction: ltr;">'+button.data('size')+'</div></div>'+
            '<div class="file-size"><strong><?=__d('Admin', 'تاریخ بارگذاری')?>: </strong> '+button.data('date')+'</div>'+

            '<div class="nav-tabs-boxed" style="margin-top:10px;">'+
            '<ul class="nav nav-tabs" role="tablist">'+
            '<li class="nav-item"><a style="padding: 5px 10px;" class="nav-link active" data-toggle="tab" href="#home-1" role="tab" aria-controls="home"><?=__d('Admin', 'لینک فایل')?></a></li>'+
            '<li class="nav-item"><a style="padding: 5px 10px;" class="nav-link" data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile"><?=__d('Admin', 'سایزهای دیگر')?></a></li>'+
            '</ul>'+
            '<div class="tab-content">'+
            '<div style="padding: 5px;"class="tab-pane active" id="home-1" role="tabpanel"><textarea class="selectall form-control image-src" dir="ltr" rows="3">'+button.data('srcfull')+'</textarea>'+
            '<strong><?=__d('Admin', 'دسترسی سریع')?>: </strong>'+
            '<textarea class="form-control" dir="ltr" rows="1">[attachment id='+button.data('id')+']</textarea>'+
            '</div>'+
            '<div style="padding: 5px;" class="tab-pane" id="profile-1" role="tabpanel">'+button.data('other_size')+'</div>'+
            '</div>'+
            '</div>'+
            
        '</div>'+
    '</div>');
   
    $('.selectall').on('click',function(e) {
        $(this).select();
    });

});
</script>
<?php $this->end(); ?>

<script nonce="<?=get_nonce?>">
$('#dbutton').on('click',function(e) {
    $('.dlistbutton').removeClass('d-none');
    $('.box-shadow').attr("style",'background: none;');
    $('#dbutton').addClass('d-none');
    $('.submit').attr('style','display: initial;');
});
$('.dbutton2').on('click',function(e) {
    if (confirm("Are u sure to delete") == true) {
        $('form#dall').submit();
    }
});
</script>
<style>

#dall .img-thumbnail{
    width: 100%;
    min-width: 150px;
    height: 150px;
    min-height: 150px;
    background: #f8f8f8 !important;
    /* border-radius: 5px; */
}

#dall .img-thumbnail:before {
    content: ' ';
    display: block;
    position: absolute;
    height: 140px;
    width: 140px;
    background: url("<?=Router::url('/admin/img/no_picture_available.png')?>") center;
    background-size: cover;
}

#dall .img-thumbnail:hover{background:#FFEB3B !important;}
</style>

<?php
function remote_filesize($url) {
    static $regex = '/^Content-Length: *+\K\d++$/im';
    if (!$fp = @fopen($url, 'rb')) {
        return false;
    }
    if (
        isset($http_response_header) &&
        preg_match($regex, implode("\n", $http_response_header), $matches)
    ) {
        return (int)$matches[0];
    }
    return strlen(stream_get_contents($fp));
}
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array("UNIT" => "TB","VALUE" => pow(1024, 4)),
            1 => array("UNIT" => "GB","VALUE" => pow(1024, 3)),
            2 => array("UNIT" => "MB","VALUE" => pow(1024, 2)),
            3 => array("UNIT" => "KB","VALUE" => 1024),
            4 => array("UNIT" => "B","VALUE" => 1),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"]){
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 0)))." ".$arItem["UNIT"];
            break;
        }
    }
    return @$result;
}
?>