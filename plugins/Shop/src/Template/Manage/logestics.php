<?php
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\PaymentHelper;
use Shop\View\Helper\ShopHelper;
?>
<section id="content">
	<div class="content-wrap pt-4 clearfix">
        <div class="container">
            <?php
            $results = $result['shop_order'];
            if($results['status'] == 'pending')
                $progress = 'payment';
            else $progress = 'tracker';
                include_once('progress.php');
            ?>
        </div>
        <div class="container">
            <div style="font-size:17px;">
                <div class="text-right mb-2" style="font-weight: normal;font-size:17px;">
                    فاکتور : <?= $results['trackcode']?>
                </div>
                <div class="text-right mb-2">محصول: <?= $result['name'];?></div>
                <div class="text-right mb-2">وضعیت تحویل: 
                    <?php
                    if( isset($result['shop_orderlogestics'][0])){
                        $enable = $result['shop_orderlogestics'][0]['enable'];
                        echo $enable == "-1"?'-':($enable == "1"?'<span class="text-success">تحویل شده</span>':'تحویل نشده');
                    };?></div>
            </div><br><br>

            <?php if($my_logestic == "all"):?>
                <h2 style="font-size:17px;">لیست نمایندگی های فعال</h2>
            <?php endif?>
            
            <div class="row">
                <?php foreach ($logesticlist as $item): ?>
                <div class="col-sm-6"><div class="card card-body" style="font-size:13px;">
                    <div class="row">
                        <?php if($item['image'] != ""):?>
                        <div class="col-sm-4 text-center">
                            <img src="<?= $item['image']?>" alt="<?= $item['title']?>" 
                                style="max-height: 180px;border-radius:5px;">
                        </div>
                        <?php endif?>

                        <div class="<?= $item['image'] != ""?'col-sm-8':'col-12'?>">
                            <h3 class="mb-2">
                                <?= $item['title']?>
                                <span class="text-dark" style="cursor: none;font-size: 13px;"><?= $item['level']?></span>
                            </h3>
                            <p><?= $item['descr']?></p>
                            <ul style="list-style-position: inside;">
                                <?= $item['address'] != ""?' <li>آدرس: '.$item['address'].'</li>':''?>

                                <?= ($item['phone1'] != "" or $item['phone2'] != "")?
                                    ' <li>تلفن: '.$item['phone1'].'&nbsp;'.$item['phone2'].'</li>':''?>

                                <?= ($item['mobile1'] != "" or $item['mobile2'] != "")?
                                    ' <li>موبایل: '.$item['mobile1'].'&nbsp;'.$item['mobile2'].'</li>':''?>

                                <?= $item['map_url'] != ""?
                                    '<li>آدرس روی نقشه: <a href="'.$item['map_url'].'" target="_blank" style="font-size: 12px;padding: 2px 6px;" class="text-primary">مشاهده</a></li>':''?>
                            </ul>
                        </div>
                        
                        <?php if($my_logestic == "all"):?>
                        <div class="col-12">
                            <?= $this->form->postlink('انتخاب این نمایندگی',
                                '/product/factor/logestic/'.$result['id'].'?id='.$item['id'],
                                ['class'=>'d-block btn btn-sm btn-success','confirm'=>'آیا از این انتخاب مطمین هستید؟'])?>
                        </div>
                        <?php endif?>

                    </div>
                </div></div>
                <?php endforeach;?>
            </div>
        </div>
 
        </div>
        <div class="clear clearfix"></div><br>

    </div>
</section>