<h3><?= __d('Admin', 'مشاهده گزارش لاگ کاربران');?> </h3>
<div class="card cart1"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('info') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach ($result as $data): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?php //echo user_log_list($data['group_id'],$data['action_id']);?></td>
                <td></td>
                <td><?= $data['created'];?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>
