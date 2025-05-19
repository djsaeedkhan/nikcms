<?php
use Lms\Predata;
use Cake\Routing\Router;
$pd = new Predata();

/* $registerfield = $this->Func->OptionGet('plugin_registerfield');
if($registerfield) $registerfield = unserialize($registerfield);
 */

$metalist = [];
foreach ($users as $user):
    foreach ($this->Func->MetaList($user , 'users') as $ktmp=>$kval):
        if (strpos("$ktmp", "rf_") !== false) {
            $metalist[$ktmp] = $ktmp;
        } 
    endforeach;
endforeach;
?>
<h3>
    کاربران سامانه آموزشی
    <?= $this->html->link('افزودن',
        ['plugin'=>'Admin', 'controller'=>'Users','action'=>'add'],
        ['class'=>'btn btn-sm btn-primary'])?>
    <?= $this->html->link('افزودن گروهی',
        [ 'controller'=>'User','action'=>'Group'],
        ['class'=>'btn btn-sm btn-primary'])?>

    <div class="pull-left">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false,'class'=>'col-sm-12']); ?>
        <div class="row">
            <div class="pull-left">
                <?= $this->Form->control('text', [
                'label'=>false,
                'type' => 'text', 
                'class' => 'form-control form-control-sm',
                'placeholder'=>'عنوان را وارد کنید',
                'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                ]);?>
            </div>
            <div class="pull-left">
                <?= $this->Form->button(__('جستجو'),['class'=>'btn btn-sm btn-success']);?>
                <?=$this->request->getQuery('text')?'<a href="?"class="small">حذف فیلتر</a>':''?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>

    <div class="pull-left mx-2">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false,'class'=>'col-sm-12']); ?>
        <div class="row">
            <div class="pull-left">
                <?= $this->Form->control('limit',[
                    'label'=>'تعداد نمایش   : ',
                    'empty'=>'-- انتخاب  --',
                    'options'=>[
                        '5'=>5,
                        '25'=>25,
                        '50'=>50,
                        '100'=>100,
                        '250'=>250,
                        '500'=>500,
                        '1000' =>1000,
                        '1000000' =>"همه",
                    ],'class'=>'form-control form-control-sm d-inline col-sm-6'
                ]);?>
            </div>
            <div class="pull-left">
                <?= $this->Form->button(__('نمایش'),['class'=>'btn btn-sm btn-success']);?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</h3><br>
<div class="clearfix"></div>

<?= $this->Form->create(null,[
        'url'=>['controller'=>'Courseusers','action'=>'add'],'id'=>'formId',
        'class'=>'col-sm-12 p-0',
        'type'=>'get']) ?>

<div class="d-flex mb-1">
    <?php
    echo $this->Form->control('action',[
        'label'=>'کارهای دسته جمعی : ', 'id'=>'dd_select',
        'empty'=>'-- انتخاب کنید --',
        'options'=>[
            'delete'=>'حذف دسته جمعی',
            'disable'=>'غیرفعال کردن کاربر',
            'enable'=>'فعال کردن کاربر',
            'addtocourse' =>'افزودن به دوره',
        ],'class'=>'form-control form-control-sm d-inline col-sm-6'
    ]);
    
    echo $this->Form->button(__('اجرا'),['class'=>' btn btn-sm btn-success d-flex']) ?>
    <script nonce="<?=get_nonce?>">
        $(function(){
        // bind change event to select
        $('#dd_select').on('change', function () {
            if ($(this).val() == 'delete') {
                $('#formId').attr('action', '<?=Router::url(['action'=>'group','type'=>'delete'])?>');
            }
            if ($(this).val() == 'disable') {
                $('#formId').attr('action', '<?=Router::url(['action'=>'group','type'=>'disable'])?>');
            }
            if ($(this).val() == 'enable') {
                $('#formId').attr('action', '<?=Router::url(['action'=>'group','type'=>'enable'])?>');
            }
        });
        });
    </script>
</div>


<div class="card"><div class="card-body crt">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col" class="noExl">
                    <a class="select-me" title="انتخاب همه سطرها">همه</a>
                </th>
                <th width="30%" scope="col"><?= $this->Paginator->sort('family','نام خانوادگی') ?></th>
                <th width="30%" scope="col"><?= $this->Paginator->sort('username','نام کاربری') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('family','نام خانوادگی') ?></th> -->
                <!-- <th scope="col">ش آموزشی / عضویت</th> -->
                <!-- <th scope="col"><?= $this->Paginator->sort('membership_type','نوع عضویت') ?></th> -->
                <th scope="col">دوره ها</th>
                <th scope="col">آزمون ها</th>
                <!-- <th scope="col"><?= $this->Paginator->sort('email','ایمیل') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone','تلفن') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_id','کاربری') ?></th> -->
                <th scope="col">فاکتور ها</th>
                <th scope="col">پرداخت ها</th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>

                <?php foreach($metalist as $mt):
                    echo '<th scope="col">'.str_replace('rf_','',(strlen($mt)>3?$mt:' -- ')).'</th>';endforeach;?>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($users as $user):$meta = $this->Func->MetaList($user , 'users');?>
            <tr>
                <td style="width:30px;padding-right:0;padding-left:0;text-align: center;"class="noExl">
                    <?= $this->Form->checkbox('user_id.', 
                        array('value' => $user->id, 'class'=>'checkboxAll','hiddenField' => false))?>
                </td>
                <td>
                    <div class="strip_tags">
                        <strong><?= h($user->family) ?></strong>
                        <?= ($user->enable)?'':'<span class="badge badge-danger">غیرفعال</span>'?>
                        <hr style="margin:5px 0" class="noExl">

                        <?= (isset($meta['educational_id'])and $meta['educational_id']!= '')?'<hr style="margin:5px 0">شناسه : '.$meta['educational_id'].'<br>':'' ?>
                        <?= (isset($meta['membership_type']) and $meta['membership_type']!= '')?'نوع: '.$meta['membership_type'].'<br>':'' ?>
                        <?php // (isset($meta['rf_name']) and $meta['rf_name']!= '')?'نام خانوادگی : '.$meta['rf_name'].'<br>':'' ?>
                        <?php // (isset($meta['rf_eduction']) and $meta['rf_eduction']!= '')?'مقطع تح: '.$meta['rf_eduction'].'<br>':'' ?>
                        <?php // (isset($meta['rf_gender']) and $meta['rf_gender']!= '')?'جنسیت: '.$meta['rf_gender'].'<br>':'' ?>
                        <?php // (isset($meta['rf_birthdate']) and $meta['rf_birthdate']!= '')?'تاریخ تولد: '.$meta['rf_birthdate'].'<br>':'' ?>
                        <?php // (isset($meta['rf_']) and $meta['rf_']!= '')?'نحوه اطلاع: '.$meta['rf_'].'<br>':'' ?>
                    </div>

                    <div class="hidme noExl">
                        <?= $this->Html->link(__('نمایش'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('ویرایش'), ['plugin'=>'admin','controller'=>'Users','action' => 'edit', $user->id]) ?>
                        <?= $this->Html->link(__('حذف'), ['action' => 'group', '?'=>['action'=>'delete','user_id' => $user->id] ] ) ?>
                    </div>
                </td>
                <td>
                    <?= h($user->username) ?>
                </td>

                <td><div class="strip_tags">
                    <?php if(isset($user['lms_courseusers'])):
                        foreach($user['lms_courseusers'] as $course){
                            if(isset($course['lms_course']['title'])):
                                echo '<span class="badge badge-secondary fw-n">';
                                echo $this->html->link($course['lms_course']['title'],
                                    '/admin/lms/courses/view/'.$course['lms_course']['id'],
                                    ['class'=>'text-white','title'=>'نمایش دوره']);
                                echo '</span>';

                                echo $this->html->link('<i class="fa fa-search"></i>',
                                    ['?'=>['course_id'=> $course['lms_course']['id'] ]],
                                    ['class'=>'text-success','escape'=>false,'title'=>'نمایش کاربران این دوره']);
                                echo '<br>';
                            endif;
                        }
                    endif?>
                </div></td>

                <!--- -------------------------------------------------------------- -->

                <td><div class="strip_tags">
                    <?php if(isset($user['lms_examresults'])):
                        foreach($user['lms_examresults'] as $temp){
                            if(isset($temp['lms_exam']['title'])):
                                echo '<div class="mb-2">';

                                if(isset($temp['LmsCourses'])):
                                    echo $this->html->link('د: '.$temp['LmsCourses']['title'],
                                        '/admin/lms/courses/view/'.$temp['LmsCourses']['id'],
                                        ['class'=>'text-dark mr-1 ml-1','title'=>'نمایش دوره']);
                                    echo ' | <br> ';
                                endif;

                                if(isset($temp['lms_exam']['title'])):
                                    echo $this->html->link('آز: '.$temp['lms_exam']['title'],
                                        '/admin/lms/exams/view/'.$temp['lms_exam']['id'],
                                        ['class'=>'text-dark mr-1 ml-1','title'=>'مشاهده آزمون']);
                                    echo ' ';
                                endif;

                                echo $this->html->link($pd->getvalue('exam_result', $temp['result']) ,
                                    '/admin/lms/results/view/'.$temp['id'],
                                    ['class'=>'text-success mr-1 ml-1','escape'=>false,
                                    'title'=>'نمایش نتیجه آزمون']);

                                /* echo $this->html->link('<i class="fa fa-search"></i>',
                                    ['?'=>['course_id'=> $temp['lms_exam']['id'] ]],
                                    ['class'=>'text-white mr-1 ml-1','escape'=>false,'title'=>'نمایش کاربران این دوره']); */
                                echo '</div>';
                            endif;
                        }
                    endif?>
                </div></td>

                <!--- -------------------------------------------------------------- -->

                <td>
                    <div class="strip_tags">

                        <?php
                        if(isset($user['lms_factors'])):
                            foreach($user['lms_factors'] as $temp){
                                echo '<span class="badge badge-secondary mx-1 fw-n">';
                                echo $this->html->link(
                                        'ش.ف:'.$temp['id'].' | مبلغ:'.$this->Number->format($temp['price']).' | پرداخت:'.
                                        ($temp['paid']==1?'پ.ش':'پ.نش').
                                        (isset($temp['coupons'])?' | کدتخفیف: '.strip_tags($temp['coupons']):'')
                                        ,
                                        '/admin/lms/factors/view/'.$temp['id'],
                                        ['title'=>'نمایش فاکتور']);
                                echo '</span>';
                            }
                        endif;?>

                    </div>
                </td>

                <!--- -------------------------------------------------------------- -->

                <td>
                    <div class="strip_tags">
                    <?php
                    if(isset($user['lms_payments'])):
                        foreach($user['lms_payments'] as $temp){
                            echo '<span class="badge badge-secondary mx-1 fw-n">';
                            echo $this->html->link(
                                    'ش.ف:'.$temp['lms_factor_id'].' | مبلغ:'.$this->Number->format($temp['price']).' | پرداخت:'.($temp['enable']==1?'پ.ش':'پ.نش').
                                    (isset($temp['lms_factor']['coupons'])?' | کدتخفیف: '.strip_tags($temp['lms_factor']['coupons']):''),
                                    '/admin/lms/payments/view/'.$temp['id'],
                                    ['title'=>'نمایش پرداخت']);
                            echo '</span>';
                        }
                    endif;?>

                    </div>
                </td>

                <!--- -------------------------------------------------------------- -->

                <!-- <td><?= h($user->email) ?></td>
                <td><?= h($user->phone) ?></td> -->
                <!-- <td><?= $user->has('role') ? $this->Html->link($user->role->title, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td> -->
                <td><?= $this->Func->date2($user->created) ?></td>

                <?php foreach($metalist as $mt):
                    echo '<td>'.((isset($meta[$mt]) and $meta[$mt]!= '')?$meta[$mt]:'').'</td>';endforeach;?>

            </tr>
            
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->Form->button(__('افزودن کاربر به دوره'),['class'=>'btn btn-sm btn-success']) ?>
<a class="btn btns btn-success btn-sm mx-1">خروجی جدول</a>
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
<?= $this->Form->end() ?>

<script nonce="<?=get_nonce?>">
$(document).ready(function(){
    $(".select-me").click(function(){
        $(this).parent().parent().parent().parent().find('.checkboxAll').each(function(){
            $(this).prop('checked', true);
        })
    });
});
</script>

<br><br><?= $this->element('Admin.paginate')?>


<style>.alert{font-size:13px;letter-spacing: -0.5px;}
.alert-light:hover{
    background:#CCC;
    color:#FFF;
}
.crt .table th, .crt .table td {
    padding: 0.72rem 1rem;
    vertical-align: middle;
}
table .badge {
    margin-bottom: 2px;
    
}
table .badge[class*='badge-'] a {
    white-space: initial;
    line-height: 18px;
}
</style>