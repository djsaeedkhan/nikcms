<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Ticketing', 'مدیریت پاسخ تیکت ها') ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"> <?= __d('Ticketing', 'مشخصات تیکت')?> </th>
                    <th scope="col"> <?= __d('Ticketing', 'عنوان تیکت')?> </th>
                    <th scope="col"> <?= $this->Paginator->sort('created', __d('Ticketing', 'تاریخ ثبت')) ?></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($ticketcomments as $ticketcomment) : ?>
                <tr>
                    <td>
                        <?= $ticketcomment->has('ticket') ? __d('Ticketing', 'عنوان') .': '.
                            $this->Html->link(
                                $ticketcomment->ticket->subject,
                                '/admin/ticketing/tickets/comment/'. $ticketcomment->ticket->id) 
                            : '' ?>

                        <?= $ticketcomment->has('user') ? '<br>'.__d('Ticketing', 'کاربر') .': '.
                            $this->Html->link( $ticketcomment->user->username .
                            ($ticketcomment->user->family!=''?' ('.$ticketcomment->user->family.')':''), 
                            ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $ticketcomment->user->id ]) : '' ?>

                        <!-- <div class="hidme">
                            <?php $this->Html->link(__d('Ticketing', 'مشاهده'), 
                                ['action' => 'view', $ticketcomment->id]) ?>

                            <?php $this->Html->link(__d('Ticketing', 'ویرایش'), 
                                ['action' => 'edit', $ticketcomment->id]) ?>

                            <?php $this->Form->postlink(__d('Ticketing', 'حذف'), 
                                ['action' => 'delete', $ticketcomment->id], 
                                ['confirm' => __d('Ticketing', 'Are you sure you want to delete # {0}?', $ticketcomment->id)]) ?>
                        </div> -->
                    </td>

                    <td>
                        <?= ($ticketcomment->filesrc != ''?
                            $this->html->link(
                                '<i data-feather="link"></i>',
                                '/tickets/'.$ticketcomment->filesrc,
                                ['target'=>'_blank',
                                    'title'=>__d('Ticketing', 'فایل ضمیمه') .': '.$ticketcomment->filename,'escape'=>false,
                                    'style'=>'padding-right: 5px;padding-left: 5px;',
                                    'class'=>'badge badge-secondary text-white'])
                            :'') ?>

                        <?= nl2br($ticketcomment->content) ?>
                    </td>

                    <td><?= $this->Func->date2($ticketcomment->created) ?></td>                    
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
    </div>
</div>
<?= $this->element('Admin.paginate')?>