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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $challengestatus->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $challengestatus->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Challengestatuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="challengestatuses form content">
            <?= $this->Form->create($challengestatus) ?>
            <fieldset>
                <legend><?= __('Edit Challengestatus') ?></legend>
                <?php
                    echo $this->Form->control('title');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
