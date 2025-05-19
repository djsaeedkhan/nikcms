<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?=__d('Formbuilder', 'ویرایش فرم ساز');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create($result,['id'=>'forms']) ?>

<div class="float-left">
    <?= $this->Form->button(__d('Formbuilder', 'ثبت اطلاعات'),['class'=>'btn btn-success','style'=>'margin-right:14px;']);?>
    <a class="btn btn-info export_html d-none">Export HTML</a>
</div>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" 
            aria-controls="home" aria-selected="true">
        <?= $this->Form->control('title',[
            'label' => false,
            'placeholder' => __d('Formbuilder', 'عنوان فرم جدید'),
            'type'=>'text']);?>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" 
            aria-selected="false" style="padding: 11px;">
            <?=__d('Formbuilder', 'تنظیمات فرم ساز')?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#style" role="tab" aria-controls="style" 
            aria-selected="false" style="padding: 11px;">
            <?=__d('Formbuilder', 'استایل اضافه')?></a>
    </li>
</ul>


<div class="tab-content">
    <div class="tab-pane active show" id="home" role="tabpanel">
        <?= $this->Form->control('formbuilder_items.0.data',[
            'type'=>'textarea',
            'label'=>__d('Formbuilder', 'کدهای Html فرم ساخته شده'),
            'class'=>'ltr form_exported form-control',
            'rows'=>50])?>
    </div>

    <div class="tab-pane" id="style" role="tabpanel">
        <div class="card"><div class="card-body">
            <?= $this->Form->control('formbuilder_items.0.css',[
                'type'=>'textarea',
                'class'=>'ltr form-control',
                'rows'=>20])?>
        </div></div>
    </div>
    
    <div class="tab-pane" id="profile" role="tabpanel">
        <div class="row">
            <div class="col-sm-6">
                <div class="card"><div class="card-body">
                <?php 
                $this->Form->control('password',[
                    'type'=>'text',
                    'class'=>'ltr form-control mb-1']);

                echo $this->Form->control('action',[
                    'label'=>__d('Formbuilder', 'نحوه ذخیره اطلاعات'),
                    'type'=>'select',
                    'empty' =>'-- '.__d('Formbuilder', 'انتخاب کنید').' --',
                    'options'=>[
                        'db' =>__d('Formbuilder', 'ذخیره در دیتابیس'), 
                        'email'=>__d('Formbuilder', 'ارسال بصورت ایمیل'), 
                        'all'=>__d('Formbuilder', 'هردو - ذخیره و ایمیل')
                    ],
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('alert',[
                    'label'=>__d('Formbuilder', 'نحوه اطلاع رسانی'),
                    'type'=>'select',
                    'empty' =>'-- '.__d('Formbuilder', 'انتخاب کنید').' --',
                    'options'=>[
                        1 =>__d('Formbuilder', 'ارسال ایمیل اطلاع رسانی'),
                        0 =>__d('Formbuilder', 'عدم ارسال ایمیل اطلاع رسانی')
                    ],
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('enable',[
                    'label'=>__d('Formbuilder', 'وضعیت'),
                    'type'=>'select',
                    'empty' =>'-- '.__d('Formbuilder', 'انتخاب کنید').' --',
                    'class'=>'form-control mb-1',
                    'options'=>[ 
                        1 =>__d('Formbuilder', 'فعال'), 
                        0 =>__d('Formbuilder', 'غیرفعال')
                    ]]);

                echo $this->Form->control('emails',[
                    'label'=>__d('Formbuilder', 'آدرس ایمیل اطلاع رسانی'),
                    'type'=>'email',
                    'class'=>'ltr form-control mb-1']);
                ?>
                </div></div>
                <div class="card"><div class="card-body">

                <?php
                echo $this->Form->control('formbuilder_items.0.logo',[
                    'type'=>'text',
                    'label'=>__d('Formbuilder', 'تصویر لوگو بالای صفحه'),
                    'class'=>'ltr form-control mb-1']);

                echo $this->Form->control('formbuilder_items.0.footer',[
                    'type'=>'text',
                    'label'=>__d('Formbuilder', 'متن فوتر'),
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('formbuilder_items.0.submit',[
                    'type'=>'text',
                    'label'=>__d('Formbuilder', 'متن کلید ثبت'),
                    'class'=>'form-control mb-1']);
                ?>
                </div></div>
            </div>

            <div class="col-sm-6 mb-1">
                <div class="card"><div class="card-body">
                <?php 
                echo $this->Form->control('formbuilder_items.0.uinfo',[
                    'type'=>'textarea',
                    'label'=>__d('Formbuilder', 'توضیحات فرم'),
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('formbuilder_items.0.smstext',[
                    'type'=>'textarea',
                    'label'=>__d('Formbuilder', 'متن پیامک'),
                    'class'=>'form-control mb-1']);
                ?>
                </div></div>
            </div>
        </div>
    </div>

<?= $this->Form->end() ?>
<?= $this->Html->script([
    '/Formbuilder/js/popper.min.js',
    '/Formbuilder/js/jquery-ui.min.js',
    '/Formbuilder/js/form_builder.js',
],['nonce'=>get_nonce])?>
<style>
.nav-tabs .nav-link.active {
    position: relative;
    color: #FFF;
    background: #7d72ea;
}
</style>