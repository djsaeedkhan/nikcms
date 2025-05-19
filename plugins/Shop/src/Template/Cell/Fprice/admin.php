<div class="row py-1">
    <div class="col-sm-12">
        <?= $this->Form->control( "{$field}.title", [
            'default' =>isset($value["title"])?$value["title"]:'' ,
            'label'=> 'عنوان',
            'class'=> 'form-control' ]);?>
    </div>
</div>