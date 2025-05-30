<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت کاربران دوره
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
            <?= $this->Form->create($lmsCourseuser,['class'=>'col-sm-12']) ?>
                <?php
                if($id == null)
                    echo $this->Form->control('lms_course_id', [
                        'class'=>'select2',
                        'label'=>'لیست دوره ها','options' => $lmsCourses]);
                echo $this->Form->control('user_id', [
                    'label'=>'انتخاب کاربران','style'=>'min-height: 250px !important;',
                    'multiple'=>'multiple',
                    'class'=>'select2 form-control mb-2',
                    'default'=>(($this->request->getQuery('user_id'))?$this->request->getQuery('user_id'):false),
                    'options' => $users])?>
                    <div class="small">برای انتخاب همزمان چند کاربر، کلید کنترل (Ctrl) را نگه داشته  و انتخاب کنید</div>
            <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-success btn-sm']) ?>
            <?= $this->Form->end() ?>
        </div></div>
    </div>
    
    <div class="col-sm-12">
        <div class="card"><div class="card-body">
        <?= $this->Form->create($lmsCourseuser,['url'=>[$id,'?'=>['type'=>'textarea']],'class'=>'col-sm-12']) ?>
            <?php
            if($id == null)
                echo $this->Form->control('lms_course_id', [
                    //'class'=>'select2',
                    'label'=>'لیست دوره ها','options' => $lmsCourses]);
            echo $this->Form->control('user_ids', [
                'label'=>'لیست کاربران (در هر سطر یک نام کاربری)',
                'class'=>'form-control',
                'style'=>'height:250px;direction:ltr',
                'type'=>'textarea'])?>
        <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-success btn-sm']) ?>
        <?= $this->Form->end() ?>
        </div></div>
    </div>

</div>

<style>.input{margin-bottom:20px;}</style>