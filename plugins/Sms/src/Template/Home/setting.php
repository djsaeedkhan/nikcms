<?php
use Cake\Routing\Router;
$sms = new \Sms\Sms();
?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Sms','مدیریت پیامک');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" 
                aria-selected="true"><?=__d('Sms','تنظیمات پیامک')?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#smstext" role="tab" aria-controls="smstext" 
                aria-selected="true"><?= __d('Sms','متن پیامک')?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#sendsms" role="tab" aria-controls="sendsms" 
                aria-selected="true"><?= __d('Sms','ارسال پیامک')?></a>
        </li>
        <li class="nav-item">
            <?= $this->html->link(
                __d('Sms','گزارش پیام ها'),
                '/admin/sms/log',
                ['class'=>'nav-link'])?>
        </li>
    </ul>
    
    <?php
        echo $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
        if(count($result)):
            $hsite = unserialize($result['plugin_sms']);
            $this->request = $this->request->withData('plugin_sms',$hsite);
        endif;
    ?>
    <div class="tab-content">

        
        <div class="tab-pane" id="smstext" role="tabpanel">
            <div class="alert alert-danger ltr text-left">
                <?= __d('Sms','اگر متن پیامک ها خالی باشد، آن بخش کار نخواهد کرد')?>
            </div>
            <div class="alert alert-secondary ltr text-left">
                %token% : <?= __d('Sms','کد اعتبارسنجی')?><br>
                %username% : <?= __d('Sms','نام کاربری')?><br>
                %family% : <?= __d('Sms','نام و نام خانوادگی')?><br>
                %password% : <?= __d('Sms','رمز عبور')?><br>
            </div>
            <div class="card"><div class="card-body"><div class="row">

                <?php
                $arr = [
                    #'smstext_before'=>'متن ابتدای هر پیامک',
                    #'smstext_after'=>'متن انتهای هرپیامک',
                    'smstext_activate'=>__d('Sms','متن تایید شماره موبایل'),
                    'smstext_regsucc'=>__d('Sms','متن تایید ثبت نام'),
                    'smstext_remember'=>__d('Sms','متن فراموشی پسورد'),
                    'smstext_10dayexpire'=>__d('Sms','متن یادآوری 10 روز مانده به انقضا اکانت کاربر'),
                    'smstext_expire'=>__d('Sms','متن یادآوری انقضا اکانت کاربر'),
                    'smstext_register'=>__d('Sms','متن پیامک ارسال مشخصات ثبت نام') .' <br>%username% %password%',
                ];
                foreach($arr as $a => $t){
                    echo '<div class=" col-sm-6">';
                    echo $this->Form->control('plugin_sms.'.$a , [
                        'style'=>'height:100px;',
                        'label'=> $t,
                        'type'=>'textarea','escape'=>false,
                        'class'=> 'rtl form-control mb-1']);
                    echo '</div>';
                }
                ?>

                <?= $this->Form->button(
                    __d('Sms','ثبت اطلاعات'),
                    ['class'=>'btn btn-success col-xs-3']);?>

            </div></div></div>
        </div>
        <div class="tab-pane active show" id="home" role="tabpanel">

            <div class="row">
            <div class="card col-sm-6"><div class="card-body">
            <?php
            if($sms->status() === false){
                echo '<div class="alert alert-danger">'.__d('Sms','هنوز تنظیمات سامانه پیامکی را فعال نکرده اید') .'</div>';
            }

            echo $this->Form->control('plugin_sms.sms_panel', ['type'=>'select',
                'label'=>__d('Sms','انتخاب سامانه فرستنده پیامک'), 
                'class'=> 'form-control mb-1',
                'empty'=>'-- --',
                'options'=>[
                    'vandasms'=>'VandaSMS - سامانه پیامک وندا',
                    'payamak90'=>'Payamak90 - سامانه پیامک90',
                    'mihansms'=>'MihanPayamak - سامانه میهن پیامک',
                    'asanak'=>'Asanak - سامانه آسانک ',
                ],
            ]);
            $arr = [
                'sms_username'=>__d('Sms', 'نام کاربری') .' (Username)',
                'sms_password'=>__d('Sms', 'رمز عبور') .' (Password)',
                'sms_sender'=> __d('Sms', 'شماره فرستنده') .' (Sender)',
                'sms_apiurl'=>__d('Sms', 'آدرس اتصال').' (API)',
            ];
            foreach($arr as $a=>$t)
                echo $this->Form->control('plugin_sms.'.$a , [
                    'label'=> $t, 'class'=> 'ltr form-control mb-1'
                    ])
            ?>
            </div></div>

            
            <div class="card col-sm-6"><div class="card-body">

            <?php
            echo $this->Form->control('plugin_sms.sendbysingle_sender',[
                'label'=>__d('Sms', 'ارسال پیامک تاییده توسط'),
                'type'=>'select',
                'options'=>[
                    'number'=>__d('Sms', 'خط پیامک Sender (بالا وارد شده)'),
                    'pattern'=>__d('Sms', 'خط پترن (باکس بعد وارد کنید)') 
                ],
                'class'=> 'form-control mb-1']);

            echo '<div class="alert alert-info"><h5>'.__d('Sms', 'در صورتی که خط پترن انتخاب شده است تکمیل کنید') .'.</h5><br>';
                echo $this->Form->control('plugin_sms.sendbysingle_provider',[
                    'label'=>__d('Sms', 'ارائه دهنده پترن'),
                    'type'=>'select',
                    'options'=>[
                        'ippanel'=>'IpPanel',
                        'vanda'=>'VandaSMS.ir'
                    ],
                    'class'=> 'form-control mb-1']);

                echo '<div class="row"><div class="col-sm-6">';
                    echo $this->Form->control('plugin_sms.sendbysingle_user',[
                        'label'=>__d('Sms', 'نام کاربری'),
                        'class'=> 'form-control ltr mb-1'
                    ]);

                echo '</div><div class="col-sm-6">';
                    echo $this->Form->control('plugin_sms.sendbysingle_pass',[
                        'label'=>__d('Sms', 'پسورد'),
                        'class'=> 'form-control ltr mb-1'
                    ]);

                echo '</div></div>';

                
                echo '<div class="row"><div class="col-sm-6">';
                    echo $this->Form->control('plugin_sms.sendbysingle_sendnum', [
                        'label'=>__d('Sms', 'شماره فرستنده'),
                        'class'=> 'form-control ltr mb-1']);

                echo '</div><div class="col-sm-6">';
                    echo $this->Form->control('plugin_sms.sendbysingle_bodyid',[
                        'label'=>__d('Sms', 'کدوبسرویس') .' (BodyId)',
                        'class'=> 'form-control ltr mb-1']);

                echo '</div>
                <div class="col-sm-12">';
                    echo $this->Form->control('plugin_sms.sendbysingle_pattern',[
                        'label'=>__d('Sms', 'لیست پارامترها'),
                        'placeholder'=>'code,user, ...',
                        'class'=> 'form-control ltr mb-1']);
                echo '</div>
                </div>';

            echo '</div>';


            echo $this->Form->control('plugin_sms.redirect',[
                'label'=>__d('Sms', 'لینک مقصد'),
                'placeholder'=>'http://',
                'class'=> 'ltr form-control'
                ]);
            echo '<div class="small mb-1">'.__d('Sms', 'پس از تایید شماره موبایل به چه آدرسی هدایت شود') .'</div>';
            
            echo $this->Form->control('plugin_sms.redirect_alert',[
                'label'=>__d('Sms', 'پیغام تایید شماره'),
                'class'=> 'form-control'
                ]);
            echo '<div class="small mb-1">'.__d('Sms', 'پس از تایید شماره موبایل چه پیامی به کاربر نمایش داده شود') .'</div>';?>

            </div></div>
            </div>
            <?= $this->Form->button(
                __d('Sms', 'ثبت اطلاعات'),
                ['class'=>'btn btn-success col-xs-3']);?>

            
        </div>
        <?= $this->Form->end();?>
        
        <div class="tab-pane col-sm-6" id="home1" role="tabpanel">
            <?php
            echo $this->Form->create(null,[
                'id'=>'idForm',
                'url'=>['action'=>'sendsms']]);

            echo $this->Form->control('plugin_sms.mobile', [
                'label'=> __d('Sms', 'شماره گیرنده'),
                'class'=> 'form-control mb-1 ltr',
                'placeholder'=>'09',
                'required'
            ]);

            echo $this->Form->control('plugin_sms.text', [
                'type'=> 'textarea',
                'label'=> __d('Sms', 'متن پیامک'),
                'class'=> 'form-control mb-1',
                'required']);

            echo $this->Form->submit(__d('Sms', 'ارسال پیامک'),[
                'class'=>'btn btn-success col-xs-3 mb-1',
                'id'=>'sendsms']);

            echo '<div class="alert alert-warning d-none" id="show_status"></div>';
            echo $this->Form->end();?>
        </div>
    </div>
    
</div>

<script nonce="<?=get_nonce?>">
$("#idForm").submit(function(e) {
    $('#show_status').removeClass('d-none');
    $('#show_status').text('<?= __d('Sms', 'درحال ارسال پیامک')?> ...');
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    var result = '';
    $.ajax({
        type : 'POST',
        async: true,
        data:  form.serialize(),
        url : "<?= Router::url(['action' => 'sendsms'],false) ?>",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success : function(data){
            result = JSON.parse(data);
            console.log(result);
            if(result['SendSmsResult'] == "1"){
                if(result['status'] == "")
                    $('#show_status').text('<?= __d('Sms', 'به علت بلاک بودن شماره موبایل، پیامک ارسال شده به مقصد نرسید')?>');
                else
                    $('#show_status').text('<?= __d('Sms', 'پیامک با موفقیت ارسال شد')?>');
            }
            else
                $('#show_status').text('<?= __d('Sms', 'پیامک ارسال نشد')?>');
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            alert("<?= __d('Sms', 'در ارسال یا دریافت اطلاعات خطایی رخ داده است')?>");
        },
        complete: function (jqXHR, status) {
            if(status == 'success'){
            }
            if(status == 'error'){
                $('#show_status').text('<?= __d('Sms', 'متاسفانه ارسال پیامک با خطا متوقف شد')?>');
            }
        }
    });
});
</script>