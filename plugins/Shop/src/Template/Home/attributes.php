<?php
use Shop\Predata;
$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت ویژگی ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <?php
        if($this->request->getQuery() == null or  $this->request->getQuery('edit')){
            echo '<div class="card-body list-group p-0"><br>';
            echo $this->Form->create($attrs);
            echo $this->Form->control('title',['label'=>'عنوان','class'=>'form-control mb-2']);
            if($this->request->getQuery('edit')){
                echo $this->Form->control('id',['type'=>'hidden','class'=>'form-control']);
            }
            else
            {
                echo $this->Form->control('value',[
                    'type'=>'textarea',
                    'label'=>'مقادیر (در هر سطر یک مقدار)',
                    'class'=>'form-control mb-2']);
            }
            echo $this->Form->control('types',[
                'type'=>'select',
                'empty'=>'-- پیشفرض --',
                'options' => $predata->gettype('attribute_list'),
                'label'=>'انتخاب نوع نمایش',
                'class'=>'form-control mb-2']);

            echo $this->Form->button(__('ثبت'),['class'=>'btn btn-success']);
            echo $this->Form->end();
            echo '</div>';
        }
        ?>
    </div>
    <div class="col-sm-8">
        <?php if($attrlist):?>
        <div class="box box-primary "><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('title','عنوان ویژگی ها') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('value','لیست مقادیر') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attrlist as $list): ?>
                <tr>
                    <td width="200"><?= $list->title ?>
                        <div class="hidme">
                            <?= $this->Auths->link(__('ویرایش'), ['?'=>['edit'=> $list->id] ]) ?>

                            <?= $this->Form->postlink(__('حذف'), 
                                ['?'=>['delete'=> $list->id] ], 
                                ['confirm' => __('آیا برای حذف مطمئن هستید؟')]) ?>
                        </div>
                    </td>
                    <td>
                        <?php 
                        $items = [];
                        foreach($list['shop_attributelists'] as $fld): 
                            $items[$fld['id']] = $fld['id'] ?>
                            <div class="btn-group btn-group-sm contact-name" role="group" style="margin-bottom:10px;" >
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $fld['title'] ?>
                            </button>
                            <div class="dropdown-menu">
                                <?= $this->html->link('ویرایش',['?'=>['e_attriblist' => $fld['id'] ]],['class'=>'dropdown-item'])?>
                                <?= $this->Form->postlink('حذف', ['?'=>['d_attriblist' =>  $fld['id'] ]], ['class'=>'dropdown-item','confirm' => __('برای حذف مطمئن هستید؟')]) ?>
                            </div>
                        </div>
                        <?php endforeach?>
                        <?= $this->html->link('+',
                            ['?'=>['a_attrblist'=> $list->id ]],
                            ['class'=>'btn btn-sm btn-warning','style'=>'margin-bottom:10px;','title'=>'افزودن'])?>

                        <?php
                        if($this->request->getQuery('e_attriblist') and $attrlister!= '' and in_array($this->request->getQuery('e_attriblist') , $items)){
                            echo $this->Form->create($attrlister,['class'=>'alert alert-success pt-0 pb-0']);
                            echo $this->Form->control('id',['type'=>'hidden','class'=>'form-control']);
                            echo $this->Form->control('title',['label'=>'عنوان','class'=>'form-control mb-2']);
                            if(isset($fld['shop_attribute']['types']) and $fld['shop_attribute']['types'] != ''){
                                echo $this->Form->control('value',[
                                    'label'=>'انتخاب '. $predata->getvalue('attribute_list',$fld['shop_attribute']['types']),
                                    'dir'=>'ltr','style'=>'font-family:tahoma',
                                    'class'=>'form-control mb-2']);
                            }
                            echo $this->Form->button(__('بروز رسانی'),['class'=>'btn btn-sm btn-success mb-2']);
                            echo $this->html->link('بازگشت',['?'=>false ],['class'=>'mr-2']);
                            echo $this->Form->end();
                        }
                        if($this->request->getQuery('a_attrblist') and $this->request->getQuery('a_attrblist') == $list->id){
                            echo $this->Form->create($attrlister,['class'=>'alert alert-success pt-0 pb-0']);
                            echo $this->Form->control('title',['label'=>'عنوان','class'=>'form-control mb-2']);
                            if(isset($fld['shop_attribute']['types']) and $fld['shop_attribute']['types'] != ''){
                                echo $this->Form->control('value',[
                                    'label'=>'انتخاب '. $predata->getvalue('attribute_list',$fld['shop_attribute']['types']),
                                    'dir'=>'ltr',
                                    'style'=>'font-family:tahoma',
                                    'class'=>'form-control mb-2']);
                            }
                            echo $this->Form->button(__('ثبت ویژگی جدید '),['class'=>'btn btn-sm btn-success mb-2']);
                            echo $this->Form->end();
                        }
                        
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
        </div></div>
        <?php 
        else:
            echo 'هنوز چیزی برای نمایش ثبت نشده است';
        endif;?>
    </div>
</div>

<style>
.list-group-item {
    margin-bottom: 5px;
}
</style>