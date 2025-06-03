<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $challengestatuses
 */
?>
<div class="challengestatuses index content">
    <?= $this->Html->link(__('New Challengestatus'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Challengestatuses') ?></h3>
    <div class="table-responsive">
        <table>
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
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
