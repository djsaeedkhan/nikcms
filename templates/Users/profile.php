<?php

echo $this->Form->create($user, ['url'=>'/users/profile',
    'type'=>'file',
    'onsubmit'=>'return checkp()',
    'class'=>'col-sm-12']);
?>
<h4><?= __('ویرایش مشخصات کاربری')?></h4><br>
<div class="row">
    <div class="col-6">
        <?= $this->Form->control('old_password', [
            'label'=>__('رمز عبور قبلی'),
            'class'=>'form-control']);?>
            <small><?= __('اگر نمیخواهید رمز را تغییردهید، چیزی وارد نکنید')?></small>
        <hr>

        <?= $this->Form->control('new_password', [
            'id'=>'new_password',
            'label'=>__('رمز عبور جدید'),
            'class'=>'form-control']);?>

        <?= $this->Form->control('new_repassword', [
            'id'=>'new_repassword',
            'label'=>__('تکرار رمز عبور جدید'),
            'class'=>'form-control']);?>
    </div>
    <div class="col-6">
        <?= $this->Form->control('family',[
            'label'=>__('نام و نام خانوادگی'),
            'class'=>'form-control']);?>
    </div>
</div>


<?php 
echo $this->Form->button(__('ثبت اطلاعات'),['class'=>'float-right button button-3d m-0 mt-4']);
echo $this->Form->end();
?>

<script nonce="<?=get_nonce?>">
    function checkp() {
    var pass = $('input[name=new_password]').val();
    var repass = $('input[name=new_repassword]').val();
    if(($('input[name=new_password]').val().length == 0) || ($('input[name=new_repassword]').val().length == 0)){
        $('#new_password').addClass('has-error');
    }
    else if (pass != repass) {
        $('#new_password').addClass('has-error');
        $('#new_repassword').addClass('has-error');
        return false;
    }
    else {
        $('#new_password').removeClass().addClass('has-success form-control');
        $('#new_repassword').removeClass().addClass('has-success form-control');
    }
    return true;
};
</script>

<style>
.has-success{background-color: #d9e8c8;}
.has-error{background-color: #fde5dd;}
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
