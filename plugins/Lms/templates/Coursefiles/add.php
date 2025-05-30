<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت فایل (محتواهای نمایشی)
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none">
    </div>
</div>


    <?= $this->Form->create($lmsCoursefile,[]) ?>
    <div class="row">
        <div class="col-sm-6"><div class="card"><div class="card-body">
            <?php
            if($id == null)
                echo $this->Form->control('lms_course_id', ['options' => $lmsCourses]);

            if($weekid == null)
                echo $this->Form->control('lms_courseweek_id', [
                    'options' => $lmsCourseweeks]);

            echo $this->Form->control('title',[
                'label'=>'عنوان','class'=>'form-control']);

            
            echo $this->Form->control('content',[
                'label'=>'محتوای توضیحات','class'=>'form-control']);

            echo $this->Form->control('top_content',[
                'type'=>'textarea',
                'label'=>'توضیحات بالای صفحه',
                'class'=>'form-control']);
                
            echo $this->Form->control('image',[
                'label'=>'تصویر پیشفرض','type'=>'text','placeholder'=>'http://',
                'dir'=>'ltr','class'=>'form-control']);

            ?>

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <?= $this->Form->control('priority',[
                        'label'=>'اولویت نمایش','dir'=>'ltr','type'=>'number',
                        'class'=>'form-control']);?>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <?= $this->Form->control('enable',[
                    'label'=>'وضعیت','options'=>['غیرفعال','فعال'],'class'=>'form-control']);?>
                </div>

                <div class="col-md-4 col-sm-12 mb-0">
                    <?= $this->Form->control('show_in_list',[
                        'label'=>'نمایش در سایت',
                        'options'=>['خیر','بله'],'class'=>'form-control mb-0']);?>
                        <div class="small" style="margin-top: -20px;">
                            نمایش به مهمان
                        </div>
                </div>

                <div class="col-sm-6">
                    <?= $this->Form->control('total_time',[
                        'label'=>'بازه زمانی جلسه',
                        'class'=>'form-control',
                        ]);?>
                </div>
            </div>

        </div></div></div>

        <div class="col-sm-6"><div class="card"><div class="card-body">
            <?php
            echo $this->Form->control('days',[
                'label'=>'روز فعال سازی','class'=>'form-control']);
    
            echo $this->Form->control('filesrc_1',[
                'label'=>'آدرس کیفیت 1','type'=>'text','placeholder'=>'http://',
                'dir'=>'ltr','class'=>'form-control']);
    
            echo $this->Form->control('filesrc_2',[
                'label'=>'آدرس کیفیت 2','type'=>'text','placeholder'=>'http://',
                'dir'=>'ltr','class'=>'form-control']);
    
            echo $this->Form->control('filesrc_3',[
                'label'=>'آدرس کیفیت 3','type'=>'text','placeholder'=>'http://',
                'dir'=>'ltr','class'=>'form-control']);
    
            echo $this->Form->control('filesrc_4',[
                'label'=>'آدرس کیفیت 4','type'=>'text',
                'placeholder'=>'http://','dir'=>'ltr','class'=>'form-control']);

            echo $this->Form->control('preview',[
                'label'=>'فیلم پیش نمایش - مخصوص وبسایت','type'=>'text',
                'placeholder'=>'http://','dir'=>'ltr','class'=>'form-control']);
            echo '<div class="alert alert-primary">در صورتی که محتوا قابل نمایش باشد، این فیلم پخش خواهد شد</div>';
            
            echo $this->Form->control('filesrc_extra',[
                'label'=>'پلیر استریم','type'=>'textarea','placeholder'=>'...... .json',
                'dir'=>'ltr','class'=>'form-control']);
            echo '<div class="alert alert-warning small" style="margin-top: -20px;">راهنما:
            فقط آدرس json وارد شود<br>
            https://.... .arvanvod.com/...../origin_config.json</div><br>';

        ?>
        </div></div></div>

        <!-- <div class="col-sm-6"><div class="card"><div class="card-body">
            
        </div></div></div> -->
    </div>

    
    <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
<style>.input{margin-bottom:20px;}</style>