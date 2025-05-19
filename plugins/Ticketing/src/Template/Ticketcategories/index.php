<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Ticketing', 'مدیریت دسته بندی تیکت') ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link(
                            __d('Ticketing', 'افزودن'),
                            ['action'=>'add'],
                            ['class'=>'btn btn-sm btn-primary'])?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id',__d('Ticketing', 'ردیف') ) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('title',__d('Ticketing', 'عنوان')) ?></th>
                    <th scope="col" class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ticketcategories as $ticketcategory): ?>
                <tr>
                    <td><?= $this->Number->format($ticketcategory->id) ?></td>
                    <td><?= h($ticketcategory->title) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__d('Ticketing', 'ویرایش'), ['action' => 'add', $ticketcategory->id ]) ?>

                        <?= $this->Form->postlink( __d('Ticketing', 'Delete'), 
                            ['action' => 'delete', $ticketcategory->id], 
                            ['confirm' => __d('Ticketing', 'Are you sure you want to delete # {0}?', $ticketcategory->id )]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
    </div>
</div>

<?= $this->element('Admin.paginate')?>
