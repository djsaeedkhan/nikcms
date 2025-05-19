<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت آزمون دوره
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none"></div>
</div>

<div class="card"><div class="card-body">
    <?= $this->Form->create($lmsCourseexam,['class'=>'col-sm-8']) ?>
    <?php
    if($id == null)
        echo $this->Form->control('lms_coursefile_id', ['options' => $lmsCoursefiles,'class'=>'form-control']);

    echo $this->Form->control('lms_exam_id', ['label'=>'عنوان آزمون','class'=>'form-control','options' => $lmsExams]);
    echo $this->Form->control('on_success',[
        'empty'=>'-- انتخاب کنید --',
        'required','class'=>'form-control',
        'options'=>[
            1=>'بله',
            0=>'خیر' ],
        'label'=>'در صورت قبولی، به مرحله بعد برود']);
    ?>
    <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
</div></div>

<style>.input{margin-bottom:20px;}</style>