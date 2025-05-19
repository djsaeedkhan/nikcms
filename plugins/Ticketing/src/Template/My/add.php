<div id="plugin_ticket_my_add">
    <?php
    echo $this->Form->create($ticket,['type'=>'file','id'=>'forms']);
    echo $this->Form->control('subject',[
        'default'=> $this->request->getQuery('subject')?$this->request->getQuery('subject'):null,
        'class'=>'form-control mb-2',
        'label'=>__d('Ticketing', 'عنوان ') .__d('Template', 'تیکت'),
        'required'
    ]);

    echo $this->Form->control('content', [
        'class'=>'form-control mb-2',
        'required',
        'label'=>__d('Ticketing', 'توضیحات'),
        'style'=>'min-height:200px;']);
    ?>
    <br><hr>
    <div class="row">
        <div class="col-sm-3">
            <?= $this->Form->control('ticketpriority_id', [
                'options' => $ticketpriorities, 
                'class'=>'form-control mb-2',
                'label'=> __d('Ticketing', 'اولویت') ]);?>
        </div>
        <div class="col-sm-3">
            <?= $this->Form->control('ticketcategory_id', [
                'options' => $ticketcategories,
                'class'=>'form-control mb-2',
                'label'=>__d('Ticketing', 'دسته بندی') ]);?>
        </div>
        <div class="col-sm-6 pt-1">
            <?php
            if(isset($setting_ticket['allow_uploadfile']) and $setting_ticket['allow_uploadfile']) :
                echo $this->Form->control('file', [
                    'type' => 'file',
                    'escape'=>false,
                    'label'=>__d('Ticketing', 'آپلود فایل ضمیمه'),
                    'dir'=>'ltr'
                    ]).'<small>پسوندهای مجاز zip|rar|pdf|jpg . حجم فایل حداکثر 20 مگابایت </small>';
            endif;?>
        </div>
    </div>
    <hr>
    <?= $this->Form->button(
        __d('Ticketing', 'ثبت اطلاعات'),
        ['class'=>'btn btn-primary btn-sm btn-section-block-custom', 'id'=>'btnSubmit']) ?>

    <?= $this->Form->end() ?>
</div>

<script nonce="<?=get_nonce?>">
$("#forms").submit(function() {
    $("#btnSubmit").attr('disabled','disabled');
    $(function () {
        'use strict';
        var section = $('#section-block'),
        sectionBlockCustom = $('.btn-section-block-custom'),
        cardSection = $('#card-block'),
        cardBlock = $('.btn-card-block'),
        cardBlockCustom = $('.btn-card-block-custom');
        if (sectionBlockCustom.length && section.length) {
            section.block({
                message:
                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0"><?= __d('Ticketing', 'در حال ارسال اطلاعات')?><br><?= __d('Ticketing', 'لطفا صبر کنید')?></p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div>',
                timeout: 300000,
                css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
                },
                overlayCSS: {
                opacity: 0.5
                }
            });
        }
    });
});
</script>
