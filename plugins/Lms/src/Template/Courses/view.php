<?php use Cake\Routing\Router;?>
<?= $this->element('Lms.lms_modal');?>

<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    دوره: <?= h($lmsCourse->title) ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <div class="btn-group btn-group contact-name" role="group">
                            <button class="btn btn-sm btn-secondary pr-0 dropdown-toggle mr-1" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                بیشتر
                                <i data-feather="more-vertical" class="toggle-dropdown mt-n25"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="margin: 0px;">
                                <?= $this->Html->link('گزارش وضعیت کاربران دوره',
                                    [$lmsCourse->id,'?'=>['export'=>1]],
                                    ['class'=>'dropdown-item'])?>

                                <?= $this->Html->link('محتواهای بدون اتصال',
                                    [$lmsCourse->id,'?'=>['coursefile'=>1]],
                                    ['class'=>'dropdown-item'])?>    
                                <?= $this->Html->link('ویرایش (Edit)','/admin/lms/courses/add/'.$lmsCourse->id,
                                    ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'dropdown-item',
                                    'data-whatever'=>Router::url('/admin/lms/courses/add/'.$lmsCourse->id.'?nonav=1')]);?>

                                <?= $this->Form->postlink('کپی کردن دوره (Duplicate)','/admin/lms/courses/add/'.$lmsCourse->id.'/duplicate',
                                    ['class'=>'dropdown-item','confirm'=>'آیا موافق هستید یک نسخه از این دوره ایجاد شود؟']);?>
                            </div>
                        </div>

                        <?= $this->Form->postlink(__('حذف'), 
                            ['action' => 'delete', $lmsCourse->id], 
                            ['class'=>'btn btn-sm btn-danger','confirm' => __('Are you sure you want to delete # {0}?', $lmsCourse->id)]) ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>


<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="info-tab-fill" data-toggle="tab" href="#info-fill" role="tab" aria-controls="info-fill" aria-selected="true">توضیحات دوره</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="mohtava-tab-fill" data-toggle="tab" href="#mohtava-fill" role="tab" aria-controls="mohtava-fill" aria-selected="false">لیست محتوای دوره
            &nbsp;
            <span class="badge badge-primary">
                <?= !empty($lmsCourse->lms_courseweeks)?count($lmsCourse->lms_courseweeks):'' ?>
            </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="users-tab-fill" data-toggle="tab" href="#users-fill" role="tab" aria-controls="users-fill" aria-selected="false">کاربران دوره 
            &nbsp;
            <?= (!empty($lmsCourse->lms_courseusers) and count($lmsCourse->lms_courseusers) > 0)?
                ' <span class="badge badge-primary">'.count($lmsCourse->lms_courseusers).'</span>':'' ?>
            
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="related-tab-fill" data-toggle="tab" href="#related-fill" role="tab" aria-controls="related-fill" aria-selected="false">دوره های مرتبط
            &nbsp;
            <?= (!empty($lmsCourse->lms_courserelateds) and count($lmsCourse->lms_courserelateds) > 0)?
                ' <span class="badge badge-primary">'.count($lmsCourse->lms_courserelateds).'</span>':''; ?>
            
        </a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content pt-1">
    
    <!-- --------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------- -->

    <div class="tab-pane active" id="info-fill" role="tabpanel" aria-labelledby="info-tab-fill">
        <div class="card"><div class="card-body">
            <div class="table-responsive"><table class="table table-striped table-borderless table-hover1">
                <tr>
                    <td rowspan="5" width="200">
                        <?= $lmsCourse->image!=''?
                            $this->html->image($lmsCourse->image,['style'=>'max-width:200px;max-height:200px;'])
                            :'بدون تصویر'?>
                    </td>
                </tr>
                <tr>
                    <th scope="row" width="150"><?= __('توضیحات') ?></th>
                    <td><?= $this->Text->autoParagraph(h($lmsCourse->text)); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('اولویت نمایش') ?></th>
                    <td><?= $lmsCourse->priority?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <b><?= __('نمایش در لیست دوره') ?> : </b>
                            <?= $lmsCourse->show_in_list ? __('بله') : __('خیر'); ?>

                        <br>
                        <b><?= __('کاربر بتواند دوره را ثبت نام کند') ?> : </b>
                            <?= $lmsCourse->can_add ? __('بله') : __('خیر'); ?>

                        <br>
                        <b><?= __('وضعیت') ?></b>
                            <?= $lmsCourse->enable?
                                '<span class="badge badge-success">فعال</span>':
                                '<span class="badge badge-danger">غیرفعال</span>' ?>
                    </td>
                </tr>

                </table></div>
        </div></div>
    </div>

    <!-- --------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------- -->

    <div class="tab-pane" id="mohtava-fill" role="tabpanel" aria-labelledby="mohtava-tab-fill">
        <div class="related">
            <h4>
                <?= __('لیست محتوای دوره') ?>
                <?= $this->Html->link('افزودن هفته جدید','/admin/lms/courseweeks/add/'.$lmsCourse->id,
                    ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm btn-primary',
                    'data-whatever'=>Router::url('/admin/lms/courseweeks/add/'.$lmsCourse->id.'?nonav=1')]);?>
            </h4>
            <?php if (!empty($lmsCourse->lms_courseweeks)): ?>
            
                
                <?php foreach ($lmsCourse->lms_courseweeks as $lmsCourseweeks):?><div class="card"><div class="card-body">
                <div class="table-responsive"><table class="table table-striped table-bordered table-hover1 hrrr">
                    <tr style="background:none;">
                        <td style="border:0;color:#FFF" class="bg-success">عنوان: <b><?= h($lmsCourseweeks->title) ?></b></td>
                        <td style="border:0">اولویت : <?= h($lmsCourseweeks->priority) ?></td>
                        <td style="border:0"><?= $this->Func->date2($lmsCourseweeks->created) ?></td>
                        <td style="border:0" class="actions">
                            <?php // $this->Html->link(__('مشاهده'), ['controller' => 'Courseweeks', 'action' => 'view', $lmsCourseweeks->id]) ?>
                            <?= $this->Html->link(__('[ویرایش]'), ['controller' => 'Courseweeks', 'action' => 'Add', $lmsCourse->id,$lmsCourseweeks->id]) ?>
                            <?= $this->Form->postlink(__('[حذف]'), ['controller' => 'Courseweeks', 'action' => 'delete', $lmsCourseweeks->id], 
                                ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCourseweeks->id)]) ?>
                        </td>
                    </tr>

                    
                    <?php if($lmsCourseweeks->lms_coursefiles):?>
                    <tr>
                        <td colspan="4" style="border:0px;">
                            
                            <?php $i=1;foreach ($lmsCourseweeks->lms_coursefiles as $temp):?><br>
                                <div class="table-responsive" style="border:1px solid #bcc6c8;"><table class="table">
                                <tr>
                                    <td colspan="3">
                                        عنوان: <b><?= $temp->title ?></b>
                                            <?= $temp->enable ? 
                                                '<span class="badge badge-success">'.__('فعال').'</span>' :
                                                '<span class="badge badge-danger">'.__('غیرفعال').'</span>'; ?>

                                            <?= $this->Html->link('[ویرایش]','/admin/lms/Coursefiles/Edit/'.$temp->id,
                                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'',
                                                'data-whatever'=>Router::url('/admin/lms/Coursefiles/Edit/'.$temp->id.'?nonav=1')]);?>

                                            <?= $this->Form->postlink('[حذف]','/admin/lms/Coursefiles/delete/'.$temp->id,
                                                ['confirm'=>'برای حذف مطمئن هستید؟']);?>
                                    </td>
                                </tr>
                                <tr style="background-color: rgba(0, 0, 0, 0.05);">
                                    <td width="100">
                                        <?= $temp->image!=''?
                                            $this->html->image($temp->image,['style'=>'max-width:150px;max-height:150px;']):
                                            'بدون تصویر' ?>
                                    </td>
                                    <td width="250">
                                        اولویت نمایش: <?= h($temp->priority) ?><br>
                                        بازه زمانی جلسه: <?= h($temp->total_time) ?><br>

                                        نمایش در وبسایت (مهمان): <?= h($temp->show_in_list) ?><br>

                                        روز فعال سازی: <?= h($temp->days) ?><hr>

                                        فیلم ها: <br>
                                        <?php
                                        for($j=1;$j<5;$j++):
                                            if($temp['filesrc_'.$j]!=''){
                                                echo $this->html->link('<span class="badge badge-info" style="font-weight: normal;color:#FFF;">کیفیت '.$j.' (مشاهده)</span> ',
                                                    $temp['filesrc_'.$j],
                                                    ['escape'=>false,'target'=>'_blank','title'=>$temp['filesrc_'.$j]]);
                                                echo '<br>';
                                            }
                                                
                                        endfor;
                                        if(isset($temp['filesrc_extra']) and $temp['filesrc_extra']!= ''){
                                            echo $this->html->link('<span class="badge badge-info" style="font-weight: normal;color:#FFF;">پلیر استریم</span> ',
                                                    $temp['filesrc_extra'],
                                                    ['escape'=>false,'target'=>'_blank']); 
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        
                                        <b>توضیحات: </b>
                                        <?= h($temp->content!=''?$temp->content:'ثبت نشده است') ?><hr>

                                        <b><?= __('توضیحات جانبی فایل:') ?></b>
                                            <?= $this->Html->link('افزودن توضیح','/admin/lms/Coursefilenotes/add/'.$temp->id,
                                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'badge badge-primary',
                                                'data-whatever'=>Router::url('/admin/lms/Coursefilenotes/add/'.$temp->id.'?nonav=1' )]);?><br>
                                        <?php 
                                        if($temp['lms_coursefilenotes']):
                                            foreach ($temp['lms_coursefilenotes'] as $temp2):
                                                echo '- '.
                                                (isset($coursefilenotes_type[$temp2->types])?'['.$coursefilenotes_type[$temp2->types].'] ':'-').
                                                $temp2->descr.
                                                $this->Form->postlink(' [حذف]','/admin/lms/Coursefilenotes/delete/'.$temp2->id,['confirm'=>'برای حذف مطمئن هستید؟']).
                                                '<br>';
                                            endforeach;
                                        endif;?>
                                    </td>
                                </tr>
                                <tr style="background-color: rgba(0, 0, 0, 0.05);">
                                    <td colspan="3">
                                        <b>آزمون: </b>
                                        <?php
                                        if($temp['lms_courseexams']):
                                            foreach ($temp['lms_courseexams'] as $temp2):
                                                if(isset($temp2['lms_exam']['title'])){
                                                    echo $this->html->link($temp2['lms_exam']['title'],
                                                        ['controller'=>'Exams','action'=>'view',$temp2['lms_exam']['id']]);
                                                    echo $this->Form->postlink(' [حذف]',
                                                        ['controller'=>'Courseexams','action'=>'delete',$temp->id],
                                                        ['title'=>'حذف','class'=>'text-danger','confirm' => 'برای حذف مطمئن هستید ؟'] );
                                                }
                                            endforeach;
                                        else:
                                            echo $this->Html->link('ثبت آزمون','/admin/lms/Courseexams/add/'.$temp->id,
                                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'badge badge-primary',
                                                'confirm'=>'برای جلوگیری از تداخل نتایج، هر آزمون فقط یک بار در هر دوره استفاده شود',
                                                'data-whatever'=>Router::url('/admin/lms/Courseexams/add/'.$temp->id.'?nonav=1' )]);
                                        endif;?>
                                    </td>
                                </tr>
                                </table></div><br>
                            <?php endforeach; ?>
                        
                        </td>
                    </tr>
                    <?php endif?>
                    
                    <tr style="border:0;background:none;">
                    <td colspan="4" style="border:0;">
                        <!-- <?= $this->html->link('+ افزودن فایل',
                            ['controller' => 'Coursefiles', 'action' => 'add', $lmsCourse->id,$lmsCourseweeks->id])?> -->

                        <?= $this->Html->link('+ افزودن فایل','/admin/lms/Coursefiles/add/'.$lmsCourse->id.'/'.$lmsCourseweeks->id,
                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'',
                                'data-whatever'=>Router::url('/admin/lms/Coursefiles/add/'.$lmsCourse->id.'/'.$lmsCourseweeks->id.'?nonav=1')]);?>
                            
                        </td></tr>

                </table></div></div></div>
                <?php endforeach; ?>

            <?php endif; ?>

            <?= $this->Html->link('افزودن هفته جدید','/admin/lms/courseweeks/add/'.$lmsCourse->id,
                ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm btn-primary',
                'data-whatever'=>Router::url('/admin/lms/courseweeks/add/'.$lmsCourse->id.'?nonav=1')]);?>
        </div>
    </div>
    
    <!-- --------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------- -->

    <div class="tab-pane" id="users-fill" role="tabpanel" aria-labelledby="users-tab-fill">
        <div class="related">
            <h3>
                <input type="text" class="form-control form-control-sm float-left" placeholder="جستجو در کاربران دوره" 
                    id="search-criteria" style="width:200px;">
                کاربران دوره (<?= count($lmsCourse->lms_courseusers)?> نفر)
                <?= $this->Html->link('افزودن کاربر به دوره','/admin/lms/Courseusers/add/'.$lmsCourse->id ,
                    ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm btn-primary',
                    'data-whatever'=>Router::url('/admin/lms/Courseusers/add/'.$lmsCourse->id .'?nonav=1' )]);?>

                <?= $this->Html->link('حذف کاربران','/admin/lms/Courseusers/delete/'.$lmsCourse->id ,
                    ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm btn-danger',
                    'data-whatever'=>Router::url('/admin/lms/Courseusers/delete/'.$lmsCourse->id .'?nonav=1' )]);?>

            </h3>
            <div class="clearfix"></div><br>

            <?php if (!empty($lmsCourse->lms_courseusers)): ?>
            <div class="card"><div class="card-body">
                
                <?php foreach ($lmsCourse->lms_courseusers as $lmsCourseusers):?>
                <div class="btn-group btn-group-sm contact-name" role="group" style="margin-bottom:10px;" >
                    <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" 
                        style="line-height: 18px;" aria-haspopup="true" aria-expanded="false">
                        <?= isset($lmsCourseusers->user)?
                            $lmsCourseusers->user['username'].($lmsCourseusers->user['family']!=''?' ('.$lmsCourseusers->user['family'].')':''):'-' ?>
                        <Br><span style="direction:ltr;display: inline-block;">(<?= $this->Func->date2($lmsCourseusers['created']) ?>)  </span> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="margin: 0px;">
                        <?= $this->html->link('نمایش مشخصات کاربری',['controller'=>'User','action'=>'view',$lmsCourseusers->user_id ],['class'=>'dropdown-item'])?>
                        
                        <?= $this->html->link('وضعیت دوره کاربر',
                            ['controller' => 'Courseusers', 'action' => 'view', $lmsCourse->id ,  $lmsCourseusers->user_id],
                            ['class'=>'dropdown-item'])?>

                        <?= $this->html->link('تغییر تاریخ شروع دوره', 
                            ['controller' => 'Courseusers', 'action' => 'edit',$lmsCourseusers->id ,  $lmsCourseusers->user_id], 
                            ['class'=>'dropdown-item']) ?>

                        <?= $this->Form->postlink('حذف کاربر از دوره', 
                            ['controller' => 'Courseusers', 'action' => 'delete',$lmsCourse->id ,  $lmsCourseusers->user_id], 
                            ['class'=>'dropdown-item','confirm' => __('Are you sure you want to delete # {0}?',$lmsCourseusers->id)]) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div></div>
            <?php endif; ?>
        </div><br>
    </div>
    
    <!-- --------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------- -->

    <div class="tab-pane" id="related-fill" role="tabpanel" aria-labelledby="related-tab-fill">
        <div class="related">
            <h3>
                دوره های مرتبط
                <?= $this->html->link('افزودن',['controller' => 'Courserelateds', 'action' => 'add',$lmsCourse->id],['class'=>'btn btn-sm btn-primary'])?>
            </h3>
            <?php if (!empty($lmsCourse->lms_courserelateds)): ?>
            <div class="card"><div class="card-body">
                <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th scope="col"><?= __('عنوان دوره') ?></th>
                        <th scope="col"><?= __('نوع ') ?></th>
                        <th scope="col" class="actions"></th>
                    </tr>
                    <?php foreach ($lmsCourse->lms_courserelateds as $lmsCourserelateds): ?>
                    <tr>
                        <td><?= isset($lmsCourserelateds->lms_courses)?$lmsCourserelateds->lms_courses['title']:'-' ?></td>
                        <td><?php //h($lmsCourserelateds->types) ?> پیش نیاز</td>
                        <td class="actions">
                            <?= $this->Form->postlink(__('حذف'), 
                                ['controller' => 'Courserelateds', 'action' => 'delete', $lmsCourserelateds->id], 
                                ['confirm' => __('آیا مطمئن هستید این دوره مرتبط را حذف کنید؟?', $lmsCourserelateds->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table></div>
            </div></div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- --------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------- -->

</div>
    

   

<style>
.hrrr table {
    border: 1px solid #c2cfd6;
}
.hrrr th, .hrrr td {
    border: 0 solid #c2cfd6;
}
</style>   








<style>
.table-hover1 {border: 2px solid #536c7163 !important;}
</style>
<script nonce="<?=get_nonce?>">
//$('#search').click(function(){
$("#search-criteria").keyup(function(){

    //$('.contact-name').hide();
    var txt = $('#search-criteria').val();
    $('.contact-name').each(function(){
       if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
           $(this).show();
       }
       else $(this).hide();
    });
});</script>