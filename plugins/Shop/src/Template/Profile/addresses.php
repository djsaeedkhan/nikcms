<?php $this->assign('shop_title','آدرس های من')?>

<?php $pp = new Shop\ProvinceCity();?>
<?= $this->html->link('افزودن آدرس جدید',
    ['addresses','?'=>['action'=>'add' , 'nonav' =>$this->request->getQuery('nonav')?1:'' ]],
    ['class'=>'button button-small button-primary mb-3'])?>

<div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
    <tbody>
        <?php $i=0;if(count($results)):foreach ($results as $result): ?>
        <tr>
            <td>
                <strong>استان</strong> <?= $this->Func->province_list($result->billing_state)?>  
                <strong>شهرستان</strong>
                    <?=$pp->getlist($result->billing_state,$result->billing_city);?>
                    <!-- <?= $result->billing_city?> --> <br>
                <?= $result->billing_address?> 
                <?= $result->billing_zip!=''?' / کدپستی: '.$result->billing_zip:''?> 
            </td>
            <td style="text-align: left;">
                <!-- <?php  $this->Form->postlink('حذف',
                    ['addresses','?'=>['delete'=>$result['id']]],
                    ['confirm'=>'برای حذف این آدرس مطمئن هستید؟'])?> |  -->
                    
                <?= $this->html->link('ویرایش',
                    ['addresses','?'=>['action'=>'add','edit'=>$result['id']]])?>
            </td>
        </tr>
        <?php endforeach;else:?>
            <tr><td>آدرسی برای نمایش وجود ندارد<br> لطفا آدرستان را ثبت کنید</td></tr>
        <?php endif;?>
    </tbody>
</table></div>