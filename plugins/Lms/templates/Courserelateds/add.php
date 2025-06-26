<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت دوره  مرتبط
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card"><div class="card-body">
            <div class="alert alert-primary">
                اگر دوره ای پیش نیاز داشته باشد:
                <br>
                - ابتدا بررسی می شود که دوره های پیش نیاز برای کاربر ثبت شده باشد
                وسپس اجازه ثبت دوره برای کاربر انجام می شود. 
                <br>
                - معیار ثبت دوره پیش نیاز ، داشتن حداقل یک فاکتور پرداخت شده می باشد
                <br>
                - این مکانیزم فقط برای ثبت نام دوره توسط کاربر می باشد
                    و در صورتی که مدیریت دوره ای را ثبت کند، این پیش نیاز بررسی نمی شود.
                <br>
            </div>
            <?php
                echo $this->Form->create($lmsCourserelated,['class'=>'col-sm-4']);
                //echo $this->Form->control('lms_course_id', ['options' => $lmsCourses]);

                echo $this->Form->control('lms_course_ids', [
                    'empty'=>' -- ',
                    'label'=>'انتخاب دوره',
                    'class'=>'form-control',
                    'options' => $lmsCourses]);
                echo $this->Form->control('types',['type'=>'hidden','default'=>1]);
            ?><br>
        </div></div>
    </div>
</div>
<?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
<?= $this->Form->end() ?>