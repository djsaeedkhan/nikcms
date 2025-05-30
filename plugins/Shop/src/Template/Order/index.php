<?php use Cake\Routing\Router;
use Shop\View\Helper\ShopHelper;
use Shop\View\Helper\CartHelper;
$pp = new Shop\ProvinceCity();?>
<?= $this->element('Shop.shop_modal');?>

<div class="content-header row">
    <div class="content-header-right col-md-5 col-12 mt-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت سفارشات
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">

                        <?= $this->Form->control('action', [
                            'label'=> false,
                            'empty'=>'-- انجام عملیات --',
                            'type' => 'select', 
                            'id'=>'action1',
                            'options'=> CartHelper::Predata('order_actions'),
                            'class' => 'form-control form-control-sm float-right mr-1 pr-1',
                            'style'=>'width: inherit;',
                            //'default'=>($this->request->getQuery('action')?$this->request->getQuery('action'):'')
                            ]);?>

                        <?= $this->Form->control('برو', [
                            'type' => 'button','id'=>'action2','label'=>false,
                            'confirm'=>'برای انجام این عملیات موافق هستید؟',
                            'class' => 'btn btn-sm btn-primary' ]);?>
                <script nonce="<?=get_nonce?>">
                    $('#action1').on('change', function() {
                        $('.custom-checkbox').removeClass('d-none');
                        $('#actions').val( this.value );});
                    $('#action2').on('click', function() {
                        $('form#myForm').submit();
                        });
                </script>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header-right text-md-right col-md-12 col-12 d-md-block d-none1 text-right">
        <?= $this->Form->create(null, ['type' => 'get','class'=>'','validate'=>false]); ?>
        <div class="row alert alert-info">
            <div class="col-sm-2">
                <?= $this->Form->control('trackcode', [
                    'label'=>'کدسفارش/مرسوله/پستی',
                    'class' => 'form-control form-control-sm ltr',
                    'default'=>$this->request->getQuery('trackcode') ]);?>
            </div>
            <div class="col-sm-2">
                <?= $this->Form->control('status', [
                    'label'=>'وضعیت سفارش',
                    'type' => 'select', 
                    'empty'=>'--  --',
                    'options'=> CartHelper::Predata('order_status'),
                    'class' => 'form-control form-control-sm',
                    'default'=>($this->request->getQuery('status')?$this->request->getQuery('status'):'') ]);?>
            </div>
            <div class="col-sm-2">
            <?= $this->Form->control('province', [
                'label'=>'انتخاب استان',
                'type' => 'select', 
                'empty'=>'--  --',
                'options'=> $this->Func->province_list(),
                'class' => 'form-control form-control-sm',
                'default'=>($this->request->getQuery('province')?$this->request->getQuery('province'):'') ]);?>
            </div>
            <div class="col-sm-2">
                <?= $this->Form->control('date', [
                    'label'=>'تاریخ سفارش','placeholder'=> jdate('Y/m/d'),
                    'class' => 'form-control form-control-sm ltr',
                    'default'=>($this->request->getQuery('date')?$this->request->getQuery('date'):'') ]);?>
            </div>

           

            <?= $this->Form->button(__('فیلتر'),['class'=>'btn btn-sm btn-success','style'=>'height: 30px;margin-top: 25px;']);?>

        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>
<br>


<?= $this->Form->create(null, ['url'=>['action'=>'status'],'type' => 'get','validate'=>false,'id'=>'myForm','target'=> "_blank"]); ?>
    <?= $this->Form->control('action', [
        'label'=> false,
        'id'=>'actions',
        'empty'=>'-- انجام عملیات --',
        'type' => 'select', 
        'options'=> CartHelper::Predata('order_actions'),
        'class' => 'form-control form-control-sm float-right mr-1 d-none',
        'style'=>'width: inherit;',
        'default'=>($this->request->getQuery('action')?$this->request->getQuery('action'):'') ]);?>

    <div class="card cart1"><div class="card-body1">
        <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
            <thead>
                <tr>
                    <th scope="col" class="px-0 pt-2"></th>
                    <th scope="col" class="pt-2"><?= $this->Paginator->sort('کدسفارش') ?> / <?= $this->Paginator->sort('کدپیگیری') ?></th>
                    <th scope="col" class="pt-2"><?= $this->Paginator->sort('وضعیت') ?></th>
                    <th scope="col" class="pt-2"><?= $this->Paginator->sort('تعداد محصول') ?></th>
                    <th scope="col" class="pt-1"><?= $this->Paginator->sort('مبلغ سفارش') ?><br><div class="small">بدون هزینه ارسال</div></th>
                    <th scope="col" class="pt-2"><?= $this->Paginator->sort('مقصد مرسوله') ?></th>
                    <!-- <th scope="col" class="pt-2"><?= $this->Paginator->sort('شیوه ارسال') ?></th> -->
                    <th scope="col" class="pt-2"><?= $this->Paginator->sort('تاریخ ثبت') ?></th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                $province_list = $this->Func->province_list();
                $shipping_list = CartHelper::ShippingList('list');
                $i=0;foreach ($results as $result): ?>
                <tr>
                    <td class="p-0 pl-1">
                        
                        <div class="custom-control custom-control-secondary custom-checkbox float-right d-none">
                            <input type="checkbox" name="<?= $result->trackcode;?>" class="custom-control-input" id="customCheck<?= $result->id;?>" />
                            <label class="custom-control-label" for="customCheck<?= $result->id;?>"></label>
                        </div>

                        <div class="dropdown chart-dropdown float-right">
                            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i> 
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- <?= $this->html->link('<i data-feather="refresh-cw"></i> تغییر وضعیت',
                                    ['action'=>'status',$result['id']],
                                    ['data-toggle'=>'modal','data-target'=>'#exampleModalll','escape'=>false ,'class'=>'dropdown-item',
                                    'data-whatever'=>Router::url('/admin/shop/order/status/'.$result->id.'?nonav=1') ]);?> -->

                                <?= $this->html->link('<i data-feather="edit"></i> ویرایش سفارش ',
                                    ['action'=>'status',$result['id']],
                                    ['class'=>'dropdown-item','escape'=>false ]);?>
                                    
                                <?= $this->html->link('<i data-feather="printer"></i> پرینت فاکتور',
                                    ['controller'=>'Manage','action'=>'payment',$result['trackcode'],'pdf'],
                                    ['class'=>'dropdown-item','target'=>'_blank','escape'=>false ]);?>

                                <?= $this->html->link('<i data-feather="printer"></i> پرینت مرسوله',
                                    ['action'=>'status','?'=>['action'=>'post_print',$result['trackcode']=>'on']],
                                    ['class'=>'dropdown-item','escape'=>false,'target'=>'_blank', ]);?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?= h($result->id) ?> <br>
                        <?= h($result->trackcode) ?>
                        <div class="hidme">
                            <?= $this->html->link('جزئیات',['action'=>'view',$result->id])?>
                            
                            <?= $this->html->link(__('سریع'),'/admin/shop/order/view/'.$result->id,
                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll',
                                'data-whatever'=>Router::url('/admin/shop/order/view/'.$result->id.'?nonav=1') ]);?>

                            <?= $this->html->link(__('وضعیت'),'/admin/shop/order/status/'.$result->id,
                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll',
                                'data-whatever'=>Router::url('/admin/shop/order/status/'.$result->id.'?nonav=1') ]);?>
                        </div>
                    </td>

                    <td>
                        <?php if($result['token'] == 1):?>
                            <span title="صحت سنجی پیامکی انجام شده است">
                                <i data-feather="check" class="bg-success" 
                            style="border: 1px solid #28C76F;border-radius: 50px;color: #FFF;"></i>
                            </span>
                        <?php endif;?>
                        <?= CartHelper::Predata('order_status',$result->status);?>
                        <?= ($result->enable==0)?'<span class="badge badge-danger">پایان یافته</span>':'' ?>
                    </td>

                    <td>
                        سفارش: <span class="badge badge-pill badge-light-primary">
                        <?= (isset($result->shop_orderproducts)?count($result->shop_orderproducts):'0'); ?></span>
                        <br>
                        تعداد: <span class="badge badge-pill badge-light-primary">
                        <?php $count = 0;foreach($result->shop_orderproducts as $tmp){ $count+= $tmp['quantity'];} echo $count?></span>
                    </td>

                    <td><?php $temp = 0;if(isset($result->shop_orderproducts)){
                        foreach($result->shop_orderproducts as $p){
                            $temp += intval($p['subtotal']);
                        }}?>
                        <?= CartHelper::CreatePrice($temp);?>
                        <?= CartHelper::Predata('currency',$result->currency);?> 
                    </td>

                    <td><?php 
                        if(isset($result['shop_address']['shop_useraddress'])){
                            $tmp = $result['shop_address']['shop_useraddress'];
                            echo isset($province_list[$tmp['billing_state']])?$province_list[$tmp['billing_state']]. ' | ':' - ';
                            echo $pp->getlist($tmp['billing_state'],$tmp['billing_city']);
                        } else echo 'ثبت نشده'?>

                        <?php foreach ($result['shop_ordershippings'] as $item):?>
                        <br>ارسال: <?= isset($shipping_list[$item['types']])?$shipping_list[$item['types']]:'نامشخص'?></strong>
                        <?php endforeach; ?>
                    </td>

                    <td>
                        <?= $this->Func->date2($result->created);?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table></div>
    </div></div>
<?= $this->Form->end(); ?>

<?= $this->element('Admin.paginate')?>
<style>
    .table td{
        padding-right:15px;
        padding-left:15px;
        font-size:13px;
    }
</style>