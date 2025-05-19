<?php
use Challenge\Predata;
$predata = new Predata();
?>
<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    کاربران <?=__d('Template', 'همیاری')?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <div class="btn-group pull-left" role="group">
                            <button class="btn btn-sm btn-secondary dropdown-toggle " id="btnGroupVerticalDrop1" type="button" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خروجی Excel </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" >
                                <?= $this->Form->postlink('لیست اطلاعات کاربران ',
                                    ['action'=>'index','?'=>['getlist'=>1]],['class'=>'dropdown-item'])?>
                            </div>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header-left col-md-4 col-12">
        <div class="pull-left">
            <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
            <div class="d-flex">
                <?= $this->Form->control('text', [
                    'label'=>false,
                    'type' => 'text', 
                    'class' => 'form-control form-control-sm',
                    'placeholder'=>'عنوان را وارد کنید',
                    'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                    ]);?>
                <?= $this->Form->button(__('جستجو'),['class'=>'btn btn-sm btn-success']);?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('username','نام کاربری') ?></th>
                <th scope="col"><?= $this->Paginator->sort('نام و نام خانوادگی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('شماره تماس') ?></th>
                <th scope="col"><?= $this->Paginator->sort('آدرس ایمیل') ?></th>
                <th scope="col"><?= $this->Paginator->sort('آخرین مقطع تحصیلی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('استان محل زندگی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user):
                $profile = isset($user->challengeuserprofile)?$user->challengeuserprofile:[] ?>
            <tr>
                <td>
                    <?= h($user->username); ?>
                    <?= ($user->enable ==0)?'<span class="badge badge-danger">غیرفعال</span>':'' ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'add', $user->id]) ?>
                        <!-- <?= $this->Form->postlink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> -->
                    </div>
                </td>
                <td><?= h($user->family) ?></td>
                <td><?= isset($profile->mobile)?$profile->mobile:''?></td>
                <td>
                    <?= (isset($profile->email) and $profile->email!= $user->email)?$profile->email.' <br> ':''?>
                    <?= h($user->email) ?>
                </td>
                <td><?= isset($profile->eductions)?$predata->getvalue('eductions',$profile->eductions):''?></td>
                <td><?= isset($profile->provice)?$this->Func->province_list($profile->provice):'' ?></td>
                <td><?= $this->Query->the_time($user) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
