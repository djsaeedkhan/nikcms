<ul class="<?= isset($value['ul_class'])?$value['ul_class']:''?>" >
<?php
if(isset($value['category'])):
    $data = [];
    if( isset($value['types']) and $value['types'] == 1){
        $this->Query->category('product',[
            'order'=>'created','limit'=>0,
            'parent'=> ($value['category'] != null?$value['category']:0) ]);
    }
    else{
        global $category;
        $data = $this->Query->category('product',[
            'order'=>'created','limit'=>0,
            'parent'=> (isset($category['parent_id'])?$category['parent_id']:0) ]);
    }
    foreach($data as $res){
        echo '<li class="'.(isset($value['li_class'])?$value['li_class']:'').' '.((isset($category['id']) and $category['id'] == $res['id'])?'current':'').'">';

            echo $this->Query->permalink(
                (isset($value['a_before'])?$value['a_before']:'') . $res['title'],
                $res,
                ['type' => 'index','class'=> (isset($value['a_class'])?$value['a_class']:'') ]);
        echo '</li>';
    }
echo '<div class="clearfix"></div>';
endif;
?>
</ul>
