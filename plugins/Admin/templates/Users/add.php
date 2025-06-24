<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= (isset($user['id'])?__d('Admin', 'ویرایش کاربر'):__d('Admin', 'افزودن کاربر'))?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <b>
                        <?= $this->html->link(__d('Admin', 'افزودن از فایل (ثبت دسته جمعی)'),
                            ['action'=>'add','?'=>['get'=>'group']],
                            ['class'=>'nav-link btn btn-sm btn-primary'])?>
                        </b>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <?php use Cake\View\Cell;echo $this->cell('RegisterField.View');?>
    </div>
</div>

<?= $this->Form->create($user); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="card"><div class="card-body">
            <?php
                echo $this->Form->control('family', [
                    'label'=>__d('Admin', 'نام و نام خانوادگی'),
                    'class'=>'form-control mb-2',
                    'autocomplete'=>'off']);

                echo !isset($user['id'])?
                    $this->Form->control('username', [
                        'class'=>'form-control mb-2',
                        'autocomplete'=>'off',
                        'label'=>__d('Admin', 'نام کاربری')]):

                    $this->Form->control('u', [
                        'class'=>'form-control mb-2 ltr',
                        'value'=>$user['username'],
                        'label'=>'Username',
                        'disabled'=>true,
                        'label'=>'نام کاربری'
                    ]);

                echo $this->Form->control('password', [
                    'class'=>'form-control ltr',
                    'value'=>'',
                    'autocomplete'=>'off',
                    'label'=>'رمز عبور']);

                echo isset($user['id'])?
                    '<div class="alert alert-secondary text-muted mb-2 small">
                        '.__d('Admin', 'اگر نمیخواهید رمزعبور  تغییر کند چیزی ننویسید') .'</div>':'<br>';
                
                echo $this->Form->control('email', [
                    'class'=>'form-control mb-2 ltr',
                    'autocomplete'=>'off',
                    'label'=>__d('Admin', 'آدرس ایمیل')
                    ]).'<hr>';

                echo $this->Form->control('expired', [
                    'class'=>'form-control mb-2 ltr',
                    'autocomplete'=>'off',
                    'label'=>__d('Admin', 'تاریخ انقضای ورود') ]).'<hr>';

                echo $this->Func->create_form(\Admin\View\Helper\ModuleHelper::options_registerform(), $meta_list);
                echo $this->Form->control('enable', [
                    'options' =>$this->Func->predata('enable'),
                    'empty'=>' -- '.__d('Admin', 'انتخاب').' --',
                    'default' => 1,
                    'label'=>__d('Admin', 'وضعیت لاگین (ورود) به مدیریت'),
                    'class'=>'form-control mb-2']);?>
        </div></div>
    </div>
    <div class="col-sm-6">
        <div class="card"><div class="card-body">
            <?= $this->Func->create_form(Admin\View\Helper\ModuleHelper::options_userfield(),$meta_list)?>
        </div></div>
    </div>
</div>

<?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),[
    'class'=>'mt-1 mb-1 btn btn-success']);?>
    
<?= $this->Form->end() ?>