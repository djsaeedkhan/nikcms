<?php
use Cake\Routing\Router;
use Lms\View\Helper\LmsHelper;?>
<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت پرداخت ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?php //$this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-sm btn-primary'])?>
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
                <th scope="col"><?= $this->Paginator->sort('lms_factor_id','ش فاکتور') ?></th>
                <th scope="col"><?= $this->Paginator->sort('token','پیگیری') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price','مبلغ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id','کاربر') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('terminal_ids','درگاه ') ?></th> -->
                <!-- <th scope="col"><?= $this->Paginator->sort('status','وضعیت') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('enable','پرداخت') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
                <th scope="col">توضیحات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsPayments as $lmsPayment): ?>
            <tr>
                
                <td style="width:30px;padding-right:0;padding-left:0;text-align: center;">
                    <?= $this->Form->checkbox('id.', 
                        array('value' => $lmsPayment->id, 'class'=>'checkboxAll','hiddenField' => false))?>
                </td>

                <td>
                    <?php 
                    if( $lmsPayment->has('lms_factor') ){
                        echo $this->Html->link('#'.$lmsPayment->lms_factor->id, 
                        ['controller' => 'Factors', 'action' => 'view', $lmsPayment->lms_factor->id]);?>
                        <div class="hidme">
                            <?= $this->Html->link(__('نمایش فاکتور'), ['controller' => 'Factors', 'action' => 'view', $lmsPayment->lms_factor->id]) ?>
                        </div>
                    <?php }?>
                </td>
                <td><?= h($lmsPayment->token) ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش پرداخت'), ['action' => 'view', $lmsPayment->id]) ?>
                        <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lmsPayment->id]) ?> -->
                        <?php $this->Form->postlink(__('حذف'), ['action' => 'delete', $lmsPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsPayment->id)]) ?>
                    </div>
                </td>
                <td>
                    <?= LmsHelper::PriceShow($lmsPayment->price) ?>
                    <?= isset($lmsPayment->lms_factor->coupons)?$lmsPayment->lms_factor->coupons:""?>
                </td>

                <td>
                    <?= $lmsPayment->has('user') ? $this->Html->link(
                        $lmsPayment->user->Fname, 
                        ['?'=>['user_id'=>$lmsPayment->user->id] ]) : '' ?>

                    <?= $lmsPayment->has('user') ? $this->Html->link(
                        '<i class="mr-50" data-feather="user"></i>', 
                        ['controller' => 'User', 'action' => 'index','?'=>['text'=>$lmsPayment->user->username] ],
                        ['escape'=>false]) : '' ?>
                </td>

                <!-- <td><?= $this->Number->format($lmsPayment->terminal_ids) ?></td> -->
                

                <!-- <td><?= $this->Number->format($lmsPayment->status) ?></td> -->
                <td><?= ($lmsPayment->enable==1?
                        '<span class="badge badge-success">موفق</span>':
                        '<span class="badge text-danger">ناموفق</span>') ?></td>
                        
                <td><?= $this->Func->date2($lmsPayment->created) ?></td>
                <td class="small">
                    <?= isset($lmsPayment['lms_factor']['descr'])?
                        '<span class="fw-n badge badge-light-secondary">'.$lmsPayment['lms_factor']['descr'].'</span><br>':''?>
                    <?= $lmsPayment->Errtext ?>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>
<?= $this->Form->end() ?>

<?= $this->element('Admin.paginate')?>