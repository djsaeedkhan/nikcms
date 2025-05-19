<div class="container" style="margin-top: 1em;">
        <?= $this->Form->create($user,['url'=>['action'=>'edit']]) ?><br>
        <div class="card person-card">
            <div class="card-body">
            <?= $this->html->image('/admin/img/life_cycle.svg',['id'=>'img_sex','class'=>'person-img']);?>
                <!-- <h2 id="who_message" class="card-title">لطفا مشخصاتتان را تکمیل فرمایید</h2> -->
                <h2 id="who_message" class="card-title"><?= __d('Admin', 'پروفایل کاربری')?></h2>
            </div>
        </div>
        
        <div class="row">

            <div class="col-md-6">
                <div class="card"> 
                    <div class="card-body">
                        <h4 class="card-title"><?= __d('Admin', 'مشخصات کاربری')?></h4>
                        <div class="form-group">
                            <label for="password" class="col-form-label"><?= __d('Admin', 'نام کاربری')?></label>
                            <div class="form-control"><?=$user['username']?></div>
                            <div class="password-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="password_conf" class="col-form-label"><?= __d('Admin', 'نام و نام خانوادگی')?></label>
                            <?= $this->Form->control('family',['class'=>'form-control',
                                'default'=>$user['family'],
                                'label'=>false ])?>
                            <div class="badge badge-secondary small">
                                <?= __d('Admin', 'برای اعمال تغییرات می بایست یکبار از سامانه خارج و دوباره وارد شوید')?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card"> 
                    <div class="card-body">
                        <h4 class="card-title"><?= __d('Admin', 'تغییر رمز عبور')?></h4>
                        <div class="form-group">
                            <label for="password" class="col-form-label"><?= __d('Admin', 'رمز عبور')?></label>
                            <?= $this->Form->control('password',['class'=>'form-control','label'=>false])?>
                            <div class="badge badge-secondary">
                                <?= __d('Admin', 'اگر نمیخواهید رمز را عوض کنید چیزی وارد نکنید')?>
                                (<?= __d('Admin', 'خالی باشد')?>)
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6 pps">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= __d('Admin', 'مشخصات فنی')?></h4>
                        <div class="ppp">
                            <?= $this->Func->create_form(Admin\View\Helper\ModuleHelper::options_profileuserfield(), $meta_list)?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style="margin-top: 1em;">
            <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-primary btn-lg btn-block']);?>
        </div><br><br>
        <?= $this->Form->end() ?>
</div>

<script nonce="<?=get_nonce?>">
    let length = $(".ppp").html().length;
    if(length < 55) $(".pps").addClass('d-none');
    if($(".ppp").html() === " ") $(".pps").addClass('d-none');
</script>
<style>

.card {
    margin-top: 1em;
}

/* IMG displaying */
.person-card {
    margin-top: 5em;
    padding-top: 5em;
}
.person-card .card-title{
    text-align: center;
}
.person-card .person-img{
    width: 10em;
    position: absolute;
    top: -5em;
    left: 50%;
    margin-left: -5em;
    border-radius: 100%;
    overflow: hidden;
    background-color: white;
}
</style>