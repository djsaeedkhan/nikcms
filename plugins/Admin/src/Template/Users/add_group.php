
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Admin', 'افزودن گروهی کاربر')?>
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
                'label'=>__d('Admin', 'فایل CSV را انتخاب کنید')]);?>
            <br>

            <div><?= __d('Admin', 'پیشنهاد می شود ابتدا فایل را با یک کاربر ایجاد و تست کنید و پس از درست بودن فرایند نسبت به ثبت لیست کاربران خود اقدام کنید')?></div>

            <?= $this->Form->button(__d('Admin', 'شروع عملیات'),
                ['class'=>'mt-1 mb-1 btn btn-sm btn-success']);?>
            <?= $this->Form->end() ?>
        </div>
        <div class="col-sm-7">
            <h4><?= __d('Admin', 'توجه')?>: </h4>
            <div class="alert alert-primary">
                - <?= __d('Admin', 'دانلود فایل نمونه')?> 
                    <?=$this->html->link(
                        __d('Admin', 'کلیک کنید'),
                        '/admin/files/user_group.zip',
                        ['class'=>'btn btn-sm btn-primary'])?><br><br>
                - <?= __d('Admin', 'اولین ستون همیشه نام کاربری باشد')?><br>
                - <?= __d('Admin', 'تاریخ انقضا کاربر ، تاریخ میلادی باشد و میتواند همچنین خالی باشد')?><br><br>
                - <?= __d('Admin', 'نام کاربری کمتر از 8 کاراکتر نباشد و اطلاعاتی از قبیل نام کاربری یا آدرس ایمیل تکراری نباشند')?><br>
                - <?= __d('Admin', 'Encoding فایل  میبایست UTF-8 باشد . در غیر این صورت ممکن است متن های فارسی درست ذخیره نشوند')?><bR><br>
                - <?= __d('Admin', 'باتوجه به عنوان ستون ها، اطلاعات را وارد کنید')?><br>
                - <?= __d('Admin', 'در صورتی که نام کاربری تکراری باشد و یا پسورد کوتاه باشد، سطر ذخیره نخواهد شد')?>.<br><br>
                - <?= __d('Admin', 'برای تغییر فایل میتوانید از نوتپد استفاده نمایید')?><br>
                - <?= __d('Admin', 'پسوند فایل میبایست CSV باشد. پسوند Xls یا Xlsx قابل استفاده نمی باشد')?><br><br>
                - <?= __d('Admin', 'از قرار دادن کاراکتر های غیرمجاز یا ... اجتناب کنید')?><br>
                - <?= __d('Admin', 'در اطلاعات وارد شده از کاراکتر نقطه ویرگول "<b>;</b>" استفاده نکنید')?>
            </div>
        </div>
    </div>
</div></div>