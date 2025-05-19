<?php $base = $this->Func->OptionGet('website_template');?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'تنظیمات پوسته')?>
                </h2>
            </div>
        </div>
    </div>
</div>

<?php
global $hsite;
global $menu;
global $version;
global $maxrow;
$maxrow = 30;

if( $this->Func->Optionget('lang_enable') == 1)
    echo $this->Form->create(null ,array('id'=>'settings', 'url'=>array('controller'=>'Options', 'action'=>'SaveSetting2')));
else
    echo $this->Form->create(null ,array('id'=>'settings', 'url'=>array('controller'=>'Options', 'action'=>'SaveSetting')));

if($this->Func->is_serial($result['setting']))
    $hsite = unserialize($result['setting']);
else
    $hsite = json_decode($result['setting'],true);

$hsite = isset($hsite['hsite'])?$hsite['hsite']:[];
$this->request->withData('setting'.(defined('template_slug')?'_'.template_slug :'').'.hsite',$hsite);
@$this->request->data['setting'.(defined('template_slug')?'_'.template_slug :'')]['hsite'] = $hsite;
if($this->elementExists($base.'.options'))
  echo $this->element($base.'.options',['menu'=>$menu ]);
else
  echo '<div class="alert alert-danger">'. __d('Admin', 'متاسفانه فایل تنظیمات پیدا نشد') .'</div>';?>

<!-- ------------------------------------------------->
<script nonce="<?=get_nonce?>">
$("#settings").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr('action');
    $.ajax({
        type: "POST",
        url: actionUrl,
        async: false, 
        data: form.serialize(),
        beforeSend: function() {
            // setting a timeout
            $("#submited").val("<?= __d('Admin', 'درحال ثبت اطلاعات')?> ...");
            $("#submited").removeClass('btn-primary');
            $("#submited").addClass('btn-success');
        },
        success: function(data){
            if(data == 1)
                alert("<?= __d('Admin', 'ثبت اطلاعات با موفقیت انجام شد')?>");
            else
                alert("<?= __d('Admin', 'متاسفانه ثبت اطلاعات با موفقیت انجام نشد')?>");
        },
        error: function(data){
            alert("<?= __d('Admin', 'متاسفانه ثبت اطلاعات انجام نشد')?>");
        },
        complete: function() {
            $("#submited").val("<?= __d('Admin', 'ثبت اطلاعات')?>");
            $("#submited").removeClass('btn-success');
            $("#submited").addClass('btn-primary');
        }
    });
});
</script>
<!-- ------------------------------------------------->
<?php
if($version == 2){
    include_once('template_ver2.php');
}else{
    include_once('template_ver1.php');
}
$this->Form->end()?>
<style>
.setting-card hr {
    border-top: 1px solid #7569f1;
}
.tab-content hr {
    border-top: 1px solid #7569f1;
}
.options .nav-tabs--vertical {
  border-bottom: none;
  /* border-right: 1px solid #ddd; */
  display: flex;
  flex-flow: column nowrap;
}
.options .nav-tabs--left {
    margin: 0 15px;
    margin-left: 0;
}
.options .nav-tabs--left .nav-item + .nav-item {
  margin-top: .25rem;
}
.options .nav-tabs--left .nav-link {
  transition: border-color .125s ease-in;
  white-space: nowrap;
}
.options .nav-tabs--left .nav-link:hover {
  background-color: #f7f7f7;
  border-color: transparent;
}
.options .nav-tabs--left .nav-link.active {
    border-bottom-color: #ddd;
    border-left-color: #fff;
    border-bottom-right-radius: 0.25rem;
    border-top-left-radius: 0;
    margin-left: -1px;
}
.options .nav-tabs--left .nav-link.active:hover {
  background-color: #fff;
  border-color: #0275d8 #fff #0275d8 #0275d8;
}
.options .nav-tabs .nav-item {
    margin-bottom: -1px;
    margin-left: -1px;
    z-index: 99;
}
.mt-10{
    border:0 !important;
}
.autoh{
    max-height:50px !important;
}
.autoh:focus{
    max-height:150px !important;
}
</style>
<script nonce="<?=get_nonce?>">
    $("input").addClass("mb-2");
    $("textarea").addClass("mb-2");
    $("select").addClass("mb-2");
</script>

<?php $this->start('modal');?>
<?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>