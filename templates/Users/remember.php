<?php
use Predata\Predata;
$predata = new Predata();
?>
<div class="auth-wrapper auth-v2">
    <div class="auth-inner row m-0">
        <!-- Login-->
        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                <h1 class="card-title font-weight-bold mb-1">
                    <?= $this->Func->OptionGet('name');?>
                </h1>
                <div>
                <h4 class="card-title mb-1">
                    <?=__d('Template', 'یادآوری رمز عبور')?>
                </h4>
                <?php 
                if (($alert = $this->Func->OptionGet('remember_alert')) != null) :
                    echo '<div class="alert alert-info">'.$alert.'</div>';
                endif;

                if ($this->Func->OptionGet('remember_status') != 0) :
                    echo $this->Flash->render();
                    echo $this->Form->create(null);
                    echo '<div class="form-group">'.

                        $this->Form->control('username', array(
                            'label' => $predata->getvalue('register_type', $this->Func->OptionGet('register_type')).' *',
                            'class' => 'form-control',
                            'oninvalid' => "this.setCustomValidity('".__('لطفا چیزی وارد کنید')."')",
                            'oninput' => "setCustomValidity('')",
                            'dir' =>'ltr',
                            'required')).'</div>';

                        echo '<div class="secimg">';
                        echo $this->Captcha->create('securitycode', [
                            'reload_txt' => '<i data-feather="refresh-ccw"></i>',
                            //'clabel'=>' ',
                            'clabel'=>__('کد امنیتی نشان داده شده را وارد کنید:'),
                            'type'=>'number', // 'recaptcha' , 'math', 'image', 'number'
                            //'sitekey'=>'xxxxxxxxxxxxxxxxxxxxxx-xx', //set if it is recaptcha
                            //'theme'=>'random'
                        ]);
                        echo '</div>';
                    ?>
                    <div class="clearfix"></div><br>
                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary px-2">
                                <?= __d('Template', 'دریافت رمز تازه')?>
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <p class="text-center pt-1">
                                <?= $this->html->link(__('ورود'), ['action'=>'login']);?>
                            </p>
                        </div>
                    </div>
                    
                    <?= $this->Form->end();?> 
                    <?php endif;?>
                </div>
                
            </div>
        </div>
        <!-- /Login-->

        <!-- Left Text-->
        <div class="d-none d-lg-flex col-lg-7 align-items-center p-5">
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                <?= $this->html->image(
                    ($img = $this->Func->OptionGet("remember_backimg")) != ''? $img :'/admin/img/login-v2.svg',
                    ['class'=>'img-fluid'] )?>
            </div>
        </div>
        <!-- /Left Text-->
    </div>
</div>
<style><?= $this->Func->OptionGet("remember_style");?></style>
<script nonce="<?=get_nonce?>">
jQuery('.creload').on('click', function() {
    var mySrc = $(this).prev().attr('src');
    var glue = '?';
    if(mySrc.indexOf('?')!=-1)  {
        glue = '&';
    }
    $(this).prev().attr('src', mySrc + glue + new Date().getTime());
    return false;
});
</script>