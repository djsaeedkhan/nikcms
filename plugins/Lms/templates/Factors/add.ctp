<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $lmsFactor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Lms Factors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lms Userfactors'), ['controller' => 'LmsUserfactors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lms Userfactor'), ['controller' => 'LmsUserfactors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lms Payments'), ['controller' => 'LmsPayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lms Payment'), ['controller' => 'LmsPayments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lmsFactors form large-9 medium-8 columns content">
    <?= $this->Form->create($lmsFactor) ?>
    <fieldset>
        <legend><?= __('Add Lms Factor') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('user_ids');
            echo $this->Form->control('price');
            echo $this->Form->control('paid');
            echo $this->Form->control('status');
            echo $this->Form->control('descr');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
