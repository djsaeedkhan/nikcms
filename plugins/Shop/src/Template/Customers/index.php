<?php $pp = new Shop\ProvinceCity();?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __('مدیریت مشتریان');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none1 text-right">
        <?= $this->Form->create(null, ['type' => 'get','class'=>'','validate'=>false]); ?>
        <div class="row">
            <?= $this->Form->control('province', [
                'label'=> false,
                'type' => 'select', 
                'empty'=>'-- انتخاب استان --',
                'options'=> $this->Func->province_list(),
                'class' => 'form-control form-control-sm',
                'default'=>($this->request->getQuery('province')?$this->request->getQuery('province'):'') ]);?>
            <?= $this->Form->button(__('فیلتر'),['class'=>'btn btn-sm btn-success ml-1']);?>
        </div>
        <?= $this->Form->end(); ?>
    </div>

</div>

<div class="card cart1"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('#') ?></th>
                <th scope="col"><?= $this->Paginator->sort('نام و نام خانوادگی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('آدرس ایمیل') ?></th>
                <th scope="col"><?= $this->Paginator->sort('آدرس پستی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('تعداد سفارش ها') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;foreach ($results as $result): ?>
            <tr>
                <td><?= ++$i;?></td>
                <td><?= $result->has('user') ? $result->user->username .
                    ($result->user->family!= ''?' ('.$result->user->family.')':''): '' ?>
                    <div class="hidme">
                        <?= $this->html->link('نمایش',['action'=>'view',$result->id])?>
                    </div>
                </td>
                <td><?= $result->has('user') ? $result->user->email :'' ?></td>
                <td>
                    <?= $this->Func->province_list($result->billing_state)?>  
                    <?=$pp->getlist($result->billing_state,$result->billing_city);?>
                </td>
                <td>
                <span class="badge badge-pill badge-primary">
                    <?= isset($result->user->shop_orders)?count($result->user->shop_orders):0 ?>
                </span</td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>