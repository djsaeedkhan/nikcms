<h3><?= __d('Admin', 'Manage User');?>: <?= h($user->username) ?></h3>
<div class="box box-primary"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th><?= __d('Admin', 'Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __d('Admin', 'Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th><?= __d('Admin', 'Family') ?></th>
            <td><?= h($user->family) ?></td>
        </tr>
        <tr>
            <th><?= __d('Admin', 'Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __d('Admin', 'Phone') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th><?= __d('Admin', 'Role') ?></th>
            <td><?= ($user->role_id) ?></td>
        </tr>
        <tr>
            <th><?= __d('Admin', 'Created') ?></th>
            <td><?= $this->Func->date2($user->created) ?></td>
        </tr>
    </table></div>
</div></div>