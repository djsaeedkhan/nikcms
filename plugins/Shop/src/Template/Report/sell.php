<?php
use Shop\View\Helper\ShopHelper;
echo $this->element('Shop.report');?>
<div class="table-responsive"><table class="table table-striped bg-white table-bordered table-hover1"
 id="tbexample">
    <thead>
        <tr>
            <th scope="col">عنوان محصول</th>
            <th scope="col">تعداد سفارش</th>
            <th scope="col">تعداد خرید محصول</th>
            <th scope="col">جمع کل خرید</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;foreach ($results as $result):?>
        <tr>
            <td width="300">
                <?= isset($result['name'])?
                $this->html->link($result['name'],'/admin/posts/edit/'.$result['post_id'],
                    ['target'=>'_blank','title'=>'ویرایش محصول']):'نامشخص'?>
            </td>
            <td>
                <?=$result['count']?>
            </td>
            <td>
                <?=$result['qty']?>
            </td>
            <td>
                <?= ShopHelper::PriceShow($result['price'])?>
            </td>

        </tr>
        <?php endforeach;?>
    </tbody>
</table></div>

<style>
    .table td{
        padding-right:15px;
        padding-left:15px;
        font-size:13px;
    }
</style>
<style>.dataTables_paginate,.dataTables_info{display: none;}</style>