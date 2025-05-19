<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $lmsCertificate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Lms Certificate'), ['action' => 'edit', $lmsCertificate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Lms Certificate'), ['action' => 'delete', $lmsCertificate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCertificate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Lms Certificates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lms Certificate'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lms Courses'), ['controller' => 'LmsCourses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lms Course'), ['controller' => 'LmsCourses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="lmsCertificates view large-9 medium-8 columns content">
    <h3><?= h($lmsCertificate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $lmsCertificate->has('user') ? $this->Html->link($lmsCertificate->user->id, ['controller' => 'Users', 'action' => 'view', $lmsCertificate->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lms Course') ?></th>
            <td><?= $lmsCertificate->has('lms_course') ? $this->Html->link($lmsCertificate->lms_course->title, ['controller' => 'LmsCourses', 'action' => 'view', $lmsCertificate->lms_course->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($lmsCertificate->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Download') ?></th>
            <td><?= h($lmsCertificate->download) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($lmsCertificate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($lmsCertificate->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($lmsCertificate->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accepted') ?></th>
            <td><?= h($lmsCertificate->accepted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Enable') ?></th>
            <td><?= $lmsCertificate->enable ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Input Data') ?></h4>
        <?= $this->Text->autoParagraph(h($lmsCertificate->input_data)); ?>
    </div>
</div>
