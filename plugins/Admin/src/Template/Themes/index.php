<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                   <?= __d('Admin', 'پوسته ها')?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="row">
        <?php $theme = false;
        foreach ($result as $res):if(isset($res['template'])):if($template == $res['template']['slug']):
        $theme = true;?>
        <div class="col-sm-6">
            <?= $this->html->image($res['template']['image'],
                ['style' =>"width:100%;border:1px solid #ccc; padding:10px;"])?>
            
            <?php /* echo $this->html->image($url,[
                'alt'=>$theme_profile['title'],
                'class'=>'img-responsive',
                'draggable'=>"false",
                'style'=>'width:100%;border:1px solid #ccc; padding:10px;']); */?>
        </div>
        <div class="col-sm-6 col">
            <h5><label>
                <?= __d('Admin', 'نام قالب')?> :</label> 
                <span class="badge badge-dark f6"><?= $res['template']['name'];?></span>
            </h5>
            <h5>
                <span class="f6"><?= $res['template']['info'];?></span>
            </h5>
            <h5>
                <label><?= __d('Admin', 'ورژن')?>:</label> 
                <span class="f6"><?= $res['template']['version'];?></span>
            </h5>
            <h5>
                <label><?= __d('Admin', 'سازنده')?> :</label> 
                <span class="f6"><?= $res['template']['author'];?></span>
            </h5>
            <br><br><br>

            <?php echo $this->Auths->link(
                __d('Admin', 'مدیریت فهرست ها'),
                '/admin/themes/Menu',[
                    'class'=>'btn btn-primary'
                ]);?>

            <?php echo $this->Auths->link(
                __d('Admin', 'تنظیمات قالب'),
                '/admin/themes/template',[
                    'class'=>'btn btn-primary']);?>

        </div>
        <?php endif;endif;endforeach;
        if($theme == false)
        echo '<div class="col-sm-12">'.__d('Admin', 'هنوز قالبی انتخاب نشده است').'</div>';
        ?>
    </div>
</div></div>

<div class="clearfix"></div>
<div class="row">
    <?php foreach ($result as $res):if(isset($res['template'])):?>
        <div class="col-sm-4"><div class="box" style="padding: 3px;">

            <?= $this->html->image($res['template']['image'],
                ['class'=>"img-responsive img-thumbnail",'draggable'=>"false",'style'=>"padding:0px;"])?>
            <div class="clearfix"></div>

            <div class="alert-warning text-center" style="padding:10px;">
                <div style="padding:10px;">
                    <?= __d('Admin', 'نام قالب')?>: 
                    <b><?= $res['template']['name'];?></b>
                </div>

                <div class="clearfix"></div>
                <?php if($template == $res['template']['slug']):
                    echo __d('Admin', 'فعال است');
                else:
                $theme='123';
                echo $this->Form->postlink(
                    __d('Admin', 'فعال سازی'),
                    ['theme'=>$res['template']['slug']],
                    ['class'=>'btn btn-success col-xs-6 col-xs-offset-3',
                        'confirm'=>__d('Admin', 'موافق هستید؟') ]);
                endif;?>
                <div class="clearfix"></div>
            </div>
        </div></div>
    <?php endif;endforeach;?>
    <style>
        .col label{min-width:80px;}
        .col h5{font-size:23px;}
        .f6{font-size:14px;}
    </style>
</div>