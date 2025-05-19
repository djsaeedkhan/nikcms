<div class="row py-1">
    <div class="col-sm-12">
        <?= $this->Form->control( "{$field}.title", [
            'default' =>isset($value["title"])?$value["title"]:'' ,
            'label'=> 'عنوان',
            'class'=> 'form-control' ]);?>
    </div>

    <div class="col-sm-12 mt-1">
        <?php $productlist = $this->Query->category('product',[
            'find_type'=>'treeList',
            'limit'=> 0 ,
            'order'=>['Posts.id'=>'desc'],
            'field'=>['id','title']]);?>

        <?= $this->Form->control( "{$field}.category", [
            'default' =>isset($value["category"])?$value["category"]:'' ,
            'label'=> 'انتخاب دسته بندی',
            'empty'=>'-- انتخاب کنید --',
            'type'=>'select','options'=> $productlist,
            'class'=> 'form-control mb-1' ]);?>

        <?= $this->Form->control( "{$field}.types", [
            'default' =>isset($value["types"])?$value["types"]:'' ,
            'label'=> 'نوع نمایش دسته بندی',
            'empty'=>'-- انتخاب کنید --',
            'type'=>'select','options'=> [
                1 => 'دسته بندی ثابت',
                0 => 'دسته بندی فعلی'
            ],
            'class'=> 'form-control mb-1' ]);?>
    </div>
    
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.nav_class", [
            'default' =>isset($value["nav_class"])?$value["nav_class"]:'' ,
            'label'=> 'Nav class',
            'class'=> 'form-control mb-1 ltr' ]);?> 
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.ul_class", [
            'default' =>isset($value["ul_class"])?$value["ul_class"]:'' ,
            'label'=> 'ul class',
            'class'=> 'form-control mb-1 ltr' ]);?> 
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.li_class", [
            'default' =>isset($value["li_class"])?$value["li_class"]:'' ,
            'label'=> 'li class',
            'class'=> 'form-control mb-1 ltr' ]);?> 
    </div>
    <div class="col-sm-6 ltr">
        <?= $this->Form->control("{$field}.a_class", [
            'default' =>isset($value["a_class"])?$value["a_class"]:'' ,
            'label'=> 'a class',
            'class'=> 'form-control mb-1 ltr' ]);?> 
    </div>
    <div class="col-sm-12 ltr">
        <?= $this->Form->control("{$field}.a_before", [
            'default' =>isset($value["a_before"])?$value["a_before"]:'' ,
            'label'=> 'a before',
            'class'=> 'form-control mb-1 ltr' ]);?> 
    </div>
</div>