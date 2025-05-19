<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('افزودن توضیحات') ?>
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
    <?= $this->Form->create($lmsCoursefilenote) ?>
    <?php
    if($id == null)
        echo $this->Form->control('lms_coursefile_id', ['options' => $lmsCoursefiles]);
    echo $this->Form->control('types',['label'=>'نوع فایل','options'=> $coursefilenotes_type]);
    echo $this->Form->control('descr',['label'=>'توضیحات']);
    ?>
    <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
</div></div>

<style>.input{margin-bottom:20px;}</style>