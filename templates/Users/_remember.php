<div class="content-body">
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <div class="card mb-0">
                <div class="card-body">
                <h4 class="card-title mb-1">یادآوری رمز عبور</h4>
                <?php 
                if($this->Func->OptionGet('remember_alert') != null):
                    echo '<div class="alert alert-info">'.$this->Func->OptionGet('remember_alert').'</div>';
                endif;

                if($this->Func->OptionGet('remember_status') != 0):?>
                    <!-- <div class="alert alert-info">
                        لطفاً نام کاربری یا نشانی ایمیل خود را‌ وارد کنید. از طریق ایمیل، پیوندی برای ساختن رمز تازه دریافت خواهید کرد.
                    </div> -->
                    
                    <?php 
                    echo $this->Flash->render();
                    echo $this->Form->create(null);
                    echo '<div class="form-group">'.$this->Form->control('username',array(
                        'label'=>'نام کاربری',
                        'class'=>'form-control',
                        'oninvalid' =>"this.setCustomValidity('لطفا چیزی وارد کنید')",
                        'oninput'=>"setCustomValidity('')",
                        'dir'=>'ltr','required')).'</div>';

                        echo '<div class="secimg">';
                        echo $this->Captcha->create('securitycode', [
                            'reload_txt' => '<i data-feather="refresh-ccw"></i>',
                            //'clabel'=>' ',
                            'clabel'=>'کد امنیتی نشان داده شده را وارد کنید:',
                            'type'=>'number', // 'recaptcha' , 'math', 'image', 'number'
                            //'sitekey'=>'xxxxxxxxxxxxxxxxxxxxxx-xx', //set if it is recaptcha
                            //'theme'=>'random'
                        ]);
                        echo '</div>';
                    ?>
                    <div class="clearfix"></div><br>
                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary px-4">دریافت رمز تازه</button>
                        </div>
                        <div class="col-sm-4">
                            <p class="text-center pt-1">
                                <?= $this->html->link('ورود',['action'=>'login']);?>
                            </p>
                        </div>
                    </div>
                    
                    <?= $this->Form->end();?> 
                    <?php endif?>
                </div>
            </div>
            <!-- /Reset Password v1 -->
        </div>
    </div>
</div>