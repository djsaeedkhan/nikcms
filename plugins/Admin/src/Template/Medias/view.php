<?php
use Cake\Routing\Router;

$extension= strtolower(pathinfo($media->image, PATHINFO_EXTENSION));
$path = $this->request->getAttribute("webroot") . $upload_path;
if(in_array($extension,['jpg','jpeg','png','gif'])){
    $thumb =  $path . $this->Func->show_post_thumbnail($media);
    $medium = $path . $this->Func->show_post_thumbnail($media,'medium');
    $full = Router::url('/',true) . $upload_path . $media->image;
}
else{
    $thumb = $medium = $path . "ext-$extension.jpg";
    $full = Router::url('/',true) . $upload_path . $media->image;
}
?>
<h3><?= (isset($media['id'])?__d('Admin', 'ویرایش رسانه'):__d('Admin', 'افزودن رسانه'))?></h3>
<div class="box box-primary">
    <div class="card-body">
    
    <div class="row">
        <div class="col-sm-6">
            <div class="table-responsive"><table class="table table-borderless">
            <?= $this->Form->create($media);?>
                <tr class="post_page">
                    <th scope="row">
                        <label for="categories-ids" style="font-weight: bold;">
                            <?= __d('Admin', 'دسته بندی')?>
                            <?= $this->Auths->link('['.__d('Admin', 'مدیریت').']',
                                ['controller'=>'Categories','action'=>'index','?'=>['post_type'=>$media_ptype]],
                                ['target'=>'_blank']);?>
                        </label>
                    </th>
                    <td>
                        <?=  $this->Form->control('categories._ids', [
                            'class'=>'form-control checkbox',
                            'label'=>false,
                            'escape'=>false,
                            'templates' => [
                                'inputContainer' => '<div class="checkbox">{{content}}</div>',
                                'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
                                'nestingLabel' => '{{hidden}}<label{{attrs}}>{{text}}</label> {{input}}',
                                'checkboxWrapper' => '<div class="radio" {{text}}>{{label}}</div>'
                            ],
                            'multiple'=>'checkbox', 
                            'div'=>'form-group']);?>
                            <style>
                                .post_page .checkbox{
                                    height: 150px;
                                    overflow: auto;
                                    border: 1px solid #D8D6DE;
                                    border-radius: 5px;
                                    padding: 10px;
                                }
                            </style>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __d('Admin', 'عنوان') ?></th>
                    <td>
                    <?= $this->Form->control('title', [
                        'type' => 'text',
                        'label'=>false,
                        'class' => 'form-control']);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __d('Admin', 'نامک') ?></th>
                    <td>
                    <?= $this->Form->control('slug', [
                        'type' => 'text',
                        'dir'=>'ltr',
                        'label'=>false,
                        'class' => 'form-control']);?>
                    </td>
                </tr>

                
                <tr>
                    <th scope="row"><?= __d('Admin', 'توضیحات') ?></th>
                    <td>
                    <?= $this->Form->control('content', [
                        'type' => 'textarea',
                        'label'=>false,
                        'class' => 'form-control']);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __d('Admin', 'تاریخ ایجاد') ?></th>
                    <td><?= $this->Func->date2($media->created) ?></td>
                </tr>
            </table></div>
            <!-- <?= $this->Form->control('Update', [
                'type' => 'submit',
                'class' => 'btn btn-success pull-left',
                'label'=>false,
                ]);?> -->

            <?= $this->Form->button(__d('Admin', 'انتشار'),[
                'class'=>'btn btn-success pull-left'])?>
            <?= $this->Form->end(); ?>
        </div>
        <div class="col-sm-6">
            <img src="<?= $medium;?>" class="img-responsive img-thumbnail"/>
        </div>
    </div>
    

</div></div>