<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= $result->id==''?__d('Tinyurl','ثبت جدید'):__d('Tinyurl','به روز رسانی');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link(
                            __d('Tinyurl','برگشت به صفحه اصلی'),
                            ['action'=>'index'],
                            ['class'=>'btn btn-sm label-secondary']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <?php
    echo $this->Form->create($result,[
        'class'=>'col-sm-6']);
        
    echo $this->Form->control('title',[
        'type'=>'text',
        'label'=>__d('Tinyurl','عنوان لینک'),
        'class'=>'form-control mb-1']);

    echo $this->Form->control('slug',[
        'type'=>'text',
        'label'=>__d('Tinyurl','نامک لینک'),
        'class'=>'form-control mb-1',
        'dir'=>'ltr']);

    echo $this->Form->control('link',[
        'type'=>'text',
        'label'=>__d('Tinyurl','آدرس مقصد'),
        'class'=>'form-control mb-1',
        'dir'=>'ltr']);

    echo $this->Form->control(__d('Tinyurl','ثبت اطلاعات'),[
        'type'=>'submit',
        'class'=>'btn btn-success']);

    echo $this->Form->end();
    ?>
</div></div>