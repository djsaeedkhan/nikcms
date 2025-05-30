<?php
use Cake\Routing\Router;
?>
    <h3 class="mb-2">
        عنوان: <?= h($challenge->title) ?> 
        <a class="btn btns btn-success btn-sm mx-1">خروجی جدول</a>
    </h3>
    <?php /*<div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
        <tr>
            <th width="100" scope="row"><?= 'عنوان '.__d('Template', 'همیاری').'' ?></th>
            <td><?= $challengeuserform->has('challenge') ? $this->Html->link($challengeuserform->challenge->title, ['controller' => 'Challenges', 'action' => 'view', $challengeuserform->challenge->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('کاربر') ?></th>
            <td><?= $challengeuserform->has('user') ? $this->Html->link($challengeuserform->user->family, ['controller' => 'Users', 'action' => 'view', $challengeuserform->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('آدرس فایل') ?></th>
            <td>
                <?= $challengeuserform->filesrc!=''?$this->html->link('دانلود1',
                    '/challenge/'.$challengeuserform->filesrc,
                    ['class'=>'btn btn-warning btn-sm']):'' ?>

                <?= $challengeuserform->filesrc2!=''?$this->html->link('دانلود2',
                    '/challenge/'.$challengeuserform->filesrc2,
                    ['class'=>'btn btn-warning btn-sm']):'' ?>

                <?= $challengeuserform->filesrc3!=''?$this->html->link('دانلود3',
                    '/challenge/'.$challengeuserform->filesrc3,
                    ['class'=>'btn btn-warning btn-sm']):'' ?>
                </td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('تاریخ ثبت') ?></th>
            <td><?= $this->Query->the_time($challengeuserform) ?></td>
        </tr>
        <tr class="d-none">
            <th scope="row"><?= __('Enable') ?></th>
            <td><?= $challengeuserform->enable ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('تایید شده') ?></th>
            <td><?= $challengeuserform->approved ? __('بله') : __('خیر'); ?></td>
        </tr>
    </table></div> */?>


    <div class="table-responsive"><table class="table table-striped table-bordered table-hover1 bg-white">
        <?php $i = 0;
        foreach($cp as $cps):
            if(isset($cps['challengeqanswers']) and count($cps['challengeqanswers']) > 0 and isset($cps['challengeuserforms'][0]['id'])):
            if($i == 0):?>

                <thead>
                    <tr>
                        <th scope="row" width="100"><?= __('ID') ?></th>
                        <th scope="row" width="200"><?= __('کاربر') ?></th>
                        <th scope="row" width="200"><?= __('کدرهگیری') ?></th>
                        <th scope="row" width="200"><?= __('تاریخ ثبت') ?></th>
                        <?php foreach($cps['challengeqanswers'] as $answ):?>
                            <th class="text-nowrap" scope="col" >
                                <?= isset($qlist[$answ['challengequest_id']])?$qlist[$answ['challengequest_id']]:'-';?>
                            </td>
                        <?php endforeach;?>
                    </tr>
                </thead>
                <tbody>

            <?php endif;?>

            <tr>
                <td scope="row" width="200"><?= isset($cps['challengeuserforms'][0]['id'])?$cps['challengeuserforms'][0]['id']:'';?></td>
                <td scope="row" width="200"><?= $cps['family'];?> (<?= $cps['username'];?>)</td>
                <td scope="row" width="200"><?= isset($cps['challengeuserforms'][0]['token1'])?$cps['challengeuserforms'][0]['token1']:'';?></td>
                <td scope="row" width="200"><?= isset($cps['challengeuserforms'][0]['created'])?$this->Func->date2($cps['challengeuserforms'][0]['created']):''?></td>
                <?php foreach($cps['challengeqanswers'] as $answ):?>
                    <td class="text-nowraps" style="max-width:400px;">
                        <span class="addReadMore showlesscontent">
                            <?php
                            switch ($answ['types']) {
                                case 'file':
                                    if($answ['value']!=''){
                                        echo $this->html->link(Router::url($answ['value'],'true'),'/challenge/'.$answ['value']);
                                    }else echo '-';
                                    break;
                                
                                default:
                                    echo $answ['value']!=''?nl2br($answ['value']):'-';
                                    break;
                            }?>
                        </span>
                    </td>
                <?php endforeach;?>
            </tr>
        <?php $i+=1;endif;endforeach;?>
        </tbody>
    </table></div>

<script nonce="<?=get_nonce?>">
    function AddReadMore() {
    var carLmt = 250;
    var readMoreTxt = " ... نمایش بیشتر";
    var readLessTxt = " نمایش کمتر";
    $(".addReadMore").each(function() {
        if ($(this).find(".firstSec").length)
            return;
        var allstr = $(this).text();
        if (allstr.length > carLmt) {
            var firstSet = allstr.substring(0, carLmt);
            var secdHalf = allstr.substring(carLmt, allstr.length);
            var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore noExl'  title='نمایش بیشتر کلیک کنید'>" + readMoreTxt + "</span><span class='readLess noExl' title='نمایش کمتر کلیک کنید'>" + readLessTxt + "</span>";
            $(this).html(strtoadd);
        }
    });
    $(document).on("click", ".readMore,.readLess", function() {
        $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
    });
}
$(function() {
    AddReadMore();
});
</script>
<style>
.addReadMore.showlesscontent .SecSec,
.addReadMore.showlesscontent .readLess {
    display: none;
}
.addReadMore.showmorecontent .readMore {
    display: none;
}
.addReadMore .readMore,
.addReadMore .readLess {
    margin-left: 2px;
    color: blue;
    cursor: pointer;
}
.addReadMoreWrapTxt.showmorecontent .SecSec,
.addReadMoreWrapTxt.showmorecontent .readLess {
    display: block;
}
</style>

<script nonce="<?=get_nonce?>">
    $(function() {
        $(".btns").click(function(){
            let table = $('.crt').html();
            console.log(table);
            $('.noExl').empty();
            $('.noExl').remove();
            //$('.noExl').delete();
            var whitelist = ""; // for more tags use the multiple selector, e.g. "p, img"
            $(".table .strip_tags *").not(whitelist).each(function() {
                var content = $(this).contents();
                $(this).replaceWith(content,"/");
            });
            $(".table").table2excel({
                exclude:".noExl",
                name: "Excel Document Name",
                exclude_img:true,
                exclude_links:true,
                exclude_inputs:true,
                preserveColors:false,
            });
            $('.crt').html(table) ;
        });
    });
</script>