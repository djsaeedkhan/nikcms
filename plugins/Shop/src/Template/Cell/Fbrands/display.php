<?php use Cake\ORM\TableRegistry;?>
<?php 
$brands = TableRegistry::get('Shop.shopBrands')->find('all');
if(isset($brand_list) ) 
    $brands->where(['id IN '=> $brand_list]);
$brands->order(['title'=>'asc'])->toarray();?>
<ul class="shop-sorting pr-2">
    <?php foreach($brands as $brand):?>
    <li>
        <?= $this->Html->link(
            '<i class="icon-caret-left"></i> '.$brand['title'],
            '/product/brand/'.strtolower($brand['slug']),
            //$this->Query->UrlCon2(['brand'=> $brand['slug'] ]),
            ['escape'=>false]);?> 
    </li>
    <?php endforeach?>
</ul>