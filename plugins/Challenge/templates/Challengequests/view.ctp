    <h3><?= h($challengequest->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Challenge') ?></th>
            <td><?= $challengequest->has('challenge') ? $this->Html->link($challengequest->challenge->title, ['controller' => 'Challenges', 'action' => 'view', $challengequest->challenge->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Challengequest') ?></th>
            <td><?= $challengequest->has('parent_challengequest') ? $this->Html->link($challengequest->parent_challengequest->title, ['controller' => 'Challengequests', 'action' => 'view', $challengequest->parent_challengequest->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($challengequest->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Types') ?></th>
            <td><?= $this->Number->format($challengequest->types) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($challengequest->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($challengequest->rght) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= $this->Func->date2($challengequest->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Title') ?></h4>
        <?= $this->Text->autoParagraph(h($challengequest->title)); ?>
    </div>
    <div class="row">
        <h4><?= __('Slug') ?></h4>
        <?= $this->Text->autoParagraph(h($challengequest->slug)); ?>
    </div>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($challengequest->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Challengequests') ?></h4>
        <?php if (!empty($challengequest->child_challengequests)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Challenge Id') ?></th>
                <th scope="col"><?= __('Types') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Slug') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($challengequest->child_challengequests as $childChallengequests): ?>
            <tr>
                <td><?= h($childChallengequests->id) ?></td>
                <td><?= h($childChallengequests->challenge_id) ?></td>
                <td><?= h($childChallengequests->types) ?></td>
                <td><?= h($childChallengequests->title) ?></td>
                <td><?= h($childChallengequests->slug) ?></td>
                <td><?= h($childChallengequests->description) ?></td>
                <td><?= h($childChallengequests->parent_id) ?></td>
                <td><?= h($childChallengequests->lft) ?></td>
                <td><?= h($childChallengequests->rght) ?></td>
                <td><?= $this->Func->date2($childChallengequests->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Challengequests', 'action' => 'view', $childChallengequests->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Challengequests', 'action' => 'edit', $childChallengequests->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Challengequests', 'action' => 'delete', $childChallengequests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childChallengequests->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>