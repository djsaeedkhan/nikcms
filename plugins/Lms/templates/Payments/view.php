<?php use Lms\View\Helper\LmsHelper;?>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="row"><?= __('Lms Factor') ?></th>
            <td><?= $lmsPayment->has('lms_factor') ? $this->Html->link($lmsPayment->lms_factor->id, ['controller' => 'LmsFactors', 'action' => 'view', $lmsPayment->lms_factor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Token') ?></th>
            <td><?= h($lmsPayment->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $lmsPayment->has('user') ? $this->Html->link($lmsPayment->user->fname, 
                '/admin/users/view/'.$lmsPayment->user->id) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth') ?></th>
            <td><?= h($lmsPayment->auth) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('RefID') ?></th>
            <td><?= h($lmsPayment->RefID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('TraceID') ?></th>
            <td><?= h($lmsPayment->TraceID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Errcode') ?></th>
            <td><?= h($lmsPayment->Errcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Errtext') ?></th>
            <td><?= h($lmsPayment->Errtext) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($lmsPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($lmsPayment->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Terminal Ids') ?></th>
            <td><?= LmsHelper::Predata('terminal_list', $lmsPayment->terminal_ids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($lmsPayment->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= $this->Func->date2($lmsPayment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Enable') ?></th>
            <td><?= $lmsPayment->enable ? __('Yes') : __('No'); ?></td>
        </tr>
    </table></div>
</div></div>