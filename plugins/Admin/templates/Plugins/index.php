<?php $list = ['danger','primary','secondary','success','warning'];?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'مدیریت افزونه ها');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link(__d('Admin', 'بروزرسانی دیتابیس'),
                            ['action'=>'execute'],
                            ['class'=>'btn btn-sm btn-primary mr-1']);?>

                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php 
    $exc = (\Admin\View\Helper\ModuleHelper::excplgn());
    foreach ($result as $data):if($data != NULL and !isset($data['show'])):
        if(! in_array($data['name'],$exc)):?> 

        <div class="col-lg-12 col-md-6 col-sm-12"><div class="card cart1">
            <div class="p-2 mb-0 <?= (is_array($plugin_available) and in_array($data['name'],$plugin_available))?'':'alert alert-danger';?>">

                <div class="avatar bg-light-<?=$list[rand(0,4)]?> avatar-xl float-right" style="border-radius: 0;margin-left: 15px;">
                    <span class="avatar-content"><?=substr($data['name'],0,2)?></span>
                </div>

                <!-- <?= $this->html->image('/admin/img/avatars/6.jpg',[
                    'class'=>'float-right img-thumbnail img-rounded', 
                    'style'=>'width:60px;padding: 0.15rem;margin-left:10px;border-width: 0px;']);?> -->

                <div class="float-left">
                    <div class="float-right">
                        <?php
                        if( is_array($plugin_available) and in_array($data['name'],$plugin_available)):
                            if(isset($data['path']['index']) and $data['path']['index']!= '') 
                                echo $this->Auths->link(
                                    __d('Admin', 'صفحه افزونه'),
                                    $data['path']['index'],['class'=>'mr-11 badge1 badge-primary1']);

                            if(isset($data['path']['admin']) and $data['path']['admin']!= '') 
                                echo $this->Auths->link(
                                    __d('Admin', 'مدیریت'),
                                    $data['path']['admin'],['class'=>'mr-11 badge1 badge-primary1']);

                            if(isset($data['path']['setting']) and $data['path']['setting']!= '') 
                                echo $this->Auths->link(
                                    __d('Admin', 'تنظیمات'),
                                    $data['path']['setting'],['class'=>'mr-11 badge1 badge-primary1']);
                        endif;
                        ?>
                    </div>
                    <div class="float-left">
                        <?php
                        echo ((is_array($plugin_available) and in_array($data['name'],$plugin_available) )?
                            $this->Form->postlink('<span class="badge1 text-danger">غیرفعال شود</span>',
                                ['action'=>'Enable',$data['name'],'disable'],
                                ['escape'=>false,
                                    'confirm'=>__d('Admin', 'مایلید این پلاگین را غیرفعال کنید؟').
                                        "\n".
                                        __d('Admin', 'در صورت حذف، اطلاعات و جداول نیز حذف خواهند شد.')
                                ]):

                            $this->Form->postlink('<span class="badge badge-success">'.__d('Admin', 'فعال شود').'؟</span>',
                                ['action'=>'Enable',$data['name']],
                                ['escape'=>false,]));
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="mb-2">
                <?php
                if(!in_array($data['name'],['Predata','Admin','Template','Website'])){
                    echo ($plugin_favorite and in_array($data['name'],$plugin_favorite))?
                            $this->html->link(
                                '<i data-feather="star" class="text-warning" style="fill: #FF9F43;margin-top: -5px;"></i>',
                                ['?'=>['remove'=>$data['name'] ]],
                                ['escape'=>false,
                                    'title'=>__d('Admin', 'حذف از علاقه مندی ها'), 
                                    'data-toggle'=>"tooltip",'data-placement'=>"top"])
                            :
                            $this->html->link(
                                '<i data-feather="star" class="text-warning" style="margin-top: -5px"></i>',
                                ['?'=>['add'=>$data['name'] ]],
                                ['escape'=>false,'title'=>__d('Admin', 'افزودن به علاقه مندی ها'), 'data-toggle'=>"tooltip",'data-placement'=>"top"]);
                                
                }
                ?>
                    <?= __d('Admin', 'افزونه')?>
                    <b><?php echo $data['title'];?></b>
                    <?php //(isset($data['sys']) and $data['sys'] == true)?'<div class="badge badge-warning">سیستمی</div>':''?>
                </div>
                <div class="">
                    <?= (isset($data['description']) and $data['description'] !='')?
                        //'توضیحات: '.
                        $data['description'].'&nbsp;<b>|</b>&nbsp;':
                        ''; ?>

                    <?= (isset($data['author']) and $data['author'] !='')?
                        __d('Admin', 'توسط').': '.$data['author'].'&nbsp;<b>|</b>&nbsp;':
                        ''; ?>
                    <?= __d('Admin', 'نگارش')?>: <?php echo $data['version'];?>
                    
                </div>
                <!-- <div class="clearfix"></div><hr> -->
                
                <div class="clearfix"></div>
            </div>
        </div></div>
    <?php endif;endif;endforeach; ?> 
</div>
<style>
    .col label{min-width:80px;}
    .col h5{font-size:23px;}
    .f6{font-size:14px;}
    .badge{font-weight:normal !important;font-size:13px;}
    .float-right a:after{
        content:' | ';
    }
</style>