<?php
use Shop\View\Helper\ShopHelper;
?>
<section id="content" dir="rtl" class="text-right" >
    <div class="content-wrap pt-4 pb-1" style="overflow: visible;min-height:500px;">
		<div class="container">
            <h2 class="text-right mb-2">لیست مقایسه</h2>
            <?php if(empty($results)) : ?>
                <div class="alert alert-info text-center">لیست مقایسه شما خالی می باشد</div>
            <?php else:?>
                <div class="bg-white p-3">
                    <?php foreach ($results as $result):?>
                    <div class="float-right mx-1 mxx1">
                        <?= $this->html->link('X',
                            ['?'=>['delete'=>$result['id']]],
                            ['class'=>'idcls'])?>

                        <table class="table table-bordered text-center" style="width: inherit;">
                            <tr><td>
                                <?php if($img = $this->Query->postimage('thumbnail',$result)){
                                    echo $this->html->image($img, ['alt'=>$result['title'],'class'=>'br-5' ]);
                                }?>
                            </td></tr>
                            <tr>
                                <td><a target="_blank" href="<?= $this->Query->the_permalink(['id' =>$result['id'] ])?>">
                                    <?= $result['title']?>
                                    </a></td>
                            </tr>

                            <tr>
                                <td><?= ShopHelper::PriceShow(ShopHelper::PriceGet($result['id']))?></td>
                            </tr>
                            <tr style="font-size:14px;text-align:right">
                                <td><?= nl2br(ShopHelper::Meta('short_descr',$result['id']))?></td>
                            </tr>
                            
                        </table>
                    </div>

                    <?php endforeach?>
                    <div class="clearfix clearfloat"></div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
<style>
.mxx1{
    width: 250px;
    display: inline-block;    
}
.idcls{
    position: absolute;
    margin-right: -20px;
    margin-top: 5px;
}
</style>