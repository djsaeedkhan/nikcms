<?php
use Predata\Predata;
$predata = new Predata();
?>
<div class="auth-wrapper auth-v2">
    <div class="auth-inner row m-0">
        <div class="d-flex col-lg-5 align-items-center auth-bg px-2 p-lg-5">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">

                <h1 class="card-title font-weight-bold mb-1">
                    <?= $this->Func->OptionGet('name');?> 
                    <?= $this->Func->OptionGet('register_title');?>
                </h1>

                <p class="card-text mb-2">
                    <?= __('ایجاد حساب کاربری جدید')?>
                </p>

                <?php
                    $register_status = $this->Func->OptionGet('register_status');
                    if($register_status == 0 ):
                        echo '<div class="alert alert-danger text-center">'.$this->Func->OptionGet('register_alert').'</div>';
                        echo $this->html->link(__('ورود به پنل کاربری'), 
                            ['action'=>'login'],
                            ['class'=>'btn btn-secondary']);
                    else:
                        echo $this->Flash->render();
                        echo $this->Func->OptionGet('register_toptext');
                        echo $this->Form->create($user, ['id'=>'forms']);

                        echo '<div class="register_input">';
                        if( $this->Func->OptionGet('field_family') == 1)
                            echo $this->Form->control('family',array(
                                'label'=> __('نام و نام خانوادگی') .' *',
                                'required',
                                'class'=>'form-control',
                                'style'=>'margin-bottom:10px',
                            ));
                        echo $this->Form->control('username',array(
                            'label'=> $predata->getvalue('register_type',$this->Func->OptionGet('register_type')).
                                ' *'.
                                (
                                    $this->Func->OptionGet('register_username_text')!=''?
                                        '<div class="alert alert-secondary mb-0">'.$this->Func->OptionGet('register_username_text').'</div>':
                                        ''
                                ),
                            'class'=>'form-control',
                            'oninvalid'=>"this.setCustomValidity('".__('لطفا نام کاربری را وارد نمایید') ."')",
                            'oninput' => "setCustomValidity('')" ,
                            'style'=>'margin-bottom:10px',
                            'escape'=>false,
                            'dir'=>'ltr',
                            'required'));
                        //echo $this->Func->OptionGet('register_username_text');

                        echo $this->Form->control('password', array(
                            'type'=>'password',
                            'label'=>__('رمز عبور') .' *'.
                            (
                                $this->Func->OptionGet('register_password_text')!=''?
                                    '<div class="alert alert-secondary mb-0">'.$this->Func->OptionGet('register_password_text').'</div>':
                                    ''
                            ),
                            'oninvalid'=>"this.setCustomValidity('".__('لطفا رمز عبور را وارد نمایید') ."')",
                            'oninput'=>"setCustomValidity('')",
                            'class'=>'form-control',
                            'style'=>'margin-bottom:10px',
                            'dir'=>'ltr','required',
                            'data-toggle'=> "popover",
                            'data-placement'=>"left",
                            'data-content'=>__('رمز عبور نباید کمتر از 8 حرف باشد'),
                            'data-trigger'=>"hover",
                            'data-original-title' => __('راهنمایی'),
                            'escape'=>false,
                        ));
                        echo '</div>';

                        pr(\Admin\View\Helper\ModuleHelper::options_registerform());
                        echo '<div class="register_fields">'.
                            $this->Func->create_form(\Admin\View\Helper\ModuleHelper::options_registerform());
                        echo '</div><div class="clearfix"></div>';

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

                        <input type="checkbox" id="app_box" required 
                            on_invalid="this.setCustomValidity('<?=__('لطفا تیک قوانین و مقررات را بزنید')?>')"
                            on_input="setCustomValidity('')"
                            class="mt-2 mb-2" 
                            value="checked"> 
                            <?= $this->html->link(
                                __('قوانین و مقررات را مطالعه کرده و قبول دارم'), 
                                $this->Func->OptionGet('register_legallink'),
                                ['target'=>'_blank'])?>
                        <br>
                        
                        <div class="row">
                            <div class="col-sm-7">
                                <button type="submit" class="btn btn-primary px-2">
                                    <?=__d('Template','تایید اطلاعات')?>
                                </button>
                            </div>
                            <div class="col-sm-5">
                                <p class="mt-0" style="text-align: left;">
                                    <?= ( ($link = $this->Func->OptionGet('login_linkurl')) !='')?
                                        $this->html->link(__('ورود'), $link):
                                        $this->html->link(__('ورود'), ['action'=>'login']);?>
                                </p>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->end();

                    endif;
                    
                    echo $this->Func->OptionGet('register_footertext');
                    ?> 
            </div>
        </div>

        <!-- Left Text-->
        <div class="d-none d-lg-flex col-lg-7 align-items-center p-5">
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                <?= $this->html->image(
                    ($img = $this->Func->OptionGet("register_backimg")) != ''? $img :'/admin/img/login-v2.svg',
                    ['class'=>'img-fluid'] )?>
            </div>
        </div>
        <!-- /Left Text-->

    </div>
</div>
                <!-- 
                <?php if($register_status != 0):?>
                    <?php $reg_text = $this->Func->OptionGet('st__register_info');?>
                <div class="card text-white bg-primary py-5 d-md-down-none <?=$reg_text==''?'d-none':''?>" dir="rtl" style="width:34%">
                    <div class="card-body " style="text-align: right;">
                        <div>
                            <?php // $reg_text?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div> -->

<style>
.error-message{
    background: #FFEB3B;
    font-size: 13px;
    padding: 3px 5px;
}

body{
    background: url('<?= $this->Func->OptionGet("register_backimg");?>') center  #f1f1f1;
    background-attachment: fixed;}

@media (min-width: 600px){
    .creload{
        margin-top: 55px;
        position: absolute;
        margin-right: 5px;
    }
    .secimg img{
        margin-bottom: -112px !important;
    }
}
.input label{
    width: 100%;
}

<?= $this->Func->OptionGet("register_style");?>
</style>

<script nonce="<?=get_nonce?>">
$('#forms').submit(function(){ 
    if (! $('#app_box')[0].checked){
        alert('<?= __('لطفا بعد از مطالعه قوانین و مقررات، تیک گزینه را بزنید')?>');
        return false;
    }
    /* if(!checkPasswordMatch())
        return false; */
}); 
function checkPasswordMatch() {
    if ($(".register_input #password").val() != $(".register_input #repassword").val()){
        alert('<?= __('کلمه عبور و تکرار کلمه عبور یکسان نمی باشد')?>.');
        return false;
    }
    else
        return true;
}
</script>
<!-- <script 
src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
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