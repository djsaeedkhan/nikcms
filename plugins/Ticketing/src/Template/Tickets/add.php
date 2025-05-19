<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= $ticket->id?
                        __d('Ticketing', 'ویرایش تیکت') .' #' .$ticket->id:
                        __d('Ticketing', 'افزودن تیکت') ?>  
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
    </div>
</div>
<?= $this->Form->create($ticket,['type'=>'file']) ?>
<div class="row">

    <div class="col-sm-7">
        <div class="card"><div class="card-body">
            <?php
            echo $this->Form->control('subject', [
                'label'=> __d('Ticketing', 'عنوان تیکت'),
                'class'=>'form-control mb-2' ]);

            echo $this->Form->control('content', [
                'label'=>__d('Ticketing', 'متن تیکت'),
                'id'=>'pubEditor',
                'class'=>'form-control mb-2',
                'style'=>'height:290px;' ]);

            echo $this->Form->control('html', [
                'label'=>false,
                'class'=>'form-control mb-2  d-none' ]);
            ?>
        </div></div>
    </div>

    <div class="col-sm-5">
        <div class="card"><div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Form->control('ticketstatus_id', [
                        'label'=>__d('Ticketing', 'وضعیت تیکت'),
                        'options' => $ticketstatuses, 
                        'class'=>'form-control' ]);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('ticketpriority_id', [
                        'label'=>__d('Ticketing', 'اولویت تیکت'),
                        'options' => $ticketpriorities, 
                        'class'=>'form-control' ]);?>
                </div>
                <div class="col-sm-12"><hr></div>

                <div class="col-sm-6">
                    <?= $this->Form->control('ticketcategory_id', [
                        'label'=>__d('Ticketing', 'دسته بندی'),
                        'options' => $ticketcategories, 
                        'class'=>'form-control mb-2 select2' ]);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('agent_id', [
                        'label'=>__d('Ticketing', 'انتخاب اوپراتور'),
                        'options' => $agents, 
                        'class'=>'form-control mb-2 select2' ]);?>
                </div>
                
                <?php if(isset($setting_ticket['allow_uploadfile']) and $setting_ticket['allow_uploadfile']):
                    if(!$ticket->id):?>
                    <div class="col-sm-12 mt-2">
                        <div class="alert alert-secondary">
                            <?= $this->Form->control('file', [
                                'type' => 'file',
                                'escape'=>false,
                                'label'=>__d('Ticketing', 'آپلود فایل ضمیمه'),
                                'dir'=>'ltr']);?>
                            <small>
                                <?= __d('Ticketing', 'فقط پسوند')?> zip|rar|pdf|jpg|doc|mp3|mp4 
                                <br>
                                <?= __d('Ticketing', 'حداکثر حجم فایل') ?> 20 MB
                            </small>
                        </div>
                    </div>
                <?php endif;endif;?>

                <div class="col-sm-12"><hr></div>

                <div class="col-sm-6">
                    <?= $this->Form->control('phone_number', [
                        'label'=>__d('Ticketing', 'شماره موبایل') .' (' . __d('Ticketing', 'ارسال پیامک') . ')' ,
                        'placeholder'=>'09...',
                        'class'=>'form-control ltr' ]);?>
                </div>

                <div class="col-sm-6">
                    <?= $this->Form->control('email', [
                        'label'=> __d('Ticketing', 'آدرس ایمیل مقصد'),
                        'placeholder'=>'....@...',
                        'class'=>'form-control ltr' ]);?>
                </div>
                <!-- <div class="col-sm-12"><hr></div> -->
            </div>
        </div></div>

        <?php  if(!$ticket->id):?>
        <div class="card"><div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <?=$this->Form->control($ticket->id?'user_id':'user_id[]', [
                        'label'=>__d('Ticketing', 'کاربر مقصد'),
                        'multiple',
                        'required',
                        'options' => $users,
                        'class'=>'form-control mb-2 select2']);
                    ?>
                </div>
            </div>
        </div></div>
        <?php endif?>
        

        <?php
        //echo $this->Form->control('post_id', ['options' => $posts, 'empty' => true]);

        /* echo $this->Form->control('alert_type',
            ['class'=>'form-control mb-2']); */
                
        //echo $this->Form->control('completed', ['empty' => true]);
        ?>
    </div>
</div>
    

<?= $this->Form->button(__d('Ticketing', 'ثبت اطلاعات'), ['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>