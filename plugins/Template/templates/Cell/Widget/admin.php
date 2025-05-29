<?php 
for($i = 1;$i<4;$i++):?>
    <div class="row">
        <div class="col-sm-12">
            <?= $this->Form->control( "{$field}.tab{$i}_title", [
                'default' =>isset($value["tab{$i}_title"])?$value["tab{$i}_title"]:'' ,
                'label'=> 'عنوان تب '. $i,
                'class'=> 'form-control' ]);?>
        </div>
        <div class="col-sm-6">
            <?= $this->Form->control( "{$field}.tab{$i}_post_type", [
                'type'=> 'select',
                'options' =>$this->Func->posttype_list(),
                'escape'=> false,
                'empty' =>' --- ',
                'default' =>isset($value["tab{$i}_post_type"])?$value["tab{$i}_post_type"]:'' ,
                'label'=> 'پست تایپ',
                'class'=> 'form-control' ]);?>
        </div>
        <div class="col-sm-6">
            <?= $this->Form->control( "{$field}.tab{$i}_count", [
                'type' =>'number',
                'default' =>isset($value["tab{$i}_count"])?$value["tab{$i}_count"]:'' ,
                'label'=> 'تعداد نمایش',
                'class'=> 'form-control' ]);?>
        </div>
    </div>
    <hr style="border-color: #c2cfd6">
<?php endfor;?>