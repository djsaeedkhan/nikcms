<ul class="shop-sorting pr-2">
    <li>
        <?= $this->Html->link(
            '<i class="icon-caret-left"></i> قیمت: کم به زیاد',
            $this->Query->UrlCon2(['sort'=>'price.asc']),
            ['escape'=>false]);?> 
    </li>
    <li>
        <?= $this->Html->link(
            '<i class="icon-caret-left"></i> قیمت: زیاد به کم',
            $this->Query->UrlCon2(['sort'=> 'price.desc' ]),
            ['escape'=>false]);?> 
    </li>
</ul>