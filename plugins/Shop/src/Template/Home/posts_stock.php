<?php
use Shop\View\Helper\ShopHelper;
?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت موجودی
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb" style="padding-top:5px;">
                        "<?= $post->title?>"
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create(null);?>
<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col">عنوان ویژگی</th>
            <th scope="col">تعداد موجودی</th>
            <th scope="col">تعداد منتظر پرداخت</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $stock = ShopHelper::getStock($id);
        foreach ($lists as $k=>$list): ?>
        <tr>
            <td width="200">
                <?php 
                if($list['pattern'] == null){
                    echo '<span class="badge badge-primary">پیش فرض</span>';
                    $lists[$k]['pattern'] = 0;
                }
                else{
                    foreach( explode(',',$list['pattern']) as $tmp)
                    echo isset($pattern[$tmp])?'<span class="badge badge-primary mr-1">'.$pattern[$tmp].'</span>' : '[-]';
                }?>
            </td>
            <td class="ltr" width="200">
                <?= $this->form->control('stock.'.$list['id'],[
                    'label'=>false,
                    'type'=>'number',
                    'class'=>'form-control','default'=>$list['stock'] ])?>
            </td>
            <td class="ltr">
                <?= isset($stock[$list['pattern']])? $list['stock'] - $stock[$list['pattern']]:'-'?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table></div>

<?= $this->Form->button(__('ثبت اطلاعات'),[
    'confirm'=>'برای ثبت اطلاعات مطمئن هستید؟',
    'class'=>'btn btn-success btn-sm']);?>
<?= $this->Form->end();?>

<br><div class="alert alert-danger small">
    مدت زمان انتظار پرداخت، 60 دقیقه از زمان ثبت سفارش توسط مشتری می باشد
        و پس از آن بصورت اتوماتیک حذف می گردد
</div>