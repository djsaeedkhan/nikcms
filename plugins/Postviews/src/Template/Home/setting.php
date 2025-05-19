<?php
echo $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(count($result)):
    $hsite = unserialize($result['postviews_plugin']);
    $this->request->withData('postviews_plugin',$hsite);
    @$this->request->data['postviews_plugin'] = $hsite;
endif;
?>
<h3 class="pb-2"><?= __d('Postviews','افزونه بازدید مطالب');?></h3>

<div>
    <!-- <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" 
                aria-selected="true">لیست عنوان ها</a>
        </li>
    </ul> -->
    <div class="tab-content">
        <div class="tab-pane active show col-sm-6" id="home" role="tabpanel">
            <?php
            $arr = [
                'title_view0'=>__d('Postviews','عنوان بدون بازدید'),
                'title_view1'=>__d('Postviews','عنوان یک بازدید'),
                'title_view2'=>__d('Postviews','عنوان بازدید'),
            ];
            foreach($arr as $a=>$t)
                echo $this->Form->control('postviews_plugin.'.$a , [
                    'label'=> $t, 'class'=> 'form-control mb-3',
                ]);?>
        </div>
        <div class="tab-pane col-sm-12" id="profile" role="tabpanel"></div>
    </div>
    <br><?= $this->Form->submit(
        __d('Postviews','ثبت اطلاعات'),
        ['class'=>'btn btn-success col-xs-3 mt-10'])?><br><br>
</div>
<?= $this->Form->end()?>