<?= $this->Form->create($user,['id'=>'userprofiles']);?>

<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    ویرایش کاربر
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <div class="btn-group pull-left" role="group">
                            <?= $this->html->link('ویرایش پسورد',
                                ['plugin'=>'Admin','controller'=>'Users','action'=>'edit',$user->id],['class'=>'dropdown-item'])?>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
    <?php
        echo $this->Form->control('family',[
            'class'=>'form-control','label'=>'نام و نام خانوادگی']).'<br>';
        echo $this->Form->control('email',[
            'class'=>'form-control','label'=>'آدرس ایمیل']).'<br>';
        echo $this->Form->control('phone',[
            'class'=>'form-control','label'=>'شماره تماس']).'<br>';
    ?>
    </div>
    <div class="col-sm-4">
        <?php
        echo $this->Form->control('challengeuserprofile.gender',[
            'type'=>'select',
            'options' =>$gender,
            'label'=>'جنسیت'.' <span class="badge badge-danger pb-0">*</span>',
            'escape'=>false,
            'empty' =>'-- انتخاب کنید --',
            'class'=>'form-control']).'<br>';
        
        echo $this->Form->control('challengeuserprofile.codemeli',[
            'type'=>'text',
            'dir'=>'ltr',
            'label'=>'کدملی',
            'class'=>'form-control ltr']).'<br>';
        
        $list = [];
        for($i=1390;$i>1310;$i--){
            $list[$i] = $i;
        }
        echo $this->Form->control('challengeuserprofile.birth_date',[
            'label'=>'سال تولد',
            'type'=>'select',
            'empty' =>'-- انتخاب کنید --',
            'dir'=>'ltr',
            'options'=>$list ,
            'class'=>'form-control ltr']).'<br>';
            
        echo $this->Form->control('challengeuserprofile.provice',[
            'type'=>'select',
            'options' => $this->Func->province_list(),
            'label'=>'استان محل زندگی '.' <span class="badge badge-danger pb-0">*</span>',
            'escape'=>false,
            'required',
            'empty' =>'-- انتخاب کنید --',
            'class'=>'form-control']).'<br>';

        echo $this->Form->control('challengeuserprofile.eductions',[
            'type'=>'select',
            'required',
            'options'=>$eductions,
            'empty' =>'-- انتخاب کنید --',
            'label'=>'آخرین مقطع تحصیلی'.' <span class="badge badge-danger pb-0">*</span>',
            'escape'=>false,
            'class'=>'form-control']).'<br>';

        echo $this->Form->control('challengeuserprofile.descr',[
            'label'=>'توصیف کلی پیرامون موقعیت شغلی خود',
            'type'=>'textarea',
            'class'=>'form-control']).'<br>';
        
        ?>
    </div>
    <div class="col-sm-4">
        <?php
        
        echo $this->Form->control('challengeuserprofile.field',[
            'label'=>'رشته تحصیلی',
            'class'=>'form-control']).'<br>';
        
        echo $this->Form->control('challengeuserprofile.univercity',[
            'label'=>'دانشگاه محل تحصیل',
            'class'=>'form-control']).'<br>';

        
        echo $this->Form->control('challengeuserprofile.single',[
            'type'=>'select','id'=>'type',
            'options'=> $group,
            'label'=>'نوع مشارکت در '.__d('Template', 'همیاری').' ها',
            'class'=>'form-control']).'<br>';
        
        echo '<div id="row_dim">';
            echo $this->Form->control('challengeuserprofile.center',[
                'type'=>'select',
                'options'=> $center,
                'label'=>'نوع مرکز',
                'class'=>'form-control']).'<br>';
        
            echo $this->Form->control('challengeuserprofile.center_name',[
                'type'=>'text',
                'label'=>'نام مرکز',
                'class'=>'form-control']).'<br>';
        
            echo $this->Form->control('challengeuserprofile.semat',[
                'type'=>'text',
                'label'=>'سمت ',
                'class'=>'form-control']).'<br>';
        echo '</div>';

        echo '<hr>';

        echo $this->Form->control('challengeuserprofile.email',[
            'type'=>'email',
            'aria-invalid'=>true,
            'id'=>'template-contactform-email',
            'dir'=>'ltr',
            'escape'=>false,
            'placeholder'=>'...@...',
            'label'=>'پست الکترونیکی (دریافت آخرین اطلاعات بصورت ایمیل)'.' <span class="badge badge-danger pb-0">*</span>',
            'class'=>'form-control ltr']).'<br>';
        
        echo $this->Form->control('challengeuserprofile.mobile',[
            'type'=>'text',
            'required',
            'dir'=>'ltr',
            'placeholder'=>'09...',
            'label'=>'شماره موبایل (دریافت آخرین اطلاعات بصورت پیامکی)'.' <span class="badge badge-danger pb-0">*</span>',
            'escape'=>false,
            'class'=>'form-control ltr']).'<br>';
        
        echo '<hr>';
        
        if(isset($challengetopics)):
        echo $this->Form->control('challengeuserprofile.challengetopics._ids', [
            'options' => $challengetopics,
            'label'=>'حوزه تخصصی ',
            'id'=>'template-contactform-tags-select',
            'style'=>'width: 100%;',
            'class'=>'select-tags input-select2 form-control', ]).'<br>';
        endif;

        /* echo '<hr>';
        echo $this->Form->control('file', [
            'type'=>'file',
            "id"=>'FilUploader',
            'label'=>'تصویر پروفایل کاربری',
            'class'=>'form-control mb-2 ltr']) */
        ?>
    </div>
</div>


<?php 
echo $this->Form->button(__('ثبت اطلاعات'),
    ['class'=>'float-right btn btn-sm btn-primary m-0 ml-1 mt-4','style'=>'margin-left: 10px !important;']);
?>
<style nonce="<?=get_nonce?>">
#userprofiles .input {
    margin-top:15px;
}
#userprofiles label{
    margin:0;
    letter-spacing: 0;
    font-size:15px;
    font-weight: normal;
}
.button{
    letter-spacing: 0;
    font-weight: normal;
}
.error-message{
    background: #f7414a;
    color: #FFF;
    padding: 5px
}
</style>
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
<?= $this->Form->end() ?>
<br><br>
