<?php use Cake\Routing\Router;
use Lms\View\Helper\LmsHelper;
?>
<?= $this->element('Lms.lms_modal');?>

<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت دوره ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-sm btn-primary'])?>
                        <?= $this->html->link('مدیریت دسته بندی',
                            ['controller'=>'coursecategories','action'=>'index'],
                            ['class'=>'btn btn-sm btn-secondary mx-1'])?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <!-- <th scope="col"><?= $this->Paginator->sort('id','ردیف') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('تصویر') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title','عنوان دوره') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('show_in_list','نمایش در لیست دوره ها') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('chart','آمار کلی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time','تاریخ') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsCourses as $lmsCourse): ?>
            <tr>
                <!-- <td><?= $this->Number->format($lmsCourse->id) ?></td> -->
                <td width="100">
                    <?= $lmsCourse->image!=''?$this->html->image($lmsCourse->image,['style'=>'max-width:150px;max-height:150px;']):'بدون تصویر'?>
                </td>
                <td>
                    <?= h($lmsCourse->title) ?>
                    <?= $lmsCourse->enable?
                        '<span class="badge badge-success">فعال</span>':
                        '<span class="badge badge-danger">غیرفعال</span>' ?>

                    <?= $lmsCourse->price !== null?
                        '<div>مبلغ دوره: '.LmsHelper::PriceShow($lmsCourse->price).$lmsCourse->sprice .'</div>':''?>

                    <?= $lmsCourse->show_in_list == 1?
                        '<div><strong>[وبسایت]</strong></div>':''?>

                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش جزئیات'), ['action' => 'view', $lmsCourse->id]) ?>
                        <?= $this->Html->link('ویرایش','/admin/lms/courses/add/'.$lmsCourse->id,
                            ['data-toggle'=>'modal','data-target'=>'#exampleModalll',
                            'data-whatever'=>Router::url('/admin/lms/courses/add/'.$lmsCourse->id.'?nonav=1')]);?>
                    </div>
                </td>
                <td>
                    <div>تعداد هفته: <?= count($lmsCourse->lms_courseweeks); ?></div>
                    <div>کاربر دوره: <?= count($lmsCourse->lms_courseusers) ?> نفر </div>
                </td>
                <td>
                    <div>شروع: <?= $lmsCourse->date_start!= null ?
                        $this->Func->date2($lmsCourse->date_start):'-' ?></div>
                    <div>پایان: <?= $lmsCourse->date_end!= null ?
                        $this->Func->date2($lmsCourse->date_end):'-' ?></div>
                </td>
                <!-- <td><?php // $this->Func->date2($lmsCourse->created,'Y-m-d') ?></td> -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>