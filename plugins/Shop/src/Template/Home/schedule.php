<?php

use Cake\I18n\Time;
use Shop\View\Helper\CartHelper;
use Shop\Predata;
$predata = new Predata;
$setting = unserialize($this->Func->OptionGet('plugin_shop'));
$p_label2 = CartHelper::Predata('currency',$setting['currency']);
?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    زمان بندی ارسال
                </h2>
            </div>
        </div>
    </div>
</div>


<?= $this->Form->create(null,[
        'url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting'],
        'class'=>'col-sm-12']);
    if(isset($result['plugin_schedule']) and count($result)):
        $hsite = unserialize($result['plugin_schedule']);
        $this->request->withData('plugin_schedule',$hsite);
        @$this->request->data['plugin_schedule'] = $hsite;
    endif;?>


<div class="nav-vertical shop_transport">
    <ul class="nav nav-tabs nav-left flex-column" role="tablist" style="height: 140px;">
        <!-- <li class="nav-item">
            <a class="nav-link" id="bleft-tab1" data-toggle="tab" aria-controls="tableft1" href="#tableft1" role="tab" aria-selected="false">
                تنظیمات
            </a>
        </li> -->
        
        <li class="nav-item">
            <a class="nav-link" id="bleft-tab2" data-toggle="tab" aria-controls="tableft2" href="#tableft2" role="tab" aria-selected="false">
                روزهای کاری 
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="bleft-tab3" data-toggle="tab" aria-controls="tableft3" href="#tableft3" role="tab" aria-selected="false">
                روزهای تعطیلی
            </a>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link" id="bleft-tab4" data-toggle="tab" aria-controls="tableft4" href="#tableft4" role="tab" aria-selected="false">
                محاسبه مکان ارسال
            </a>
        </li> -->

        <br>
        <?= $this->Form->submit('ذخیره تغییرات',['class'=>'btn btn-success btn-sm col-xs-12 mb-3']);?>

    </ul>
    <div class="tab-content">
        <!-- ----------------------------------------------------- -->
        <div class="tab-pane" id="tableft1" role="tabpanel" aria-labelledby="bleft-tab1">
            <div class="row">
                <?php $this->Form->control("plugin_schedule.setting.count",[
                    'label'=>'حداکثر تعداد سفارش روزانه',
                    'type'=>'number',
                    'class'=> 'form-control form-control-sm ltr']);?>
            </div>

            <!-- <div class="row"><div class="col-12">
                <?php $this->Form->control("plugin_schedule.order.province_inside",[
                    'label'=>'حداکثر سفارش داخل استان',
                    'type'=>'number','placeholder'=>'فقط عدد',
                    'class'=> 'form-control form-control-sm col-3 ltr mb-1']);?>
                    <div class="clearfix"></div>

                <?php $this->Form->control("plugin_schedule.order.province_near",[
                    'label'=>'حداکثر سفارش استان همجوار',
                    'type'=>'number','placeholder'=>'فقط عدد',
                    'class'=> 'form-control form-control-sm col-3 ltr mb-1']);?>
                    <div class="clearfix"></div>

                <?php $this->Form->control("plugin_schedule.order.province_other",[
                    'label'=>'حداکثر تعداد سفارش',
                    'type'=>'number','placeholder'=>'فقط عدد',
                    'class'=> 'form-control form-control-sm col-3 ltr mb-1']);?>
            </div></div> -->

        </div>
        <div class="tab-pane" id="tableft2" role="tabpanel" aria-labelledby="bleft-tab2">
            <div class="row">
                <?php
                $lists = [
                    0 =>'شنبه',
                    1 =>'یکشنبه',
                    2 =>'دوشنبه',
                    3 =>'سه شنبه',
                    4 =>'چهارشنبه',
                    5 =>'پنج شنبه',
                    6 =>'جمعه',
                ];?>
                <div class="table-responsive">
                    <div class="alert alert-primary">
                        - سفارشات پس از "ساعت پایان ثبت سفارش"، به روز کاری بعدی منتقل خواهد شد.
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td>روز هفته</td>
                                <td>وضعیت روز کاری</td>
                                <td>ساعت شروع ثبت سفارش</td>
                                <td>ساعت پایان ثبت سفارش</td>
                            </tr>
                            <?php foreach($lists as $k=>$list):?>
                                <tr>
                                    <td>
                                        <b><?= $list;?></b>
                                    </td>
                                    <td>
                                        <?= $this->Form->control("plugin_schedule.work.{$k}.enable",[
                                        'label'=>false,
                                        'options'=>[
                                            0 =>'غیرفعال',
                                            1 =>'فعال'],
                                        'class'=> 'form-control form-control-sm']);?>
                                    </td>
                                    <td>
                                        <?= $this->Form->control("plugin_schedule.work.{$k}.start",[
                                        'label'=>false,
                                        'maxlength'=>'5',
                                        'placeholder'=>'00:00',
                                        'class'=> 'form-control form-control-sm ltr']);?>
                                    </td>
                                    <td>
                                        <?= $this->Form->control("plugin_schedule.work.{$k}.end",[
                                        'label'=> false,
                                        'maxlength'=>'5',
                                        'placeholder'=>'00:00',
                                        'class'=> 'form-control form-control-sm ltr']);?>
                                    </td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                    
                </div>

            </div>
        </div>
        <!-- ----------------------------------------------------- -->
        <div class="tab-pane" id="tableft3" role="tabpanel" aria-labelledby="bleft-tab3">
            <div class="row">
                <div class="table-responsive">
                    <div class="alert alert-primary">
                        - ترتیب روز ها الزامی نیست<br>
                        - دو رکورد تعطیل برای یک روز ثبت نشود<br>
                        - در روز های مشخص شده، ثبت سفارش انجام نمی شود<Br>
                        - روز های جمعه بصورت جداگانه محاسبه می شود و نیازی به ثبت در این بخش نیست<Br>
                        - در صورتی که عنوان خالی باشد، عبارت "تعطیلی رسمی" نمایش داده می شود<Br>
                    </div>

                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td>ردیف / روز</td>
                                <td>تاریخ</td>
                                <!-- <td>روز گذشته آغاز سال</td> -->
                                <td>عنوان تعطیلی</td>
                            </tr>
                            <?php 
                            $time = new Time('2021-03-21');
                            for($i = 1;$i<366;$i++):?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?= jdate('Y/m/d',strtotime($time->format('Y/m/d')))?></td>
                                    <?= $this->Form->control("plugin_schedule.holiday.{$i}.date",[
                                        'label'=>false,
                                        'type'=>'hidden',
                                        'default'=>($i - 1),
                                        'class'=> 'form-control form-control-sm']);?>
                                    <td>
                                        <?= $this->Form->control("plugin_schedule.holiday.{$i}.title",[
                                        'label'=>false,
                                        'class'=> 'form-control form-control-sm']);?>
                                    </td>
                                </tr>
                            <?php 
                            $time->addDays(1);
                            endfor;?>
                        </tbody>
                    </table>
                    
                </div>

            </div>
        </div>
        <!-- ----------------------------------------------------- -->
        <!-- <div class="tab-pane" id="tableft4" role="tabpanel" aria-labelledby="bleft-tab4">
            <div class="row mb-1">
                <div class="col-sm-3" style="padding-top: 8px;">
                    داخل استان (فروشگاه)
                </div>
                <div class="col-sm-3">
                    <?php $this->Form->control('plugin_schedule.province.province_inside',[
                        'Placeholder'=>'روز (عدد)',
                        'label'=>false,
                        'type'=>'number',
                        'class'=> 'form-control form-control-sm1 ltr' ]);?>
                </div>
            </div>
            
            <div class="row mb-1">
                <div class="col-sm-3" style="padding-top: 8px;">
                    استان همجوار (فروشگاه)
                </div>
                <div class="col-sm-3">
                    <?php $this->Form->control('plugin_schedule.province.province_near',[
                        'Placeholder'=>'روز (عدد)',
                        'label'=>false,
                        'type'=>'number',
                        'class'=> 'form-control form-control-sm1  ltr' ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3" style="padding-top: 8px;">
                    سایر استان ها
                </div>
                <div class="col-sm-3">
                    <?php  $this->Form->control('plugin_schedule.province.province_other',[
                        'Placeholder'=>'روز (عدد)',
                        'label'=>false,
                        'type'=>'number',
                        'class'=> 'form-control form-control-sm1  ltr' ]);?>
                </div>
            </div>
        </div> -->
        <!-- ----------------------------------------------------- -->

    </div>
</div>


<?php 
//echo $this->Form->submit('ذخیره تغییرات',['class'=>'btn btn-success col-xs-3 mb-3']);
echo $this->Form->end();?>

<style>
.shop_transport .nav-item svg{margin:0;}
.nav-vertical .nav.nav-tabs.nav-left ~ .tab-content .tab-pane {
    overflow-y: initial !important;    }
    </style>