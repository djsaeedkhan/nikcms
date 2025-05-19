<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'تنظیمات خواندن');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create(null, ['class'=>'p-0', 'url'=>['action'=>'SaveSetting']]);?>
<section id="vertical-tabs">
    <div class="row match-height">
        <div class="col-lg-12">
            <div class="nav-vertical">
                <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        <?= __d('Admin', 'تنظیمات خواندن');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                        <?= __d('Admin', 'پست تایپ ها');?></a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active col-12 col-md-6" id="home" role="tabpanel">
                        <?php

                        echo $this->Form->control('posts_order', [
                            'type'=>'select',
                            'label'=>__d('Admin', 'ترتیب نمایش مطالب'),
                            'class'=>'form-control',
                            'style'=>'width:200px;',
                            'empty'=>'تاریخ ثبت',
                            'options'=>[
                                'priority' => 'اولویت دستی',
                            ],
                            'default'=>isset($result['posts_order'])?$result['posts_order']:'']);
                        echo '<br>';
                            
                        echo $this->Form->control('posts_per_page', [
                            'type'=>'number',
                            'label'=>__d('Admin', 'تعداد نوشته در هر صفحه'),
                            'class'=>'form-control ltr',
                            'style'=>'width:200px;',
                            'default'=>isset($result['posts_per_page'])?$result['posts_per_page']:'']);
                        echo '<div class="alert alert-info mb-2">در تب بعدی میتوانید تعداد نمایش بر اساس پست تایپ را مشخص کنید</div>';
                            
                        echo $this->Form->control('excerpt_from_content', [
                            'type'=>'select',
                            'label'=>__d('Admin', 'فراخوانی چکیده از متن اصلی '),
                            'options'=>[
                                1 =>__d('Admin', 'بله'),
                                0 =>__d('Admin', 'خیر'),
                            ],
                            'class'=>'form-control',
                            'style'=>'width:200px;',
                            'default'=>isset($result['excerpt_from_content'])?$result['excerpt_from_content']:'']);
                            ?>
                            <small>
                                <?= __d('Admin', 'در صورتی که چکیده خالی باشد، از متن اصلی فراخوانی شود')?>
                            </small>
                    </div>

                    <div class="tab-pane" id="profile" role="tabpanel">
                        <div class="alert alert-info">
                            - <?= __d('Admin', 'تیک: پست تایپ پیش فرض در صفحه ایندکس')?><br>
                            - <?= __d('Admin', 'تکست باکس: عنوان نمایشی پست تایپ در سایت')?>
                        </div>
                        <input type="hidden" name="index_posttype" value="">
                        <input type="hidden" name="hide_posttype" value="">

                        <table class="table table-borderless">
                            <tr>
                                <th><?= __d('Admin', 'نمایش پیشفرض')?></th>
                                <th><?= __d('Admin', 'عدم نمایش در پیشخوان')?></th>
                                <th><?= __d('Admin', 'تغییر عنوان پست تایپ')?></th>
                                <th><?= __d('Admin', 'تعداد نمایش Paginate')?></th>
                            </tr>
                        <?php
                        echo $this->Form->create(null, ['class'=>'col-sm-6','url'=>['action'=>'SaveSetting']]);
                        /* echo $this->Form->control('index_posttype', [
                            'type' => 'select',
                            'label'=>'پست تایپ پیش فرض',
                            'style' =>'margin-left: 10px !important;',
                            'multiple'=>'checkbox',
                            'escape'=>false,
                            'options' => $this->Func->posttype_list(),
                            'default'=>isset($result['index_posttype'])?unserialize($result['index_posttype']):'',
                            ]);  */
                        $det = $this->Func->OptionGet('posttype_title') !=''?unserialize($this->Func->OptionGet('posttype_title')):[];
                        $paginate = $this->Func->OptionGet('posttype_paginate') !=''?unserialize($this->Func->OptionGet('posttype_paginate')):[];
                        $def = isset($result['index_posttype'])?unserialize($result['index_posttype']):'';
                        $hide = isset($result['hide_posttype'])?unserialize($result['hide_posttype']):'';
                        foreach($this->Func->posttype_list() as $lk => $lv){?>
                            <tr>
                                <td>
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input class="custom-control-input" 
                                            type="checkbox" 
                                            name="index_posttype[]" 
                                            id="index-posttype-<?=$lk?>" 
                                            value="<?=$lk?>" 
                                            <?= strlen(array_search($lk,$def))> 0?'checked':'';?> >
                                        <label class="custom-control-label" style="min-width:100px"
                                            for="index-posttype-<?=$lk?>">
                                                &nbsp;&nbsp;<!-- <?=$lv;?> -->
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input class="custom-control-input" 
                                            type="checkbox" 
                                            name="hide_posttype[]" 
                                            id="hide-posttype-<?=$lk?>" 
                                            value="<?=$lk?>" 
                                            <?= (is_array($hide) and strlen(array_search($lk,$hide))> 0)?'checked':'';?> >
                                        <label class="custom-control-label"  style="min-width:100px"
                                            for="hide-posttype-<?=$lk?>">
                                                &nbsp;&nbsp;<!-- <?=$lv;?> -->
                                        </label>
                                    </div>

                                </td>
                                <td>
                                    <label class="custom-control-labels"  style="min-width:100px" for="sindex-posttype-<?=$lk?>">
                                            &nbsp;&nbsp;<?=$lv;?>
                                    </label>
                                    <input type="text" value="<?= isset($det[$lk])?$det[$lk]:'';?>"
                                        class="form-control form-control-sm" 
                                        style="width:150px;display:inline;"
                                        title="<?= __d('Admin', 'عنوان جایگزین')?>"
                                        name="posttype_title[<?=$lk?>]">

                                </td>

                                <td>
                                    <label class="custom-control-labels"  style="min-width:100px" for="paginate-posttype-<?=$lk?>">
                                        تعداد نمایش در <?=$lv;?>
                                    </label>
                                    <input type="text" value="<?= isset($paginate[$lk])?$paginate[$lk]:'';?>"
                                        class="form-control form-control-sm" 
                                        style="width:150px;display:inline;direction:ltr;"
                                        title="<?= __d('Admin', 'تعداد نمایش')?>"
                                        name="posttype_paginate[<?=$lk?>]">

                                </td>
                            </tr>
                        <?php 
                        }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'mt-3 btn btn-success']);?>
<?= $this->Form->end();?>

<?php $this->start('modal');?>
    <?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>


