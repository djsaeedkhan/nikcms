<?php
use Cake\Routing\Router;
use Challenge\Predata;
$predata = new Predata();
?>
    <h3>
        <?= h($challengeuserform->title) ?>
        <?= $this->Html->link(__('ویرایش'), ['action' => 'edit', $challengeuserform->id],['class'=>'btn btn-info text-white']) ?>
    </h3>
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
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
        <!-- <tr>
            <th scope="row"><?= __('Enable') ?></th>
            <td><?= $challengeuserform->enable ? __('Yes') : __('No'); ?></td>
        </tr> -->
        <tr>
            <th scope="row"><?= __('تایید شده') ?></th>
            <td><?= $challengeuserform->approved ? __('بله') : __('خیر'); ?></td>
        </tr>
    </table></div>


    <div class="table-responsive"><table class="table table-striped table-bordered table-hover1 bg-white">
        <tr>
            <th scope="row" width="200"><?= __('کدرهگیری مشارکت') ?></th>
            <td class="alert alert-success"><?= (isset($challengeuserform->token1) and $challengeuserform->token1)!=''?str_replace('.','&nbsp',$challengeuserform->token1):'-'?></td>
        </tr>

        <tr><td colspan="2"><?php if(isset($chresult)){
            foreach($chresult as $res){
                echo $predata->createform($res,$qlist);
            }
        } ?>
        </td></tr>
        
        <?php if($challengeuserform->title != ''):?>
        <tr>
            <th scope="row"><?= __('عنوان') ?></th>
            <td><?= h($challengeuserform->title) ?></td>
        </tr>
        <?php endif?>

        <?php if($challengeuserform->descr1 != ''):?>
        <tr>
            <th width="300" scope="row"><?= __('توضیحات 1') ?></th>
            <td><?= $this->Text->autoParagraph(h($challengeuserform->descr1)); ?></td>
        </tr>
        <?php endif?>

        <?php if($challengeuserform->descr2 != ''):?>
        <tr>
            <th scope="row"><?= __('توضیحات 2') ?></th>
            <td><?= $this->Text->autoParagraph(h($challengeuserform->descr2)); ?></td>
        </tr>
        <?php endif?>
        
        <?php if($challengeuserform->descr3 != ''):?>
        <tr>
            <th scope="row"><?= __('توضیحات 3') ?></th>
            <td><?= $this->Text->autoParagraph(h($challengeuserform->descr3)); ?></td>
        </tr>
        <?php endif?>

        <?php if($challengeuserform->descr4 != ''):?>
        <tr>
            <th scope="row"><?= __('توضیحات 4') ?></th>
            <td><?= $this->Text->autoParagraph(h($challengeuserform->descr4)); ?></td>
        </tr>
        <?php endif?>

        <?php if($challengeuserform->descr5 != ''):?>
        <tr>
            <th scope="row"><?= __('توضیحات 5') ?></th>
            <td><?= $this->Text->autoParagraph(h($challengeuserform->descr5)); ?></td>
        </tr>
        <?php endif?>

        <?php if($challengeuserform->descr6 != ''):?>
        <tr>
            <th scope="row"><?= __('توضیحات 6') ?></th>
            <td><?= $this->Text->autoParagraph(h($challengeuserform->descr6)); ?></td>
        </tr>
        <?php endif?>
    </table></div>

    <!-- <div class="row">
        <h4><?= __('Userinfo') ?></h4>
        <?= $this->Text->autoParagraph(h($challengeuserform->userinfo)); ?>
    </div> -->