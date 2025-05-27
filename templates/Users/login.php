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

                <p class="card-text mb-2">
                    <?=__d('Template', 'ورود به حساب کاربری')?>
                </p>

                <?php
                    if ($this->Func->OptionGet('login_status') == 0 and 
                        (!isset($_GET['key']) or $_GET['key']!= $this->Func->OptionGet('login_key'))) :
                        echo '<div class="alert alert-danger text-center">'.$this->Func->OptionGet('login_alert').'</div>';
                    
                    else:
                        echo $this->Flash->render();
                        echo $this->Form->create(null, ['class'=>'auth-login-form mt-2']);

                        echo '<div class="form-group">'.$this->Form->control('username',array(
                            'label'=> $predata->getvalue('register_type', $this->Func->OptionGet('register_type')).' *',
                            'class'=>'form-control',
                            'dir'=>'ltr',
                            'required')).'</div>';
                            
                        echo '<div class="form-group">'.
                            $this->Form->control('password', [
                                'label'=>'کلمه عبور',
                                'class'=>'form-control mb-1',
                                'autocomplete'=>'off',
                                'dir'=>'ltr',
                                'required']).'</div>';

                        if( $this->getRequest()->getSession()->check('show_recaptcha') == 1):
                            echo $this->Captcha->create('securitycode', [
                                'reload_txt' => 'تصویر جدید',
                                'clabel'=>'کد امنیتی نشان داده شده در بالا را وارد کنید:',
                                'type'=>'number', // 'recaptcha' , 'math', 'image', 'number'
                                //'sitekey'=>'xxxxxxxxxxxxxxxxxxxxxx-xx', //set if it is recaptcha
                                //'theme'=>'random'
                            ]);
                        endif;?>
                            <div class="form-group mb-2" style="float: left;">
                                <div class="custom-control custom-checkbox">
                                    <?= $this->html->link('<small>'.__('کلمه عبور را فراموش کرده ام') .'</small>',
                                            ['action'=>'remember'],
                                            ['style'=>'float:left', 'escape'=>false])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group mb-2" style="float: right;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                                    <label class="custom-control-label" for="remember">
                                        <?= __('مرا به خاطر بسپار')?>
                                    </label>
                                </div>
                            </div>
                        <?php
                        //echo '<input class="form-control" type="checkbox" name="remember"> Remember Me';
                        echo $this->Form->button(__d('Template', 'ورود'), ['class'=>'btn btn-primary btn-block']);

                        echo '<p class="text-left mt-2 mb-2">';
                        echo ( ($link = $this->Func->OptionGet('register_linkurl')) !='')?
                            '<span>'.__('اگر حساب کاربری ندارید') .'، </span>'.
                            $this->html->link(__('اینجا کلیک کنید'), $link, []):
                            '<span>'. __('اگر حساب کاربری ندارید') .'، </span>'.
                            $this->html->link(__('اینجا کلیک کنید'), ['action'=>'register'],[]);
                        echo '</p>';
                        /* echo '<p class="text-left mt-2 mb-2">
                                <span class="1text-muted">برگشت به '.
                                $this->html->link($this->Func->OptionGet('name'),'/').
                            '</p>'; */
                            
                        echo $this->Form->end();
                    endif;

                    echo $this->Func->OptionGet('login_footertext');
                    ?>
            </div>
        </div>
        <!-- /Login-->

        <!-- Left Text-->
        <div class="d-none d-lg-flex col-lg-7 align-items-center p-5">
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                <?= $this->html->image(
                    ($img = $this->Func->OptionGet("login_backimg")) != ''? $img :'/admin/img/login-v2.svg',
                    ['class'=>'img-fluid'] )?>
            </div>
        </div>
        <!-- /Left Text-->
    </div>
</div>
<style><?= $this->Func->OptionGet("login_style");?></style>
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