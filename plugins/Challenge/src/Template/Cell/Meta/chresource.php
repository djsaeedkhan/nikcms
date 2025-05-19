<?php
$this->Func->getSiteSetting();
$setting = setting;
?>
<div class="box ">
    <div class="card-body">
        <?= $this->Form->control('PostMetas.download_link',[
            'class'=>'form-control mb-3',
            'label'=> 'آدرس لینک',
            'id'=>'header1_img',
            'dir'=>'ltr','placeholder'=>'http://','type'=>'text',
            'default'=>(isset($post_meta_list['download_link'])?$post_meta_list['download_link']:''),
            ]);?>
            <div class="mb-3" style="margin-top: -43px;float: right;margin-right: 10px;">
            <a href="/" data-toggle="modal" data-target="#exampleModal" data-action="select_src" title="انتخاب فایل" data-dest="header1_img" style="color:#9e9e9e"><i data-feather="camera"></i></a></div>
    </div>
</div>

<div class="box d-none">
    <div class="card-body">
        <?php
        echo $this->Form->control('PostMetas.challenge_id',[
            'class'=>'form-control mb-3',
            'label'=>'آیدی '.__d('Template', 'همیاری').'',
            'type'=>'text',
            'default'=>(isset($post_meta_list['challenge_id'])?$post_meta_list['challenge_id']:
                    (isset($this->request->getQuery()['challenge_id'])?$this->request->getQuery()['challenge_id'] : 0)
                ),
            ]);
        ?>
    </div>
</div>