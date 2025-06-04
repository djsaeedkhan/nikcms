<?php
use Predata\Predata;
$predata = new Predata();
?>
<div class="auth-wrapper auth-v2">
    <div class="auth-inner row m-0">
        <!-- Login-->
        <div class="col-lg-5 align-items-center auth-bg px-2 p-lg-5">
            <h1 class="card-title font-weight-bold mb-1">
                <?= $this->Func->OptionGet('name');?>
            </h1>
            <?php
                echo $this->Flash->render();
                echo $this->Form->create(null,['class'=>'auth-login-form mt-2']);

                echo '<div class="form-group">'. $this->Form->control('mobile',[
                    'label'=>__d('Sms', 'لطفا کدتایید پیامک شده را وارد نمایید'),
                    'class'=>'form-control',
                    'dir'=>'ltr',
                    'placeholder' =>'XXXXXX',
                    'maxlength' => 10,
                    'style'=>'font-family: sans-serif;text-align: center;margin: 0 auto;letter-spacing: 10px;',
                    'required']).'</div>';
                    
                echo $this->Form->button(__d('Sms', 'تایید شماره موبایل'), [
                    'class'=>'btn btn-primary btn-block']);

                echo '<p class="text-left mt-2">
                        <span class="1text-muted">'. __d('Sms', 'برگشت به') .' '.
                        $this->html->link($this->Func->OptionGet('name'),'/').
                    '</p>';
                echo $this->Form->end();
            ?>
            <div style="text-align: left;direction: ltr;float: left;padding-top: 5px;" class="resendiv">
                <?= __d('Sms', 'ارسال دوباره پیامک تا')?> <span id="demo">1:00</span>
            </div>

            <?php
            if($this->Func->OptionGet('register_type') == 'mobile'){
                echo $this->Form->postlink(
                    __d('Sms', 'ارسال دوباره پیامک تایید'),
                    '/sms/autoactivate/',
                    ['class'=>'float-right mt-1 d-none resendag']);
            }
            else{
                echo $this->html->link(
                    __d('Sms', 'ارسال دوباره پیامک تایید'),
                    '/sms/activation/',
                    ['class'=>'float-right mt-1 d-none resendag']);
            }
            ?>
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

<style>
<?= $this->Func->OptionGet("login_style");?>
</style>

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
<script nonce="<?=get_nonce?>">
<?php
use Cake\I18n\Time;
$time = new Time();
$time->setTimezone(new \DateTimeZone('Asia/Tehran'));
$time->addMinutes(1);
$timer = $time->format('Y-m-d H:i:s');
?>
var t4;
var countDownDate = new Date("<?=$timer?>").getTime();
var x = setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    //var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("demo").innerHTML =  minutes + ":" +seconds ;
    //document.getElementById("demo").innerHTML = minutes + "دقیقه " + seconds + "ثانیه ";
    if (distance < 0) {
        clearInterval(x);
        $('.resendag').removeClass('d-none');
        $('.resendiv').addClass('d-none');
    }
}, 1000);
</script>