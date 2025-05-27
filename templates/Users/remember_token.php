<div class="content-body">
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <div class="card mb-0">
                <div class="card-body">
                <h4 class="card-title mb-1">
                    <?=__('یادآوری رمز عبور')?>
                     » 
                    <?=__('ثبت رمز جدید')?>
                </h4>
                <?php 
                /* if($this->Func->OptionGet('remember_alert') != null):
                    echo '<div class="alert alert-info">'.$this->Func->OptionGet('remember_alert').'</div>';
                endif; */

                if ($this->Func->OptionGet('remember_status') != 0) :?>
                    <?php 
                        echo $this->Flash->render();
                        echo $this->Form->create(null);
                        if ($token == null) {
                            echo $this->Form->control('token', array(
                                'value'=>'',
                                'label'=>__('کد تایید ارسال شده'),
                                'class'=>'form-control',
                                'dir'=>'ltr',
                                'required')).'<br>';
                        }
                        echo $this->Form->control('password', array(
                            'value'=>'',
                            'label'=>__('لطفا رمز عبور تازه را وارد نمایید'),
                            'type'=>'password',
                            'class'=>'form-control',
                            'dir'=>'ltr','required'));
                        ?>
                        <div class="clearfix"></div><br>
                        <button type="submit" class="btn btn-primary px-2 float-left">
                            <?= __('ثبت رمز جدید')?>
                        </button>
                        
                        <?php echo $this->Form->end();?> 

                    <?php endif?>
                </div>
            </div>
            <!-- /Reset Password v1 -->
        </div>
    </div>
</div>
<style><?= $this->Func->OptionGet("remember_style");?></style>
