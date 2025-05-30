<?php
$list = [];
if(isset($lmsCourse['options']) and $lmsCourse['options'] !="" and $lmsCourse['options'] !='""'){
    $lmsCourse['options'] = json_decode($lmsCourse['options'],true);
}
?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('مدیریت دوره') ?> "<?= $lmsCourse['title']?>"
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none">
    </div>
</div>

<div class="row">

    <div class="col-md-6"><div class="card"><div class="card-body">
        <?= $this->Form->create($lmsCourse) ?>
            <?= $this->Form->control('title',['label'=>'عنوان دوره','class'=>'form-control']);?>
            <hr style="border-color: #695fcd;">

                
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    $time = null;
                    if(isset($lmsCourse->date_start)){
                        if($this->Func->Optionget('admin_calender') != 1 ){
                            $time = date('Y/m/d',strtotime($lmsCourse->date_start->format('Y-m-d')));
                            $lmsCourse->date_start = $this->Func->mil_to_shm($time,'/') .' '. date('H:i:s',strtotime($lmsCourse->created->format('H:i:s')));
                        }
                        else $lmsCourse->date_start = date('Y/m/d H:i:s',strtotime($lmsCourse->date_start->format('Y-m-d H:i:s')));
                    }else{
                        if($this->Func->Optionget('admin_calender') != 1 ){
                            $lmsCourse->date_start = $this->Func->mil_to_shm(date('Y/m/d'),'/') .' '. date('H:i:s',strtotime(date('H:i:s')));
                        }
                        else $lmsCourse->date_start = date('Y/m/d H:i:s');
                    }
                    
                    echo $this->Form->control('date_start',[
                        'id'=>'pdpGregorian',
                        'style'=>'font-family: tahoma;',
                        'type'=>'text',
                        'label'=>'تاریخ شروع دوره','class'=>'form-control']);?>
                </div>
                <div class="col-sm-6">
                    <?php
                    $time = null;
                    if(isset($lmsCourse->date_end)){
                        if($this->Func->Optionget('admin_calender') != 1 ){
                            $time = date('Y/m/d',strtotime($lmsCourse->date_end->format('Y-m-d')));
                            $lmsCourse->date_end = $this->Func->mil_to_shm($time,'/') .' '. date('H:i:s',strtotime($lmsCourse->created->format('H:i:s')));
                        }
                        else $lmsCourse->date_end = date('Y/m/d H:i:s',strtotime($lmsCourse->date_end->format('Y-m-d H:i:s')));
                    }else{
                        if($this->Func->Optionget('admin_calender') != 1 ){
                            $lmsCourse->date_end = $this->Func->mil_to_shm(date('Y/m/d'),'/') .' '. date('H:i:s',strtotime(date('H:i:s')));
                        }
                        else $lmsCourse->date_end = date('Y/m/d H:i:s');
                    }
                    echo $this->Form->control('date_end',[
                        'id'=>'pdpGregorian2',
                        'style'=>'font-family: tahoma;',
                        'type'=>'text',
                        'label'=>'تاریخ پایان دوره','class'=>'form-control']);?>
                </div>

                <div class="col-sm-6">
                    <?= $this->Form->control('total_time',[
                        'label'=>'مجموع ساعات دوره',
                        'class'=>'form-control',
                        ]);?>
                </div>

                <div class="col-sm-6">
                    <?= $this->Form->control('lms_coursecategorie_id', [
                        'label'=>'دسته بندی',
                        'class'=>'form-control',
                        'options' => $lmsCoursecategories, 'empty' => '-- انتخاب کنید --']);?>
                </div>
            </div>
            <hr style="border-color: #695fcd;">

            
            <?php
            /* echo '
                <div class="alert alert-secondary">
                    در صورتی که تاریخ شروع و پایان دوره وارد نشود، محاسبه زمان آغاز بر اساس تاریخ اختصاص دوره برای کاربر محاسبه خواهد گردید
                </div>'; */

            echo $this->Form->control('date_type',['label'=>'نوع محاسبه تاریخ شروع دسترسی کاربر به دوره',
                'type'=>'select','class'=>'form-control',
                'options'=>[
                    1 =>'تاریخ ثبت دوره برای کاربر',
                    2 =>'تاریخ شروع مشخص شده برای دوره',
                ],
                ]);

                ?>
            <hr style="border-color: #695fcd;">
            <?= $this->Form->control('image',['label'=>'تصویر دوره / کاور','id'=>'image','placeholder'=>'http://','dir'=>'ltr','class'=>'form-control']);?>
        </div></div>

        <div class="card"><div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Form->control('price',[
                        'label'=>'مبلغ دوره (تومان)','class'=>'form-control ltr','type'=>'number']);?>
                    <div class="alert alert-primary small" style="margin-top:-20px;">
                        در صورتی که مبلغ 0 (صفر یا خالی) باشد، دوره بصورت رایگان ثبت نام و نمایش داده خواهد شد.
                    </div>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('price_special',[
                        'label'=>'مبلغ قبلی دوره',
                        'type'=>'number','class'=>'form-control ltr']);?>
                    <div class="alert alert-primary small" style="margin-top:-20px;">
                        قیمت قبلی مشخص شده بصورت خط خورده نمایش داده شده و مبلغ دوره نمایش داده می شود</div>
                </div>
            </div>
        </div></div>

        <div class="card"><div class="card-body">
            <h2>تنظیمات نمایشی فیلدها سایت</h2>  
            <div class="roles"> 
            <?php 
            $this->Form->setTemplates([
                'nestingLabel' => '<label{{attrs}}><div class="custom-control custom-checkbox">{{text}}{{hidden}}{{input}}</div></label>',
                //'formGroup' => '{{input}}{{label}}',
                //'input' => '<input type="{{type}}" name="{{name}}" data-error-message="{{customValidityMessage}}" {{attrs}}/>',
                'checkbox' => '<input type="checkbox" name="{{name}}" class="custom-control-input" value="{{value}}"{{attrs}}>'
            ]);
            $roles = [
                'price' => 'قیمت دوره ',
                'register' => 'کلید ثبت نام',
                'descr' => 'کلید نمایش توضیحات',
                'course_file' => 'کلید لیست دروس',
                'course_time' => 'باکس مدت دسترسی',
                'course_related' => 'باکس دروس پیش نیاز',
                'course_gam' => 'باکس گام ها',
                'total_time' => 'مجموع ساعات دوره',
            ];            
            echo $this->Form->select(
                'options.roles', 
                $roles, [
                    'multiple' => 'checkbox',
                    'default'=>isset($list['roles'])?$list['roles']:null,
                    'class'=>'form-control'
                ]);
            ?>
            </div>

            <style>
            .roles .checkbox{
                width: 50%;
                float: right;
            }
            .custom-checkbox .custom-control-input, .custom-radio .custom-control-input {
                width: 1.085rem;
                height: 1.285rem;
            }
            .custom-control-input {
                opacity: 1;
                /* margin-top: -22px; */
            }
            </style>
        </div></div>

        <div class="card"><div class="card-body">
            <?= $this->Form->control('text',[
                'style'=>'min-height:200px;',
                'label'=>'توضیحات مختصر / کوتاه','class'=>'form-control']);?>
        </div></div>

    </div>

    <div class="col-md-6">
        <div class="card"><div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Form->control('priority',['label'=>'اولویت نمایش ( عدد)','class'=>'form-control']);?>
                </div>
                
                <div class="col-sm-6">
                    <?= $this->Form->control('enable',['label'=>'وضعیت','options'=>['غیرفعال','فعال'],'class'=>'form-control']);?>
                </div>

                <div class="col-sm-12 p-0"><hr style="border-color: #695fcd;"></div>

                <div class="col-sm-6">
                    <?= $this->Form->control('show_in_list',[
                        'label'=>'نمایش در سایت',
                        'options'=> $this->Func->Predata('yesno'),
                        'class'=>'form-control']);?>
                    <div class="alert alert-primary small px-0 text-center" style="margin-top:-20px;">
                    نمایش در لیست دوره سایت</div>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('can_add',[
                        'label'=>'امکان ثبت نام دوره',
                        'options'=> $this->Func->Predata('yesno'),
                        'class'=>'form-control']);?>

                    <div class="alert alert-primary small px-0 text-center" style="margin-top:-20px;">
                        کاربر بتواند دوره را ثبت نام کند</div>
                </div>
                
                <div class="col-sm-12 p-0"><hr style="border-color: #695fcd;"></div>
                
                <div class="col-sm-12">
                    <?= $this->Form->control('options.unlimit_access',[
                        'label'=>'دسترسی دائمی کاربران',
                        'options'=>$this->Func->Predata('yesno'),
                        'class'=>'form-control']);?>
                    <div class="alert alert-primary small px-1" style="margin-top:-20px;">
                    کاربران تا زمانی که دوره منقضی نشده است، حتی اگر دوره را به پایان رسانده باشند، بازهم به دوره دسترسی داشته باشند</div>
                </div>

            </div>
        </div></div>

        <div class="card"><div class="card-body">
            <div class="row">

                <div class="col-sm-12"><h2>مشخصات تمدید</h2></div>
                
                <div class="col-sm-12">
                    <?= $this->Form->control('can_renew',[
                        'label'=>'امکان تمدید دوره',
                        'options'=>$this->Func->Predata('yesno'),
                        'class'=>'form-control']);?>
                    <div class="alert alert-primary small px-0 text-center" style="margin-top:-20px;">
                        کاربر بتواند دوره را تمدیدکند  / نمایش کلید تمدید دوره</div>
                </div>

                <div class="col-sm-12">
                    <hr style="border-color: #695fcd;">
                    <h5>تمدید پیشفرض</h5>
                    <small class="text-white fw-bold badge badge-light-danger mb-1">
                     در صورتی که پیشفرض خالی باشد بر اساس بازه زمانی نمایش داده می شود</small>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('renew_day',['label'=>'تعداد روزهای تمدید','class'=>'ltr form-control']);?>
                    <div class="alert alert-primary small px-1" style="margin-top:-20px;">
                        بعد از تمدید، کاربر چند روز به دوره دسترسی داشته باشد؟</div>
                </div>

                <div class="col-sm-6">
                <?= $this->Form->control('price_renew',['label'=>'مبلغ تمدید -فقط عدد','class'=>'ltr form-control']);?>
                    <div class="alert alert-primary small px-0 text-center" style="margin-top:-20px;">
                    عدد هنگام ایجاد فاکتور لحاظ می شود</div>
                </div>
               
                <div class="col-sm-12">
                    <hr style="border-color: #695fcd;">
                    <h5>تمدید بر اساس بازه زمانی</h5>
                    <small class="text-white fw-bold badge badge-light-danger">
                        - در صورتی که "عنوان تمدید" خالی باشد، آن سطر نمایش داده نمی شود
                    </small>
                    <small class="text-white fw-bold badge badge-light-danger mb-2">
                        - مبلغ تمدید نمیتواند صفر باشد
                    </small>
                </div>
                
                <?php foreach([1,2,3,6,12] as $month):
                    echo $this->Form->control('options.renew.'.$month.'m_day',[
                        'type'=>'hidden',
                        'value' =>$month ]);?>
                <div class="col-sm-6">
                    <?= $this->Form->control('options.renew.'.$month.'m_title',[
                        'type'=>'text',
                        'label'=>'عنوان تمدید '.$month.' ماهه',
                        'class'=>'form-control']);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('options.renew.'.$month.'m_price',[
                        'type'=>'number',
                        'label'=>'مبلغ تمدید (فقط عدد)',
                        'class'=>'form-control ltr']);?>
                </div>
                <?php endforeach?>
                

                
            </div>
        </div></div>
            
        
    </div>

    <div class="col-sm-12"><div class="card"><div class="card-body">
        <?php 
            echo $this->Form->control('textweb',[
                'label'=>'توضیحات اصلی','class'=>'form-control',
                'type'=>'textarea','id'=>'pubEditor']);
        ?>
    </div></div></div>

    <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
<style>.input{margin-bottom:20px;}</style>

<script nonce="<?=get_nonce?>">//https://behzadi.github.io/persianDatepicker/
    $("#pdpGregorian").persianDatepicker({ 
        //formatDate: "YYYY/0M/0D hh:mm:ss",
        formatDate: "YYYY/0M/0D 0h:0m:0s",
        fontSize: 13, // by px
        selectableMonths: [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12],
        persianNumbers: !0,
        isRTL: !1,  //  isRTL:!0 => because of persian words direction
        //onSelect: function () {alert('asd')},
        showGregorianDate: <?=$this->Func->Optionget('admin_calender') == 1?'true':'false'?> 
    });
    $("#pdpGregorian2").persianDatepicker({ 
        //formatDate: "YYYY/0M/0D hh:mm:ss",
        formatDate: "YYYY/0M/0D 0h:0m:0s",
        fontSize: 13, // by px
        selectableMonths: [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12],
        persianNumbers: !0,
        isRTL: !1,  //  isRTL:!0 => because of persian words direction
        //onSelect: function () {alert('asd')},
        showGregorianDate: <?=$this->Func->Optionget('admin_calender') == 1?'true':'false'?> 
    });
</script>