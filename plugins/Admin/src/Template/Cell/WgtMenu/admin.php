<div class="row">
    <div class="col-sm-12">
        <?= $this->Form->control("{$field}.title", [
            'default' =>isset($value["menu"])?$value["menu"]:'' ,
            'label'=>  __d('Admin', 'عنوان تب'),
            'class'=> 'form-control mb-2' ]);?>
    </div>
    <div class="col-sm-12">
        <?= $this->Form->control("{$field}.menu", [
            'default' =>isset($value["menu"])?$value["menu"]:'' ,
            'options'=> $AllMenu,
            'type' => 'select',
            'empty' =>' -- '. __d('Admin', 'انتخاب کنید').' --',
            'label'=>  __d('Admin', 'انتخاب منو'),
            'class'=> 'form-control mb-2' ]);?>
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.nav_class", [
            'default' =>isset($value["nav_class"])?$value["nav_class"]:'' ,
            'label'=> 'Nav class',
            'class'=> 'form-control mb-2 ltr' ]);?> 
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.div_class", [
            'default' =>isset($value["div_class"])?$value["div_class"]:'' ,
            'label'=> 'Div class',
            'class'=> 'form-control mb-2 ltr' ]);?> 
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.ul_class", [
            'default' =>isset($value["ul_class"])?$value["ul_class"]:'' ,
            'label'=> 'Ul class',
            'class'=> 'form-control mb-2 ltr' ]);?> 
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.li_class", [
            'default' =>isset($value["li_class"])?$value["li_class"]:'' ,
            'label'=> 'li class',
            'class'=> 'form-control mb-2 ltr' ]);?> 
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.a_class", [
            'default' =>isset($value["a_class"])?$value["a_class"]:'' ,
            'label'=> 'a class',
            'class'=> 'form-control mb-2 ltr' ]);?> 
    </div>
</div><br>
<style>
.row label {
    margin-bottom:0;
}
</style>