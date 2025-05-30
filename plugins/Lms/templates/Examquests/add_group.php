
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Lms', 'افزودن گروهی سوالات')?>
                </h2>
                
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="row">
        <div class="col-sm-5">
        <?= $this->Form->create(null,['type'=>'file']) ?>

            <?= $this->Form->control('file', [
                'class'=>'form-control mb-1',
                'type'=>'file',
                'label'=>__d('Lms', 'فایل CSV را انتخاب کنید')]);?>
            <br>

            <div><?= __d('Lms', 'پیشنهاد می شود ابتدا فایل را با یک سوال ایجاد و تست کنید و پس از درست بودن فرایند نسبت به ثبت لیست سوالات خود اقدام کنید')?></div>

            <?= $this->Form->button(__d('Lms', 'شروع عملیات'),
                ['class'=>'mt-1 mb-1 btn btn-sm btn-success']);?>
            <?= $this->Form->end() ?>
        </div>
        <div class="col-sm-7">
            <h4><?= __d('Lms', 'توجه')?>: </h4>
            <div class="alert alert-primary" style="line-height: 30px;">
                - <?= __d('Lms', 'دانلود فایل نمونه')?> 
                    <?= $this->html->link(__d('Lms', 'کلیک کنید'),
                        '/lms/files/add_question.zip',
                        ['class'=>'btn btn-sm btn-primary'])?><br>
                - <?= __d('Lms', 'باتوجه به عنوان ستون ها، اطلاعات را وارد کنید')?><br>
                - <?= __d('Lms', 'برای تغییر فایل میتوانید از Notepad ویندوز استفاده نمایید')?><br>
                - <?= __d('Lms', 'پسوند فایل میبایست CSV باشد. پسوند Xls یا Xlsx قابل استفاده نمی باشد')?><br>
                - <?= __d('Lms', 'از قرار دادن کاراکتر های غیرمجاز و ... اجتناب کنید')?><br>
                - <?= __d('Lms', 'در اطلاعات وارد شده از کاراکتر نقطه ویرگول "<b>;</b>" استفاده نکنید')?>
                - <?= __d('Lms', 'Encoding فایل  میبایست UTF-8 باشد در غیر این صورت ممکن است متن های فارسی درست ذخیره نشوند')?><br>
            </div>
        </div>
    </div>
</div></div>