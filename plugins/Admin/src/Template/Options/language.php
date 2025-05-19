<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'مدیریت زبان و ترجمه');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <?= __d('Admin', 'زبان فعلی سایت')?> &nbsp;
                        <span class="badge badge-warning badge-pill">
                            <?php echo $this->Func->language_list(isset($result['lang_name'])?$result['lang_name']:'fa');?>
                        </span>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body py-3">
    <div class="row">
        <div class="col-sm-6">
            <?= $this->Form->create(null, ['url'=>['action'=>'SaveSetting']]);?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Form->control('lang_name', [
                        'type'=>'select',
                        'label'=>__d('Admin', 'زبان پیش فرض'),
                        'class'=>'form-control mb-1',
                        'options'=>$this->Func->language_list(),
                        'default'=>isset($result['lang_name'])?$result['lang_name']:'',]);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('lang_alt', [
                        'type'=>'select',
                        'label'=>__d('Admin', 'زبان جایگزین') .' (' .__d('Admin', 'اختیاری'). ')',
                        'class'=>'form-control mb-1',
                        'options'=>$this->Func->language_list(),
                        'empty'=>'--',
                        'default'=>isset($result['lang_alt'])?$result['lang_alt']:'',]);?>
                </div>
            </div>
            <br>

            <div class="d-flex justify-content-between1 mb-1">
                <div class="custom-control custom-switch">
                    <input type="hidden" value="0" name="lang_redirect">
                    <input type="checkbox" name="lang_redirect" value="1" class="custom-control-input" 
                    <?= (isset($result['lang_redirect']) and $result['lang_redirect']==1)?'checked':''?> id="lang_redirect" />
                    <label class="custom-control-label" for="lang_redirect"></label>
                </div>
                <label class="lang_redirect-title pr-1" for="lang_redirect">
                    <?= __d('Admin', 'در ادامه مطلب، در صورت عدم وجود ترجمه به صفحه نخست هدایت شود')?>
                </label>
            </div>

            <div class="d-flex justify-content-between1 mb-1">
                <div class="custom-control custom-switch">
                    <input type="hidden" value="0" name="lang_enable">
                    <input type="checkbox" name="lang_enable" value="1" class="custom-control-input" 
                    <?= (isset($result['lang_enable']) and $result['lang_enable']==1)?'checked':''?> id="lang_enable" />
                    <label class="custom-control-label" for="lang_enable"></label>
                </div>
                <label class="lang_enable-title pr-1" for="lang_enable">
                    <?=__d('Admin', 'فعال سازی حالت چند زبانه (ذخیره تنظیمات جداگانه)')?>
                </label>
            </div>
            
        </div>
        

        <div class="col-sm-6">
            <div class="alert alert-secondary">
                <h4>
                    <?=__d('Admin', 'توضیحات')?>
                </h4>
                - <?=__d('Admin', 'زبان پیش فرض برای سایت "فارسی" می باشد')?>.<br>
                - <?=__d('Admin', 'با تغییر زبان باید برای اطلاعات قبلی ثبت شده (درسایت) معادل زبان انتخابی تان را وارد کنید')?>.<br>
                - <?=__d('Admin', 'در صورت عدم تکمیل معادل فارسی، اطلاعات در زبان انتخابی "خالی" نمایش داده خواهد شد')?>.<bR>
                - <?=__d('Admin', 'پیشنهاد میشود قبل از درج اطلاعات نسبت به انتخاب زبان سایت اقدام کنید')?>.
            </div>
        </div>
    </div>
    
</div></div>

<?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']);?>
<?= $this->Form->end() ?>