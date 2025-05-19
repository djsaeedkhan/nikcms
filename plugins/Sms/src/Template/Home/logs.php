<h3><?= __d('Sms', 'گزارش پیام ها')?></h3>
<div class="card cart1"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mobile') ?></th>
                <th scope="col"><?= $this->Paginator->sort('message') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sender') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;foreach ($results as $result): ?>
            <tr>
                <td><?= ++$i;?></td>
                <td><?= h($result->mobile) ?></td>
                <td><?= nl2br($result->message) ?></td>
                <td><?= h($result->sender) ?></td>
                <td><?= $this->Func->date2($result->created);?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>