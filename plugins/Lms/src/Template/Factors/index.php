<?php

use Cake\Routing\Router;
use Lms\View\Helper\LmsHelper;?>
<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت فاکتورها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-sm btn-primary'])?>
                        <?= $this->html->link('خروجی اکسل',['?'=>['tocsv'=>true] ],['class'=>'btn btn-sm btn-primary mx-1'])?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-4 col-12 d-md-block">
        <div class="pull-left">
            <?= $this->Form->create(null, ['type' => 'get','validate'=>false,'class'=>'col-sm-12']); ?>
            <div class="row">
                <div class="pull-left">
                    <?= $this->Form->control('text', [
                    'label'=>false,
                    'type' => 'text', 
                    'class' => 'form-control form-control-sm',
                    'placeholder'=>'عنوان را وارد کنید',
                    'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                    ]);?>
                </div>
                <div class="pull-left">
                    <?= $this->Form->button(__('جستجو'),['class'=>'btn btn-sm btn-success']);?>
                    <?=$this->request->getQuery('text')?'<a href="?"class="small">حذف فیلتر</a>':''?>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>


<?= $this->Form->create(null,['id'=>'formId','class'=>'col-sm-12 p-0','type'=>'get'])?>
<div class="d-flex mb-1">
<?php
echo $this->form->control('action',[
    'label'=>'کارهای دسته جمعی : ', 'id'=>'dd_select',
    'empty'=>'-- انتخاب کنید --',
    'options'=>[
        'delete'=>'حذف دسته جمعی',
    ],'class'=>'form-control form-control-sm d-inline col-sm-6'
    ]);
    echo $this->Form->button(__('اجرا'),[
        'class'=>' btn btn-sm btn-success d-flex','confirm'=>'برای انجام عملیات مطمین هستید؟']) ?>
    <script nonce="<?=get_nonce?>">
    $(function(){
        $('#dd_select').on('change', function () {
            if ($(this).val() == 'delete') {
                $('#formId').attr('action', '<?=Router::url(['action'=>'delete'])?>');
            }
        });
    });
    $(document).ready(function(){
        $(".select-me").click(function(){
            $(this).parent().parent().parent().parent().find('.checkboxAll').each(function(){
                $(this).prop('checked', true);
            })
        });
    });
    </script>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><a class="select-me" title="انتخاب همه سطرها">همه</a></th>
                <th scope="col"><?= $this->Paginator->sort('id','شماره فاکتور') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id','کاربر') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('user_ids') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('price','مبلغ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('paid','پرداخت شده') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descr','توضیحات') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($lmsFactors as $lmsFactor): ?>
            <tr>
                <td style="width:30px;padding-right:0;padding-left:0;text-align: center;">
                    <?= $this->Form->checkbox('id.', 
                        array('value' => $lmsFactor->id, 'class'=>'checkboxAll','hiddenField' => false))?>
                </td>
                <td>
                    <?= ($lmsFactor->id) ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش'), ['action' => 'view', $lmsFactor->id]) ?>
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'add', $lmsFactor->id]) ?>
                        <?php /* $this->Form->postlink(__('حذف'), ['action' => 'delete', $lmsFactor->id], 
                            ['confirm' => __('آیا موافق هستید فاکتور و پرداخت های این فاکتور حذف شوند ', $lmsFactor->id)]) */ ?>
                    </div>
                </td>
                <td>
                    <?= $lmsFactor->has('user') ? $this->Html->link(
                        $lmsFactor->user->Fname, 
                        ['?'=>['user_id'=>$lmsFactor->user->id] ]) : '' ?>

                    <?= $lmsFactor->has('user') ? $this->Html->link(
                        '<i class="mr-50" data-feather="user"></i>', 
                        ['controller' => 'User', 'action' => 'index','?'=>['text'=>$lmsFactor->user->username] ],
                        ['escape'=>false]) : '' ?>
                </td>

                <!-- <td><?= $this->Number->format($lmsFactor->user_ids) ?></td> -->
                <td>
                    <?= LmsHelper::PriceShow($lmsFactor->price) ?>
                    <?= ($lmsFactor->coupons) ?>
                </td>
                <td><?= $lmsFactor->paid==1?'<span class="badge badge-success">موفق</span>':
                        '<span class="badge text-danger">ناموفق</span>' ?></td>
                <td class="small"><?= ($lmsFactor->descr) ?></td>
                <td><?= $this->Func->date2($lmsFactor->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->Form->end() ?>

<?= $this->element('Admin.paginate')?>