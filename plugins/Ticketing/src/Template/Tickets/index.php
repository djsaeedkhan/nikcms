<?php use Cake\Routing\Router;?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Ticketing', 'مدیریت تیکت') ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?=$this->html->link(__d('Ticketing', 'تیکت جدید'),
                            ['action'=>'add'],
                            ['class'=>'btn btn-sm btn-primary'])?>

                        <div class="btn-group pull-right" style="margin-right:5px;" role="group">
                            <button class="btn btn-success dropdown-toggle " style="padding: 6px !important;" id="btnGroupVerticalDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather='more-vertical'></i> دسترسی</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2" >
                                <?= $this->Html->link(__d('Ticketing', 'لیست وضعیت تیکت'),
                                    ['controller' => 'Ticketstatuses', 'action' => 'index'],
                                    ['class'=>'dropdown-item']) ?>
                                <?= $this->Html->link(__d('Ticketing', 'لیست اولویت تیکت'), 
                                    ['controller' => 'Ticketpriorities', 'action' => 'index'],
                                    ['class'=>'dropdown-item']) ?>
                                <?= $this->Html->link(__d('Ticketing', 'لیست دسته بندی تیکت'), 
                                    ['controller' => 'Ticketcategories', 'action' => 'index'],
                                    ['class'=>'dropdown-item']) ?>
                                <!-- <?= $this->Html->link(__d('Ticketing', 'List Ticketaudits'), 
                                    ['controller' => 'Ticketaudits', 'action' => 'index'],
                                    ['class'=>'dropdown-item']) ?> -->
                            </div>
                        </div>
                        <?= $this->html->link(
                            __d('Ticketing', 'خروجی اکسل'), 
                            ['?'=>['tocsv'=>true] ],
                            ['class'=>'btn btn-sm btn-secondary mx-1'])?>

                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block">
        <div class="pull-left">
            <?= $this->Form->create(null, ['type' => 'get','validate'=>false,'class'=>'col-sm-12']); ?>
            <div class="row">
                <div class="pull-left">
                    <?= $this->Form->control('text', [
                        'label' => false,
                        'type' => 'text', 
                        'class' => 'form-control form-control-sm',
                        'placeholder' => __d('Ticketing', 'عنوان را وارد کنید'),
                        'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                        ]);?>
                </div>
                <div class="pull-left">
                    <?= $this->Form->button(__d('Ticketing', 'جستجو'), ['class'=>'btn btn-sm btn-success']);?>
                    <?= $this->request->getQuery('text')?'<a href="?"class="small">'. __d('Ticketing', 'حذف فیلتر') .'</a>':''?>
                </div>

            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>


<?= $this->Form->create(null,['id'=>'formId','class'=>'col-sm-12 p-0','type'=>'get'])?>
<div class="d-flex mb-1">
<?php
echo $this->form->control('action',[
    'label'=>__d('Ticketing', 'کارهای دسته جمعی') .' : ',
    'id'=>'dd_select',
    'empty'=>'-- '.__d('Ticketing', 'انتخاب کنید') .' --',
    'options'=>[
        'delete'=>__d('Ticketing', 'حذف موارد انتخاب شده'),
    ],'class'=>'form-control form-control-sm d-inline col-sm-6'
    ]);
    echo $this->Form->button(__d('Ticketing', 'اجرا'),[
        'class'=>' btn btn-sm btn-success d-flex',
        'confirm'=>__d('Ticketing', 'برای انجام عملیات مطمین هستید؟') ]) ?>
    <script nonce="<?=get_nonce?>">
    $(function(){
        $('#dd_select').on('change', function () {
            if ($(this).val() == 'delete') {
                $('#formId').attr('action', '<?=Router::url(['action'=>'delete'])?>');
            }
        });
    });
    $(document).ready(function(){
        $(".select-me").click(function(){
            $(this).parent().parent().parent().parent().find('.checkboxAll').each(function(){
                $(this).prop('checked', true);
            })
        });
    });
    </script>
</div>

<div class="card cart1">
    <div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"><a class="select-me" title="<?= __d('Ticketing', 'انتخاب همه سطرها')?>">
                        <?= __d('Ticketing', 'همه')?>
                    </a></th>
                    <th scope="col"><?= $this->Paginator->sort('id', __d('Ticketing', 'شماره تیکت')) ?></th>
                    <th scope="col" width="300"><?= $this->Paginator->sort('subject', __d('Ticketing', 'عنوان') ) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('ticketstatus_id', __d('Ticketing', 'وضعیت') ) ?></th>
                    <!-- <th scope="col"><?= $this->Paginator->sort('ticketpriority_id', __d('Ticketing', 'اولویت')) ?></th> -->
                    <th scope="col"><?= $this->Paginator->sort('user_id', __d('Ticketing', 'کاربر') ) ?></th>
                    <!-- <th scope="col"><?= $this->Paginator->sort('agentid', __d('Ticketing', 'اوپراتور') ) ?></th> -->
                    <th scope="col"><?= $this->Paginator->sort('ticketcategory_id', __d('Ticketing', 'دسته بندی')) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created', __d('Ticketing', 'تاریخ ثبت')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td style="width:30px;padding-right:0;padding-left:0;text-align: center;">
                        <?= $this->Form->checkbox('id.', 
                            array('value' => $ticket->id, 'class'=>'checkboxAll','hiddenField' => false))?>
                    </td>
                    <td><?= $this->Number->format($ticket->id) ?>
                        <?= $ticket->completed?
                            '<span class="badge badge-success" title="'.__d('Ticketing', 'تکمیل شده') .'">*</span>':
                            '<span class="badge badge-danger" title="'.__d('Ticketing', 'تکمیل نشده') .'">*</span>' ?>
                    </td>
                    <td><?= h($ticket->subject) ?>
                        <?php 
                        if ($ticket->has('ticketcomments') and count($ticket['ticketcomments']) > 0) {
                            echo '<div class="alert alert-secondary">'. __d('Ticketing', 'آخرین پیام') .': '.nl2br($ticket['ticketcomments'][0]['content']).'</div>';
                        }?>

                        <div class="hidme">
                            <?= $this->Html->link(__d('Ticketing', 'ویرایش'), ['action' => 'add', $ticket->id]) ?>
                            <!-- <?= $this->Form->postlink(__d('Ticketing', 'حذف'), 
                                ['action' => 'delete', $ticket->id],
                                ['confirm'=>__d('Ticketing', 'برای حذف مطمین هستید؟ فایل های ضمیمه هم حذف خواهند شد') ]) ?> -->
                            <?= $this->Html->link(__d('Ticketing', 'پاسخ ها '.
                                (($ticket->has('ticketcomments') and count($ticket['ticketcomments']) > 0)?
                                    '('.count($ticket['ticketcomments']).')':'')
                                ), ['action' => 'comment', $ticket->id]) ?>
                        </div>
                    </td>
                    <td>
                        <?php
                        if ($ticket->has('ticketcomments') and count($ticket['ticketcomments']) > 0) {
                            if ($ticket['ticketcomments'][0]['user_id'] == $ticket['user_id']) :
                                echo '<span class="badge badge-secondary">'.__d('Ticketing', 'در انتظار پاسخ') .'</span>';
                            else:
                                echo '<span class="badge badge-primary">'.__d('Ticketing', 'پاسخ داده شده') .'</span>';
                            endif;
                        } else {
                            echo $ticket->has('ticketstatus') ? $ticket->ticketstatus->title: '';
                        }?>
                        <?= $ticket->has('ticketpriority') ? '<br>'.__d('Ticketing', 'اولویت') .': '.$ticket->ticketpriority->title : '' ?>
                    </td>
                    <td><!-- <?= $ticket->has('user') ? $this->Html->link(
                        ($ticket->user->family!=''?$ticket->user->family.' (':'') . ($ticket->user->username) .($ticket->user->family!=''?')':''), 
                        ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $ticket->user->id]) : '' ?> -->
                        
                        <?= $ticket->has('user') ? $this->Html->link(
                            $ticket->user->Fname, 
                            ['?'=>['user_id'=>$ticket->user->id] ]) : '' ?>

                        <?= $ticket->has('user') ? $this->Html->link(
                            '<i class="mr-50" data-feather="user"></i>', 
                            ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $ticket->user->id],
                            ['escape'=>false]) : '' ?>
                        
                    </td>
                    
                    <!-- <td><?= $ticket->has('agent') ? $this->Html->link(
                        ($ticket->agent->family!=''?$ticket->agent->family.' (':'') . ($ticket->agent->username) .($ticket->agent->family!=''?')':''), 
                        ['controller' => 'Users', 'action' => 'view', $ticket->agent->id]) : '' ;?></td> -->

                    <td><?= $ticket->has('ticketcategory') ? $ticket->ticketcategory->title : '' ?></td>
                    <td><?= $this->Func->date2($ticket->created) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
    </div>
</div>
<?= $this->Form->end() ?>

<?= $this->element('Admin.paginate')?>
