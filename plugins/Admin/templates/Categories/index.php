<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= $this->Func->get_label($post_types,'cat_header');?>
                </h2>

                <?php if( ($title = $this->Func->get_label($post_types,'index_add'))!= ''):?>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link($title,
                            ['action'=>'Add','?'=>['post_type'=>$post_types]],
                            ['class'=>'btn btn-sm btn-primary']);?>
                    </ol>
                </div>
                <?php endif?>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card-body pt-0">
        <?= $this->Form->create($cat, ['url'=>['action'=>'Add']]) ?>
        <?php
        echo $this->Form->control('post_type',[
            'type'=>'hidden',
            'default'=>$post_types]);

        echo $this->Form->control('title',[
            'type'=>'text',
            'label'=>__d('Admin', 'عنوان'),
            'class'=>'form-control mb-1']);

        echo $this->Form->control('slug',[
            'type'=>'text',
            'label'=>__d('Admin', 'نامک'),
            'dir'=>'ltr',
            'class'=>'form-control mb-1 ltr']);

        echo $this->Form->control('parent_id', [
            'options' => $parentCategory,
            'empty'=>__d('Admin', '-- انتخاب کنید --'),
            'label'=>__d('Admin', 'والد'),
            'default'=>isset($this->request->getParam('?')['cur'])?$this->request->getParam('?')['cur']:'',
            'class'=>'form-control mb-1']);

        echo $this->Form->control('description',[
            'type'=>'textarea',
            'label'=>__d('Admin', 'توضیحات'),
            'class'=>'form-control']);?>
        <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success mt-2']) ?>
        <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="p-0"></th>
                    <th scope="col"><?= $this->Paginator->sort('title',__d('Admin', 'عنوان')) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('slug',__d('Admin', 'نامک')) ?></th>
                    <th scope="col" class="actions"><?=__d('Admin', 'تعداد نوشته')?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;$category=[];foreach ($categories as $cat_id => $cat_title ):
                $cat = $this->Query->category('post',[
                    'contain'=>'Posts',
                    'get_type'=>'first','id'=>$cat_id ]); ?>
                <tr>
                    <td width="10" class="p-0">
                        <div class="dropdown chart-dropdown float-left">
                            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i> 
                            <div class="dropdown-menu dropdown-menu-right">
                                <?= $this->Query->permalink(
                                    __d('Admin', 'نمایش پست'),
                                    $cat,
                                    ['type'=>'index','class'=>'dropdown-item','escape'=>false,'target'=>'_blank',]);
                                    ?>             
                                <?= $this->Query->permalink(
                                    __d('Admin', 'نمایش دسته بندی'),
                                    $cat,
                                    ['type'=>'category','class'=>'dropdown-item','escape'=>false,'target'=>'_blank',]); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?= $cat_title ?>
                        <div class="hidme">
                            <?= $this->Auths->link(__d('Admin', 'ویرایش'), ['action' => 'add', $cat_id ]) ?>
                            <?= $this->Form->postLink(__d('Admin', 'حذف'), ['action' => 'delete', $cat_id ], ['confirm' => __d('Admin', 'آیا برای حذف مطمین هستید؟?')]) ?>
                        </div>
                    </td>
                    <td>
                        <?= $cat['slug']; ?>
                    </td>
                    <td>
                        <?php
                        if(isset($cat['posts'])){
                            echo $this->html->link(count($cat['posts']),
                                ['controller'=>'Posts','?'=>['post_type'=> $post_types,'categorie'=> $cat_id ]],
                                ['target'=>'_blank','title'=>__d('Admin', 'نمایش پست های این دسته بندی')]);
                        }?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
        </div></div>

        <?= $this->element('Admin.paginate')?>
    </div>
</div>