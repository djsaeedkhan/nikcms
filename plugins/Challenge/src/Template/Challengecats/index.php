    <h3>
        <?= 'مدیریت سطوح '.__d('Template', 'همیاری').'' ?>
        <?= $this->html->link('افزودن',['action'=>'Add'],['class'=>'btn btn-success'])?>
    </h3>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ردیف') ?></th>
                <th scope="col"><?= $this->Paginator->sort('عنوان') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challengecats as $challengecat): ?>
            <tr>
                <td width="10"><?= $this->Number->format($challengecat->id) ?></td>
                <td><?= h($challengecat->title) ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'edit', $challengecat->id]) ?>
                        <?= $this->Form->postlink(__('حذف'), ['action' => 'delete', $challengecat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengecat->id)]) ?>
                    </div>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>
<?= $this->element('Admin.paginate')?>