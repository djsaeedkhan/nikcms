<?php

use Admin\View\Helper\ModuleHelper;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

echo $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
try {
    if($result and $result != ""):
        $hsite = unserialize($result);
        $this->request->withData('plugin_scheduler',$hsite);
        @$this->request->data['plugin_scheduler'] = $hsite;
    endif;
} catch (\Throwable $th) {
    echo "تنظیمات دریافت نشد";
}
?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('مدیریت زمانبندی فرآیندها');?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="row">
        <div class="col-sm-2">
            <?= $this->Form->control('plugin_scheduler.enable' , [
                'label'=> 'وضعیت', 'type'=>'select','options'=>[
                    1 => 'فعال',
                    0 => 'غیرفعال',
                ],'class'=> 'form-control']);?>
        </div>    
        <div class="col-sm-5 ltr"style="text-align: left;"><br>
            Calling address:<br>
            <b><?= Router::url('/dowithcronjobs/',true);?></b>
        </div>
        <div class="col-sm-3 ltr" style="text-align: left;"><br>
            Repeat Time Interval: <br>
            <b>Every 5 Mins</b>
        </div>
        
        <div class="col-sm-2 ltr" style="text-align: left;"><br>
            <?= $this->Form->submit('ثبت اطلاعات',['class'=>'btn btn-success btn-sm col-xs-3']);?>
        </div>
    </div>
    <?=$this->Form->end();?>
</div></div>

<hr><br>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h3 class="content-header-title float-right mb-0">
                    <?= __('لیست فرایند ها');?>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">نام پلاگین</th>
                <th scope="col">وضعیت</th>
                <th scope="col">آخرین اجرا شده</th>
                <th scope="col">اجرای بعدی</th>
                <th scope="col">خروجی آخرین اجرا</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $results = TableRegistry::get('Scheduler.Cronjobs')->find('all')->toarray();
            $i = 1;
            $crons  = (array) ModuleHelper::register_cronjobs();
            foreach ($results as $res):?>
            <tr>
                <td><?= $i++?></td>
                <td style="direction: ltr;"><?= $res['plugin']?> => <?= $res['name']?></td>
                <td><?=$res->status == 1?
                    '<span class="badge badge-success">درحال اجرا</span>':
                    '<span class="badge badge-danger">غیرفعال</span>'?></td>
                <td style="direction: ltr;font-family:tahoma"><?= ($res->created->format('Y/m/d H:i:s')) ?></td>
                <td style="direction: ltr;font-family:tahoma"><?php
                    foreach($crons as $cron){
                        if($cron['name'] == $res['name'] and $cron['plugin'] == $res['plugin']){
                            $sdate = new Time($res['created']);
                            $sdate->modify('+'. $cron['every']);
                            echo $sdate->format('Y/m/d H:i:s')."<br>";
                            echo 'Repeat :Every '.$cron['every'];
                        }
                    }
                ?></td>
                <td class="p-0">
                    <textarea 
                        class="form-control form-control-sm"
                        style="font-size:14px;text-align:right;direction:rtl;min-height: 150px;font-size:12px;padding: 5px !important;
                                line-height: 15px;"
                    ><?= str_replace('<br>',"\n\n",$res->result)?></textarea>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>