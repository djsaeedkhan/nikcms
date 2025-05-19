<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?=  __d('Admin', 'مدیریت دیدگاه ها');?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id',' ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id', __d('Admin', 'کاربر')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('content', __d('Admin', 'محتوا')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_id', __d('Admin', 'مطلب مرتبط')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('created', __d('Admin', 'تاریخ ثبت')) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
            <tr <?= !$comment->approved?'class="table-warning"':'';?>>
                <td><?= $this->Number->format($comment->id) ?></td>
                <td>
                    <div><?= $comment->has('user') ? $this->Auths->link($comment->user->username, ['controller' => 'Users', 'action' => 'view', $comment->user->id]) : '' ?></div>
                    <div><?= h($comment->author) ?></div>
                    <div><?= h($comment->author_email) ?></div>
                </td>
                <td style="width:50%;">
                    <?= $comment->has('parent_comment') ? 
                        '<div>'. __d('Admin', 'در پاسخ به ').
                        $this->Auths->link(
                            isset($users[$comment['parent_comment']['user_id']])?
                                $users[$comment['parent_comment']['user_id']]:'-','').'</div><bR>' : '' ?>
                    <?= h($comment->content) ?>
                    <div class="hidme">
                        <?= $this->Auths->link( __d('Admin', 'پاسخ'), ['action' => 'reply', $comment->id]) ?>
                        <?= $this->Auths->link( __d('Admin', 'ویرایش'), ['action' => 'add', $comment->id]) ?>
                        <?= $this->Form->postlink( __d('Admin', 'حذف'), ['action' => 'delete', $comment->id], ['confirm' =>  __d('Admin', 'همه کامنت های فرزند حذف خواهند شد', $comment->id)]) ?>
                        <?= $this->Form->postlink(!$comment->approved?'<span class="badge badge-success">'.
                             __d('Admin', 'تایید شود').'</span>': __d('Admin', 'تایید نشود'), ['action' => 'approve', $comment->id,$comment->approved], ['escape'=>false]) ?>
                    </div>
                </td>
                <td><?= $comment->has('post') ? $this->Auths->link(
                    $comment->post->title, ['controller' => 'Posts', 'action' => 'edit', $comment->post->id],['target'=>'_blank']) : '' ?></td>
                <td><?= $this->Func->date2($comment->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>
<?= $this->element('Admin.paginate')?>