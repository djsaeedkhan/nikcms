<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    تمدید/تغییر تاریخ دسترسی کاربر به دوره : 
                    <?php 
                    if(isset($lmsCourseuser['user']['username']))
                        echo $lmsCourseuser['user']['username'] . 
                        ($lmsCourseuser['user']['family']!= ''?'/'.$lmsCourseuser['user']['family']:'');?>
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
                این امکان زمانی کاربردی است که تاریخ شروع دوره برای کاربر
                بر اساس "تاریخ ثبت دوره برای کاربر" باشد.
            </div>
            <?= $this->Form->create($lmsCourseuser,['class'=>'col-sm-12']) ?>
                <?php
                echo $this->Form->control('created', [
                    'label'=>'تاریخ شروع',
                    'class'=>'form-control mb-2'])?>
            <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-success btn-sm']) ?>
            <?= $this->Form->end() ?>
        </div></div>
    </div>
</div>

<style>.input{margin-bottom:20px;}</style>