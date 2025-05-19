<div class="row py-1">
    <div class="col-sm-12">
        <?= $this->Form->control( "{$field}.title", [
            'default' =>isset($value["title"])?$value["title"]:'' ,
            'label'=> 'عنوان',
            'class'=> 'form-control' ]);?>
    </div>
    <!-- <div class="col-sm-6">
        <?php $this->Form->control( "{$field}.tab_post_type", [
            'type'=> 'select',
            'options' =>$this->Func->posttype_list(),
            'escape'=> false,
            'empty' =>' --- ',
            'default' =>isset($value["tab_post_type"])?$value["tab_post_type"]:'' ,
            'label'=> 'پست تایپ',
            'class'=> 'form-control' ]);?>
    </div>
    <div class="col-sm-6">
        <?php $this->Form->control( "{$field}.tab_count", [
            'type' =>'number',
            'default' =>isset($value["tab_count"])?$value["tab_count"]:'' ,
            'label'=> 'تعداد نمایش',
            'class'=> 'form-control' ]);?>
    </div> -->
</div>