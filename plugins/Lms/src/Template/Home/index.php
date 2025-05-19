<?php
use Lms\View\Helper\LmsHelper;
?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    خوش آمدید
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo $this->html->link('ثبت دوره جدید',['controller'=>'Courses','action'=>'add'],
    ['class'=>'btn btn-success'])?>
    