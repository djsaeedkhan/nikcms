<h3><?= __('مدیریت موضوع ها') ?>
    <?= $this->html->link('افزودن',['action'=>'Add'],['class'=>'btn btn-success'])?>
</h3>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"><?= $this->Paginator->sort('عنوان') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challengetopics as $challengetopic): ?>
            <tr>
                <td width="10"><?= $this->Number->format($challengetopic->id) ?></td>
                <td>
                    <?= h($challengetopic->title) ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'edit', $challengetopic->id]) ?>
                        <?= $this->Form->postlink(__('حذف'), ['action' => 'delete', $challengetopic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengetopic->id)]) ?>
                    </div>
                </td>
               
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>