<?php
use Shop\Predata;
$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت پارامتر ها
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
        <div class="card-body list-group p-0">
            <?php
            foreach($attrs as $attr):
                echo '<li class="list-group-item">';
                echo $attr['title'];
                echo $this->html->link('[نمایش]','?list='.$attr['id'],['style'=>'font-size:13px;margin-right:5px']).
                $this->Form->postlink('[حذف]','?delete='.$attr['id'],
                        ['confirm'=>'آیا برای حذف مطمئن هستید؟','style'=>'font-size:13px;margin-right:5px']);
                echo '</li>';
            endforeach;?>
        </div>
        
        <?php
        //if(!$this->request->getQuery('list')){
            echo '<div class="card-body list-group p-0"><br>';
            echo $this->Form->create($params);?>
            <div class="controls">
                <label for="appendedInputButtons">عنوان پارامتر جدید</label>
                <div class="input-group">
                    <input class="form-control" id="appendedInputButtons" size="16" type="text" name="title" required>
                    <span class="input-group-append">
                        <input type="submit" class="btn btn-secondary" type="button" value="ثبت">
                    </span>
                </div>
            </div>
            <?php
            echo $this->Form->end();
            echo '</div>';
        //}
        ?>
    
        
    </div>
    <div class="col-sm-8">
        <?php if($attrlists):?>
        <div class="box box-primary "><div class="card-body">

        <?php
        if($this->request->getQuery('list') and $this->request->getQuery('list') == $attrlists->id){
            echo '<div class="alert alert-warning">'.
                $this->Form->create($paramlists,['class'=>'row']);
            echo '<div class="col-sm-7 mb-2">';
                echo $this->Form->control('title',['label'=>false, 
                    'placeholder'=>'عنوان زیر پارامتر را وارد کنید',
                    'required',
                    'class'=>'form-control']);
            echo '</div>';

            echo '<div class="col-sm-2 mb-2">';
                echo $this->Form->control('priority',['label'=>false, 
                    'type'=>'number','placeholder'=>'اولویت (عدد)','required',
                    'class'=>'form-control ltr']);
            echo '</div>';

            echo '<div class="col-sm-3 mb-2">';
                echo $this->Form->control('types',['label'=>false, 
                    'type'=>'select','options'=> $predata->gettype('paramlist_type'),
                    'required',
                    'class'=>'form-control']);
            echo '</div>';

            if($this->request->getQuery('edit'))
                echo $this->Form->button(__('بروز رسانی'),['class'=>'btn btn-sm btn-success mx-1']);
            else
                echo $this->Form->button(__('افزودن زیرپارامتر'),['class'=>'btn btn-sm btn-success mx-1']);

            echo ' '.$this->html->link(__('بازگشت'),'?',['class'=>'btn btn-sm btn-light mx-1']);
            echo $this->Form->end();
            echo '</div>';
        }
        ?>
        
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('title','لیست زیر پارامتر ها') ?></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;
                echo $this->Form->create(null,['url'=>['?'=>['priority'=>1]] ]);
                foreach (array_reverse($attrlists['shop_paramlists']) as $attrlist): ?>
                <tr>
                    <td>
                        <?= $attrlist->title ?>
                        <div class="hidme">
                            <?= $this->Auths->link(__('ویرایش'), 
                                ['?'=>['list'=> $attrlists->id,'edit'=> $attrlist->id] ]) ?>
                            <?= $this->Auths->link(__('حذف'), 
                                ['?'=>['deletelist'=> $attrlist->id] ], 
                                ['confirm' => __('آیا برای حذف مطمئن هستید؟')]) ?>
                        </div>
                    </td>
                    <td>
                        <?= $this->form->control($attrlist->id,[
                            'style'=>'width:100px;','default'=>$attrlist->priority ,
                            'class'=>'form-control ltr','type'=>'number','label'=>false]);?>
                    </td>
                    <td>
                        <?= $attrlist->types==2?$predata->getvalue('paramlist_type',$attrlist->types):''?>
                    </td>
                </tr>
                <?php $i+=1;endforeach;?>
                <tr>
                    <td></td>
                    <td><?= $this->form->button('ذخیره اولویت',['type'=>'submit','class'=>'btn btn-sm btn-primary']);?></td>
                    <td></td>
                </tr>
                <?= $this->form->end();?>


            </tbody>
        </table></div>

        </div></div>
        <?php endif;?>
    </div>
</div>

<style>
.list-group-item {
    margin-bottom: 5px;
}
</style>