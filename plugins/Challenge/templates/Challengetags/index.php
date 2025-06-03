<h3><?= __('مدیریت برچسب ها') ?>
    <?= $this->html->link('افزودن',['action'=>'Add'],['class'=>'btn btn-success'])?>
</h3>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challengetags as $challengetag): ?>
            <tr>
                <td><?= $this->Number->format($challengetag->id) ?></td>
                <td><?= h($challengetag->title) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('ویرایش'), ['action' => 'edit', $challengetag->id]) ?>
                    <?= $this->Form->postlink(__('حذف'), ['action' => 'delete', $challengetag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengetag->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>