<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Postviews','آمار بازدید مطالب');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link(__d('Postviews','آمار پست تایپ'),
                            ['?'=>['type'=>'post_type']],
                            ['class'=>'btn btn-sm btn-primary'])?>
                        &nbsp;
                        <?= $this->html->link(__d('Postviews','آمار نوشته ها'),
                            ['?'=>['type'=>'post']],
                            ['class'=>'btn btn-sm btn-primary'])?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
switch ($this->request->getQuery("type")) {
    case 'post_type':
        include_once("post_type.php");
        break;
    
    default:
    include_once("post_list.php");
        break;
}?>