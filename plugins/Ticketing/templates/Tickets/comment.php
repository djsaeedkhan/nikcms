<div class="row">
    <div class="col-sm-8">
        <h4> <?= __d('Ticketing', 'عنوان تیکت')?>
            <?= $this->Form->postlink(
                __d('Ticketing', 'بستن تیکت'),
                ['controller'=>'Ticketcomments','action'=>'close',$ticket->id ],
                ['class'=>'btn btn-sm btn-warning','confirm'=>__d('Ticketing', 'آیا برای این کار مطمئن هستید؟') ]);?>
        
        </h4>
        <div class="card text-white bg-info text-right">
            <div class="card-header"> <?= h($ticket->subject) ?></div>
            <div class="card-body">
                <?= $this->Text->autoParagraph(($ticket->content)); ?>
               
            </div>
        </div>
        <?php if (!empty($ticket->ticketcomments)): ?>
            <h4><?= __d('Ticketing', 'پاسخ ها')?></h4>
            <?php foreach ($ticket->ticketcomments as $ticketcomments):?>
                <div class="card border-success">
                    <div class="card-header">
                        <?= $ticketcomments->has('user') ?
                            $this->Html->link(
                                __d('Ticketing', 'کاربر') . ': ' . $ticketcomments->user->username .
                                ($ticketcomments->user->family!= ''?' ('.$ticketcomments->user->family.') ':''), 
                                ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $ticketcomments->user->id ]) : '' ?>
                        <span class="badge badge-info"><?= $this->Func->date2($ticketcomments->modified);?> </span>
                    </div>
                    <div class="card-body">
                        <?= nl2br($ticketcomments->content) ?>

                        <?= $ticketcomments->filesrc != ''?'<hr><div><small>' . __d('Ticketing', 'فایل ضمیمه') .': </small>' . $this->html->link(
                            $ticketcomments->filename,'/tickets/'.$ticketcomments->filesrc,['target'=>'_blank','class'=>'text-white badge badge-danger']).'</div>':''?>

                        <!-- <div class="hidme">
                            <?= $this->Html->link(__d('Ticketing', 'مشاهده'), ['controller' => 'Ticketcomments', 'action' => 'view', $ticketcomments->id]) ?>
                            <?= $this->Html->link(__d('Ticketing', 'ویرایش'), ['controller' => 'Ticketcomments', 'action' => 'edit', $ticketcomments->id]) ?>
                            <?php // $this->Form->postlink(__d('Ticketing', 'جذف'), ['controller' => 'Ticketcomments', 'action' => 'delete', $ticketcomments->id], ['confirm' => ___d('Ticketing', 'Are you sure you want to delete?')]) ?>
                        </div> -->
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
    </div>

    <div class="col-sm-4"><br><br>
        <div class="table-responsive"><table class="table table-striped table-bordered bg-white">
            <tr>
                <th scope="row"><?= __d('Ticketing', 'وضعیت') ?></th>
                <td><?= $ticket->has('ticketstatus') ? $this->Html->link($ticket->ticketstatus->title, ['controller' => 'Ticketstatuses', 'action' => 'view', $ticket->ticketstatus->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __d('Ticketing', 'اولویت ') ?></th>
                <td><?= $ticket->has('ticketpriority') ? $this->Html->link($ticket->ticketpriority->title, ['controller' => 'Ticketpriorities', 'action' => 'view', $ticket->ticketpriority->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __d('Ticketing', 'کاربر') ?></th>
                <td><?= $ticket->has('user') ? $this->Html->link($ticket->user->username .($ticket->user->family!=''?' ('.$ticket->user->family.') ':''), ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $ticket->user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __d('Ticketing', 'اوپراتور') ?></th>
                <td><?= $ticket->has('agent') ?  $this->Html->link($ticket->agent->username .($ticket->agent->family!= ''?' ('.$ticket->agent->family.') ':''), ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $ticket->user->id]) : '' ?></td>
            </tr>
        </table></div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h2><?= __d('Ticketing', 'پاسخ به این تیکت')?> </h2></div>
    <div class="card-body">
    <?php
        echo $this->Form->create(null, [
            'type'=>'file',
            'class'=>'col-sm-12',
            'url'=>['controller'=>'Ticketcomments','action'=>'add'] ]);

        echo $this->Form->control('content', [
            'class'=>'form-control mb-1',
            'id'=>'pubEditor',
            'style'=>'height:300px !important;',
            'type'=>'textarea',
            'label'=>__d('Ticketing', 'متن پاسخ') ]).'<br>';

        echo $this->Form->control('ticket_id', [
            'type' => 'hidden',
            'default'=>$ticket->id]);

        if(isset($setting_ticket['allow_uploadfile']) and $setting_ticket['allow_uploadfile']):
            echo $this->Form->control('file', [
                'type' => 'file',
                'escape'=>false,
                'label'=>__d('Ticketing', 'آپلود فایل ضمیمه') .' <br><small>' . __d('Ticketing', 'فقط پسوند') .
                    ' zip|rar|pdf|jpg|doc|mp3|mp4 .' . __d('Ticketing', 'حداکثر حجم فایل') . ' 20MB </small>',
                'dir'=>'ltr']);
        endif;

        echo $this->Form->button(__d('Ticketing', 'ثبت پاسخ'), ['class'=>'btn btn-sm btn-primary mt-3']);
        echo '';
        echo $this->Form->end() ?>
    </div>
</div>