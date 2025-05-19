<?= $this->Form->create($users,['url'=>'/users/profile','onsubmit'=>'return checkp()','type'=>'file','class'=>'col-sm-12']);?>

<div class="alert alert-warning text-left">
    - در صورتی که نمیخواهید رمز را تغییر بدهید ، در قسمت رمزعبور قبلی چیزی وارد نکنید
</div>

<div class="row">
    <div class="col-6">
        <?= $this->Form->control('family',[
            'label'=>'نام و نام خانوادگی',
            'class'=>'form-control']);?>
    </div>
    <div class="col-6">
        <?= $this->Form->control('old_password',[
            'label'=>'رمز عبور قبلی',
            'class'=>'form-control']);?>
        <hr>
        <?= $this->Form->control('new_password',[
            'label'=>'رمز عبور جدید',
            'class'=>'form-control']);?>
        <?= $this->Form->control('new_repassword',[
            'label'=>'تکرار رمز عبور جدید',
            'class'=>'form-control']);?>
    </div>
</div>

<?php 
echo $this->Form->button(__('ثبت اطلاعات'),['class'=>'float-right btn btn-primary btn-sm m-0 mt-4']);
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