<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $challengestatus
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Challengestatus'), ['action' => 'edit', $challengestatus->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Challengestatus'), ['action' => 'delete', $challengestatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengestatus->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Challengestatuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Challengestatus'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="challengestatuses view content">
            <h3><?= h($challengestatus->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($challengestatus->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($challengestatus->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Challenges') ?></h4>
                <?php if (!empty($challengestatus->challenges)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Img') ?></th>
                            <th><?= __('Img1') ?></th>
                            <th><?= __('Img2') ?></th>
                            <th><?= __('Challengestatus Id') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($challengestatus->challenges as $challenges) : ?>
                        <tr>
                            <td><?= h($challenges->id) ?></td>
                            <td><?= h($challenges->title) ?></td>
                            <td><?= h($challenges->slug) ?></td>
                            <td><?= h($challenges->descr) ?></td>
                            <td><?= h($challenges->img) ?></td>
                            <td><?= h($challenges->img1) ?></td>
                            <td><?= h($challenges->img2) ?></td>
                            <td><?= h($challenges->challengestatus_id) ?></td>
                            <td><?= h($challenges->start_date) ?></td>
                            <td><?= h($challenges->end_date) ?></td>
                            <td><?= h($challenges->user_id) ?></td>
                            <td><?= h($challenges->enable) ?></td>
                            <td><?= h($challenges->price) ?></td>
                            <td><?= h($challenges->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challenges', 'action' => 'view', $challenges->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challenges', 'action' => 'edit', $challenges->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challenges', 'action' => 'delete', $challenges->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challenges->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
