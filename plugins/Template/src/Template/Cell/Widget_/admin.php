<div class="row">
    <div class="col-sm-12">
        <?= $this->Form->control( "{$field}.title", [
            'default' =>isset($value["title"])?$value["title"]:'' ,
            'label'=> 'عنوان تب ',
            'class'=> 'form-control' ]);?>
    </div>
    <div class="col-sm-6">
        <?= $this->Form->control( "{$field}.post_type", [
            'type'=> 'select',
            'options' =>$this->Func->posttype_list(),
            'escape'=> false,
            'empty' =>' --- ',
            'default' =>isset($value["post_type"])?$value["post_type"]:'' ,
            'label'=> 'پست تایپ',
            'class'=> 'form-control' ]);?>
    </div>
    <div class="col-sm-6">
        <?= $this->Form->control( "{$field}.count", [
            'type' =>'number',
            'default' =>isset($value["count"])?$value["count"]:'' ,
            'label'=> 'تعداد نمایش',
            'class'=> 'form-control' ]);?>
    </div>
</div>
<hr style="border-color: #c2cfd6">
