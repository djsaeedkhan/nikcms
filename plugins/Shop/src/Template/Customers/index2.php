<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $shopAddress
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postlink(
                __('Delete'),
                ['action' => 'delete', $shopAddress->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shopAddress->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Shop Addresses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shop Useraddresses'), ['controller' => 'ShopUseraddresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shop Useraddress'), ['controller' => 'ShopUseraddresses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shop Orders'), ['controller' => 'ShopOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shop Order'), ['controller' => 'ShopOrders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shopAddresses form large-9 medium-8 columns content">
    <?= $this->Form->create($shopAddress) ?>
    <fieldset>
        <legend><?= __('Edit Shop Address') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('emails');
            echo $this->Form->control('phone');
            echo $this->Form->control('nationalid');
            echo $this->Form->control('shop_useraddress_id', ['options' => $shopUseraddresses]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
