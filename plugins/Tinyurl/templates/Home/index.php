<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Tinyurl','کوتاه کننده لینک');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?=$this->Auths->link(
                            __d('Tinyurl','جدید'),
                            ['action'=>'add'],
                            ['class'=>'btn btn-primary btn-sm']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id',__d('Tinyurl','ردیف')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('title',__d('Tinyurl','عنوان')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug',__d('Tinyurl','نامک')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('link',__d('Tinyurl','لینک')) ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('expire') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('views',__d('Tinyurl','نمایش')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('created',__d('Tinyurl','تاریخ ثبت')) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;foreach ($results as $result): ?>
            <tr>
                <td><?= ++$i;?></td>
                <td><?= h($result->title) ?>
                    <div class="row-actions"><span class="hidme">
                        <?= $this->Auths->link(
                            __d('Tinyurl','ویرایش'),
                            ['action'=>'add',$result->id]);?>

                        <?= $this->Form->postlink(
                            __d('Tinyurl','حذف'),
                            ['action'=>'delete',$result->id],
                            ['confirm'=> __d('Tinyurl','برای حذف مطمئن هستید؟') ]);?>
                    </span></div>
                </td>
                <td><?= h($result->slug) ?></td>
                <td><?= h($result->link) ?>
                    <div class="row-actions"><span class="hidme">

                        <?= $this->Html->link(
                            __d('Tinyurl','نمایش با آیدی'),
                            '/url/'.$result->id);?>

                        <?= $this->Html->link(
                            __d('Tinyurl','نمایش با نامک'),
                            '/url/'.$result->slug);?>
                            
                    </span></div>
                </td>
                <!-- <td><?= h($result->expire) ?></td> -->
                <td><?= $result->views;?> <?= __d('Tinyurl','بازدید')?></td>
                <td><?= $this->Func->date2($result->created);?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>