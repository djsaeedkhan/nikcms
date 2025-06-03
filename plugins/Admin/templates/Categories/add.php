<?php $this->assign('title', __d('Admin', "دسته بندی"));?>
<h3><?= (isset($category['id'])?__d('Admin', 'ویرایش دسته بندی'):__d('Admin', 'افزودن دسته بندی'))?></h3>
<div class="box box-primary">
    <div class="card-body">
    <?= $this->Form->create($category);
        echo $this->Form->control('post_type',['type'=>'hidden','default'=>$post_types]); ?>

    <div class="row">
        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Form->control('title',[
                        'type'=>'text','label'=>__d('Admin', 'عنوان'),
                        'class'=>'form-control mb-1']);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('slug',[
                        'type'=>'text','dir'=>'ltr','label'=>__d('Admin', 'نامک'),
                        'class'=>'form-control ltr mb-1']);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('parent_id', [
                        'options' => $parentCategory,'label'=>__d('Admin', 'والد'),
                        'empty'=>'--',
                        'default'=> $this->request->getQuery('current'),
                        'class'=>'form-control']);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('CategorieMetas.image',[
                        'class'=>'form-control mb-2 ltr','label'=>__d('Admin', 'تصویر شاخص'),
                        'placeholder'=>'http://','id'=>'image',
                        'style'=>'padding-right: 30px;',
                        'default'=>(isset($post_meta_list['image'])?$post_meta_list['image']:'') ,
                        ]);
                    echo '<div class="mb-2" style="cursor:pointer;margin-top: -50px;float: right;margin-right: 10px;">
                        <a data-toggle="modal" data-target="#exampleModal" data-action="select_src" title="'.__d('Admin', 'انتخاب فایل') .'" data-dest="image" style="color:#9e9e9e"><i data-feather="camera"></i></a>
                        </div>';
                    ?>

                </div>
                
            </div>
        </div>

        <div class="col-sm-5">
            <?= $this->Form->control('description',[
                'label'=>__d('Admin', 'توضیحات'),
                'type'=>'textarea',
                'class'=>'form-control']);?>
        </div>

    </div>

    <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-sm btn-success']) ?>
    </div>
</div><br>

<div class="more_setting">
    <h3><?= __d('Admin', 'تنظیمات');?></h3>
    <div class="card">
        <div class="card-body">
            <?php
            $list = 0;
            $post_types =$category['post_type'];
            //Load cell
            if(count(@$navmenu = $this->Func->admin_postwidget($post_types,'category'))):
                foreach($navmenu as $nav):
                    foreach($nav as $knav=>$vnav){
                        $list +=1;
                        echo $this->cell($vnav,[$knav,isset($post_meta_list)?$post_meta_list:[]]);
                    }
                endforeach;
            endif;
            ?><br>
            <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success btn-sm ']);
            
            if($list == 0)
                echo '<script nonce="'.get_nonce.'">$(".more_setting").addClass("d-none");</script>';?>
        </div>
    </div>
</div>
<?php $this->start('modal');?>
<?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); 

echo $this->Form->end();?>

<style>
.img-thumbnail:hover{
    cursor:pointer;
}
</style>