<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $lmsPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Lms Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lms Factors'), ['controller' => 'LmsFactors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lms Factor'), ['controller' => 'LmsFactors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lmsPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($lmsPayment) ?>
    <fieldset>
        <legend><?= __('Add Lms Payment') ?></legend>
        <?php
            echo $this->Form->control('lms_factor_id', ['options' => $lmsFactors, 'empty' => true]);
            echo $this->Form->control('token');
            echo $this->Form->control('price');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('terminal_ids');
            echo $this->Form->control('auth');
            echo $this->Form->control('RefID');
            echo $this->Form->control('TraceID');
            echo $this->Form->control('Errcode');
            echo $this->Form->control('Errtext');
            echo $this->Form->control('status');
            echo $this->Form->control('enable');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
