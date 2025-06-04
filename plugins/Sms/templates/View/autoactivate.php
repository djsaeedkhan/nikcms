<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-group mb-0">
                <div class="card p-4">
                    <div class="card-body">
                        <div class="alert alert-warning">
                            - <?= __d('Sms', 'برای دریافت کدفعال سازی  بر روی کلید <b>"ارسال پیامک تایید"</b> کلیک کنید')?><br>
                            - <?= __d('Sms', 'در صورتی که شماره تلفن همراه اشتباه است آن را اصلاح نمایید')?>.<Br>
                            - <?= __d('Sms', 'شماره تلفن همراه را بصورت لاتین وارد نمایید')?>.
                        </div><Br>
                        <?php 
                        echo $this->Flash->render();
                        echo $this->Form->create();
                        echo $this->Form->control('mobile',[
                            'label'=>__d('Sms', 'شماره تلفن همراه'),
                            'class'=>'form-control',
                            'type'=>'number',
                            'style' =>'font-family: sans-serif;font-size: 16px;',
                            'default' => isset($user['data']['SmsValidations']['mobile'])?$user['data']['SmsValidations']['mobile']:null,
                            'dir'=>'ltr','required']);
                        ?>
                        <!-- <div class="alert alert-warning" style="padding:5px;">
                            کدتایید به شماره  
                            <b><?php //$user['data']['SmsValidations']['mobile'];?></b>
                            ارسال خواهد شد 
                            در صورتی که شماره تلفن همراه اشتباه است آن را اصلاح نمایید
                        </div> -->
                        <div class="clearfix"></div><br>
                        <button type="submit" class="btn btn-primary px-4 float-left">
                            <?= __d('Sms', 'ارسال پیامک تایید')?>
                        </button>
                        <?php echo $this->Form->end();?> 
                    </div>
                </div>
            </div><?php echo $this->html->link(
                __d('Sms', 'ورود'),
                ['plugin'=>false,'controller'=>'users','action'=>'login']);?>
        </div>
    </div>
</div>
<style>
.error-message{
    background: #FFEB3B;
    font-size: 13px;
    padding: 3px 5px;
}
/* body{background: url('<?= $this->Func->OptionGet("st__login_background");?>') center  #f1f1f1;} */
</style>