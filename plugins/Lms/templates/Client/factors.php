<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت فاکتورها
                </h2>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id','شماره فاکتور') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price','مبلغ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('paid','پرداخت شده') ?></th>
                <th scope="col">توضیحات</th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            use Lms\View\Helper\LmsHelper;

            foreach ($factors as $lmsFactor): ?>
            <tr>
                <td>
                    <?= ($lmsFactor->id) ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش'), ['?'=>['id'=>$lmsFactor->id]]) ?>
                    </div>
                </td>
                <td>
                    <?= LmsHelper::PriceShow($lmsFactor->price) ?>
                    <?= ($lmsFactor->coupons) ?>
                </td>
                <td><?= $lmsFactor->paid==0?
                            '<span class="badge badge-danger">پرداخت نشده</span>':
                            '<span class="badge badge-success">پرداخت شده</span>'; ?></td>
                <td><?= $lmsFactor->descr ?></td>
                <td><?= $this->Func->date2($lmsFactor->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>
