<?php
echo $this->Form->create(isset($userprofiles)?$userprofiles:null,[
    'type'=>'file',
    'id'=>'userprofiles','class'=>'col-sm-12']);
$list = [];global $list;
$jdate = jdate('Y',null,null,null,'en');
for($i=intval($jdate)-10;$i>1310;$i--){
    $list[$i] = $i;
}

?>
<div class="alert alert-warning text-center">
    فرهیخته گرامی  با تکمیل اطلاعات کاربری خود، برقراری تعامل و 
    ارتباط با شما توسط سامانه <?=__d('Template', 'همیاری')?> به صورت
    مستقیم و مطلوب امکان پذیر خواهد بود.
</div>
<?php
if(!isset($userprofiles->id)){
    echo $this->Form->control('single',[
        'type'=>'select','id'=>'type',
        'options'=> $group,
        'default'=>false,
        'empty'=>'-- انتخاب کنید --',
        'label'=>'نوع مشارکت در '.__d('Template', 'همیاری').' ها',
        'class'=>'form-control','style'=>'max-width:250px;']);

    echo $this->Form->button(__('مرحله بعد'),
        ['class'=>'float-right btn btn-primary btn-sm m-0 ml-1 mt-4',
        'confirm'=>'توجه: در آینده امکان ویرایش/تغییر نوع مشارکت وجود نخواهد داشت. آیا مطمئن هستید؟',
        'style'=>'margin-left: 10px !important;']);
}
else{
    
    try{
        echo $this->element('Template.challenge_profile_edit');
    }
    catch (\Exception $e){
        echo $this->element('Challenge.challenge_profile_edit');
    }
    
    echo $this->Form->button(__('ثبت اطلاعات'),
        ['class'=>'float-right btn btn-primary btn-sm m-0 ml-1 mt-4','style'=>'margin-left: 10px !important;']);
}
echo $this->Form->end();
?>
<script nonce="<?=get_nonce?>">
$(function() {
    $('#row_dim').hide(); 
    if($('#type').val() == '2') {
        $('#row_dim').show(); 
    } else {
        $('#row_dim').hide(); 
    } 
    $('#type').change(function(){
        if($('#type').val() == '2') {
            $('#row_dim').show(); 
        } else {
            $('#row_dim').hide(); 
        } 
    });
});
</script>
<?= $this->html->css([
    '/template/css/select-boxes.css'
])?>
<script nonce="<?=get_nonce?>" type="text/javascript">
$(function() {
    $('#FilUploader').change(function() {
        var fileExtension = ['jpg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("فقط تصاویر با پسوند jpg قابل قبول می باشد");
        }
    })
})
</script>