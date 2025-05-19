<?php
use Shop\Predata;
$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت اتیکت ها (Label)
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
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
            echo $this->Form->create($labels);
            if($this->request->getQuery('edit')){
                echo $this->Form->control('id',['type'=>'hidden','class'=>'form-control']);
            }
            echo $this->Form->control('title',[
                'label'=>'عنوان','class'=>'form-control mb-2']);

            echo $this->Form->control('color',[
                'placeholder'=>'#CCC',
                'label'=>'رنگ','class'=>'form-control mb-2 ltr']);

            echo $this->Form->control('image',[
                'placeholder'=>'http://...',
                'label'=>'آدرس تصویر','class'=>'form-control mb-2 ltr']);
            
            echo $this->Form->control('link',[
                'label'=>'لینک مقصد',
                'placeholder'=>'http://...','type'=>'text',
                'class'=>'form-control mb-2 ltr']);
    
            echo $this->Form->control('descr',[
                'label'=>'توضیحات مختصر',
                'type'=>'textarea',
                'class'=>'form-control mb-2']);

            echo $this->Form->button(__('ثبت'),['class'=>'btn btn-success']);
            echo $this->Form->end();
            echo '</div>';
        }
        ?>
    </div>
    <div class="col-sm-8">
        <?php if($lists):?>
        <div class="box box-primary"><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('image','آدرس تصویر') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('title','عنوان علامت') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('color','رنگ بندی') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('link','لینک ') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lists as $list): ?>
                <tr>
                    <td class="ltr">
                        <?= $list->image != ''? $this->html->image($list->image,['style'=>'width:50px;height:50px;']):'' ?>
                    </td>
                    <td width="200">
                        <?= $list->title ?>
                        <div class="hidme">
                            <?= $this->Auths->link(__('ویرایش'), ['?'=>['edit'=> $list->id] ]) ?>

                            <?= $this->Form->postlink(__('حذف'), 
                                ['?'=>['delete'=> $list->id] ], 
                                ['confirm' => __('آیا برای حذف مطمئن هستید؟')]) ?>
                        </div>
                    </td>
                    <td class="ltr">
                        <?= $list->color !=''?
                            '<span class="badge badge-info" style="background:'.$list->color.'">&nbsp;&nbsp;</span>':
                            '' ?>
                    </td>
                    
                    <td class="ltr">
                        <?= $list->link != ''? $this->html->link($list->link,$list->link,['target'=>'_blank']):'' ?>
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