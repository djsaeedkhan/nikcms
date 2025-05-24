<?php use Cake\ORM\TableRegistry;?>
<?php $labels = $this->getTableLocator()->get('Shop.shopLabels')->find('all')
    ->order(['title'=>'asc'])
    ->toarray();?>
<ul class="shop-sorting pr-2">
    <?php foreach($labels as $label):?>
    <li>
        <?= $this->Html->link(
            '<i class="icon-caret-left"></i> '.$label['title'],
            '/product/label/'.strtolower($label['title']),
            //$this->Query->UrlCon2(['label'=> $label['title'] ]),
            ['escape'=>false]);?> 
    </li>
    <?php endforeach?>
</ul>