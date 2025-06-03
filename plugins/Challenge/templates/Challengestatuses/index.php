<h3><?= __('مدیریت وضعیت ها') ?>
    <?= $this->html->link('افزودن',['action'=>'Add'],['class'=>'btn btn-success'])?>
</h3>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challengestatuses as $challengestatus): ?>
            <tr>
                <td><?= $this->Number->format($challengestatus->id) ?></td>
                <td><?= h($challengestatus->title) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $challengestatus->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $challengestatus->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $challengestatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengestatus->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>