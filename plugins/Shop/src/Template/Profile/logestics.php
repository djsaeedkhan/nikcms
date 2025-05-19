<?php $this->assign('shop_title','نمایندگی های من')?>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('image','تصویر') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title','عنوان') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descr','توضیحات') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address','آدرس') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shop_logesticlist_id','دسته بندی') ?></th>
                <th scope="col"></th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logestics as $log):
                $shopLogestic = $log['shop_logestic'];?>
            <tr style="font-size:13px;">
                <td width="50" class="p-0"><?=$this->html->image($shopLogestic->image,[
                    'style'=>'max-width:100px;max-height:100px;border-radius:5px;']) ?>
                </td>
                <td><?= h($shopLogestic->title) ?> <?= h($shopLogestic->enable == 1)?
                        '<span class="text-success">فعال</span>':'<span class="badge badge-danger">غیرفعال</span>'?>
                </td>
                <td><?= h($shopLogestic->descr) ?></td>
                <td><?= h($shopLogestic->address) ?></td>
                <td><?= $shopLogestic->has('shop_logesticlist') ?$shopLogestic->shop_logesticlist->title: '' ?></td>
                <td><?= $this->html->link('مشاهده درخواستها',
                    '/shop/profile/logestic/'.$shopLogestic->id,
                    ['class'=>'btn btn-sm btn-secondary','style'=>'font-size:12px;',]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table></div>
</div></div>