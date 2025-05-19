<?= $this->Form->create($challengeuserform,['class'=>'col-6']) ?>
<fieldset>
    <legend><?= __('مدیریت فرم مشارکت') ?></legend>
    <?php
        /* echo $this->Form->control('challenge_id', ['options' => $challenges]);
        echo $this->Form->control('user_id', ['options' => $users]); */
        /* echo $this->Form->control('userinfo'); */
        

        echo $this->Form->control('title',[
            'label'=>'عنوان انتخابی برای راهکار پیشنهادی	',
            'class'=>'form-control',
        ]).'<br>';
        
        echo $this->Form->control('descr1',[
            'label'=>'شرح راهکار پیشنهادی	',
            'class'=>'form-control',
        ]).'<br>';
        
        echo $this->Form->control('descr2',[
            'label'=>'لطفاً تشریح کنید چرا راهکار پیشنهادی شما نسبت به راهکارهای موجود مطلوبتر است	',
            'class'=>'form-control',
        ]).'<br>';
        
        echo $this->Form->control('descr3',[
            'label'=>'چنانچه از روش شناسی خاصی بهره می برید، بیان کنید	',
            'class'=>'form-control',
        ]).'<br>';
        
        echo $this->Form->control('descr4',[
            'label'=>'راهکار پیشنهادی شما با فعالیت کدام یک از کمیته های دبیرخانه ارتباط دارد؟	',
            'class'=>'form-control',
        ]).'<br>';
        echo $this->Form->control('filesrc',[
            'label'=>'آدرس فایل ',
            'class'=>'form-control',
        ]);
        echo $this->Form->control('enable');
        echo $this->Form->control('approved');
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>