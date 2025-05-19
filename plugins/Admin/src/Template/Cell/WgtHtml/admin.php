<div class="row">
    <div class="col-sm-12">
        <?= $this->Form->control("{$field}.title", [
            'default' =>isset($value["title"])?$value["title"]:'' ,
            'label'=>  __d('Admin', 'عنوان'),
            'class'=> 'form-control mb-1' ]);?>
    </div>
    <div class="col-sm-12">
        <?= $this->Form->control("{$field}.text", [
            'default' =>isset($value["text"])?$value["text"]:'' ,
            'type'=>'textarea','label'=> false,'style'=>'height:130px !important;',
            'class'=> 'form-control ltr mb-1' ]);?>

    </div>
</div>
<style>
.row label {
    margin-bottom:0;
}
</style>