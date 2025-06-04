<div id="plugin_ticket_my_comment" style="direction:rtl;text-align:right;">
    <h4>
        <?php if(empty($ticket->completed )):
            echo '<div class="title">'.__d('Ticketing', 'مشاهده') .' '.__d('Template', 'تیکت').'</div>';

            echo $this->Form->postlink( __d('Ticketing', 'بستن'). ' ' . __d('Template', 'تیکت'),
            ['controller'=>'Ticketcomments','action'=>'close',$ticket->id ],
            ['class'=>'btn btn-sm btn-secondary',
            'confirm'=>__d('Ticketing', 'آیا برای این کار مطمئن هستید؟') ]);
        else:
            echo '<div class="alert alert-warning ">'.
            __d('Template', 'تیکت'). ' '.
            __d('Ticketing', 'بسته شده است') .'</div>';
        endif;?>
    </h4>

    <div class="card text-white bg-light-primary" style="margin-bottom:15px;">
        <div class="card-header">
            <?=__d('Template', 'عنوان تیکت')?>: <b><?= h($ticket->subject) ?></b></div>
        <div class="card-body">
            <?= $this->Text->autoParagraph(($ticket->content)); ?>
        </div>
    </div>

    <?php if (!empty($ticket->ticketcomments)): ?>
        <h4><?= __d('Ticketing', 'پاسخ ها')?></h4>
        <?php foreach ($ticket->ticketcomments as $ticketcomments):?>
            <div class="card border-success" style="margin-bottom:15px;">
                <div class="card-header">
                    <?= __d('Ticketing', 'کاربر')?>: 
                    <?= $ticketcomments->has('user') ? $this->Html->link($ticketcomments->user->username .
                        ($ticketcomments->user->family!= ''?' ('.$ticketcomments->user->family.') ':''), '#') : '' ?>
                    <span class="badge badge-info"><?= $this->Func->date2($ticketcomments->created);?> </span>

                </div>
                <div class="card-body">
                    <?= nl2br($ticketcomments->content) ?>

                    <?=$ticketcomments->filesrc != ''?
                    '<hr><div class="badge badge-danger"><small>'. __d('Ticketing', 'فایل ضمیمه') .': </small>'.$this->html->link(
                        $ticketcomments->filename,'/tickets/'.$ticketcomments->filesrc,['target'=>'_blank','class'=>'text-white']).'</div>':''?>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <?php if(empty($ticket->completed )):?>
    <div class="card">
        <div class="card-header"><?= __d('Ticketing', 'پاسخ به این')?> <?=__d('Template', 'تیکت')?></div>
        <div class="card-body">
        <?php
            echo $this->Form->create(null,['id'=>'formABC',
                'class'=>'col-sm-12',
                'type'=>'file',
                //'url'=>['controller'=>'Ticketcomments','action'=>'add']
                ]);

            echo $this->Form->control('content',[
                'type' => 'textarea',
                'label' => false,
                'style' =>'min-height:200px;',
                'placeholder' => __d('Ticketing', 'متن پاسخ'),
                'class' => 'form-control']);

            echo $this->Form->control('ticket_id', [
                'type' => 'hidden',
                'default'=>$ticket->id]).'<br>';

            if(isset($setting_ticket['allow_uploadfile']) and $setting_ticket['allow_uploadfile']):
                echo $this->Form->control('file', ['type' => 'file','escape'=>false,
                    'label'=>__d('Ticketing', 'آپلود فایل ضمیمه'),
                    'dir'=>'ltr']).
                    '<small>'.__d('Ticketing', 'پسوند های مجاز zip|rar|pdf|jpg . حجم فایل حداکثر 20 مگابایت').'</small>';
            endif;
            
            echo '<div class="clearfix"></div>';
            echo $this->Form->button(
                __d('Ticketing', 'ثبت پاسخ'),
                ['class'=>'btn btn-sm btn-primary mt-3', 'id'=>'btnSubmit' ]);

            echo $this->Form->end() ?>
        </div>
    </div>
    <?php endif;?>

</div>

<script nonce="<?=get_nonce?>">
    $(document).ready(function () {
        $("#formABC").submit(function (e) {
           // e.preventDefault();
            $("#btnSubmit").attr("disabled", true);
            return true;
        });
    });
</script>