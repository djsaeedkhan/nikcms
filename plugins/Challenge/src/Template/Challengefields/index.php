    <h3>
        <?= __('مدیریت حوزه ماموریت') ?>
        <?= $this->html->link('افزودن',['action'=>'Add'],['class'=>'btn btn-success'])?>
    </h3>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('عنوان') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challengefields as $challengefield): ?>
            <tr>
                <td><?= h($challengefield->title) ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'edit', $challengefield->id]) ?>
                        <?= $this->Form->postlink(__('حذف'), ['action' => 'delete', $challengefield->id], ['confirm' => __('Are you sure?', $challengefield->id)]) ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
