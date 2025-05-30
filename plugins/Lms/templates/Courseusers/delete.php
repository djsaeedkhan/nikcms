<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    حذف کاربران دوره
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <a href="#" id="sall" class="btn btn-primary btn-sm">انتخاب همه</a>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <?= $this->Form->create($lmsCourseuser,['class'=>'col-sm-7']) ?>
    <?php
    if($id == null)
        echo $this->Form->control('lms_course_id', ['label'=>'لیست دوره ها','options' => $lmsCourses]);
        
    echo $this->Form->control('user_id', [
        'label'=>'لیست کاربران ('.count($users).' کاربر)' ,
        'multiple'=>'multiple','id'=>'ids',
        'class'=>'select2 form-control mb-0',
        'default'=>(($this->request->getQuery('user_id'))?$this->request->getQuery('user_id'):false),
        'options' => $users])?>
    <div class="small">برای انتخاب همزمان چند کاربر، کلید کنترل (Ctrl) را نگه داشته  و انتخاب کنید</div>
    <?= $this->Form->button(__('حذف'),['class'=>'btn btn-success btn-sm']) ?>
    <?= $this->Form->end() ?>
</div></div>

<script nonce="<?=get_nonce?>">
$(document).ready(function() {
    $("#sall").click(function(){
        $("#ids option").each(function(){
            $(this).prop('selected', true);
        });
    }); 
});
</script>
