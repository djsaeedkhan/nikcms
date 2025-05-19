<?php
use Shop\View\Helper\ShopHelper;
echo $this->element('Shop.report');?>
<table class="table bg-white" id="tbexample1">
    <thead>
        <tr>
            <th>ماه</th>
            <th>تعداد سفارش</th>
            <th>جمع مبلغ سفارشات</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total = 0;
        $price = 0;
        foreach($results as $res):?>
        <tr role="row">
            <td><?= jdate('F ماه Y',strtotime($res['created']->format('Y-m-d'))) ?></td>
            <td><?= $res['count'];$total+=$res['count']; ?></td>
            <td><?= ShopHelper::PriceShow($res['price']);$price +=$res['price'] ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>

<style>.dataTables_paginate,.dataTables_info{display: none;}</style>