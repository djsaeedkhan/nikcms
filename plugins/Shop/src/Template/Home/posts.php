<?php use Cake\Routing\Router;
use Shop\View\Helper\ShopHelper;
?>
<?= $this->element('Shop.shop_modal');?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0"><?= $this->Func->get_label($post_types,'index_header');?></h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link( $this->Func->get_label($post_types,'index_add'),
                            ['action'=>'Add','?'=>['post_type'=>$post_types]],['class'=>'btn btn-sm btn-primary']);?>
                        
                        <span id="dbutton" class="btn btn-sm ml-1 btn-warning">حذف</span>
                        <?= $this->Auths->link('حذف انتخاب شده ها','#',['class'=>'btn ml-1 btn-sm btn-danger dlistbutton dbutton2 d-none']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
        <?= $this->Form->control('post_type',['type'=>'hidden','value'=>$post_types]);?>
        <div class="row">
            <?= $this->Form->control('text', [
                'label'=>false,
                'type' => 'text', 
                'class' => 'form-control form-control-sm',
                'placeholder'=>'عنوان را وارد کنید',
                'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                ]);?>
            <?= $this->Form->button(__('جستجو'),['class'=>'btn btn-sm btn-success ml-1']);?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id',' ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image','تصویر') ?></th>
                <th scope="col" style="width:300px"><?= $this->Paginator->sort('title','عنوان') ?></th>
                <th scope="col">
                    <?php
                    if(($cat_access = $this->Func->get_ptaccess($post_types,'category'))):?>
                        <?= $this->Paginator->sort('Category','دسته بندی') ?>
                    <?php endif;?>

                    <?php if(($tag_access = $this->Func->get_ptaccess($post_types,'tag'))):?>
                         / <?= $this->Paginator->sort('Tags','برچسب') ?>
                    <?php endif;?>
                    
                </th>
                <th scope="col"><?= $this->Paginator->sort('Postview','تعداد نمایش') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <?= $this->Form->create(null, ['url'=>['action'=>'delete','list'],'type' => 'post','id'=>'dall','validate'=>false]); ?>
        <tbody>
            <?php foreach ($posts as $post):?>
            <tr class="<?= (!$post->published?'table-warning':'');?>">
                <td class="text-center p-0">
                    <?= ($post->id) ?>
                    <div class="custom-control custom-checkbox dlistbutton d-none">
                        <input type="checkbox" name="<?= $post->id;?>" class="custom-control-input" id="customCheck<?= $post->id;?>"  />
                        <label class="custom-control-label" for="customCheck<?= $post->id;?>"></label>
                    </div>
                </td>
                <td style="padding: 5px;">
                   
                    <?php 
                    if($img = $this->Query->postimage('thumbnail',$post)){
                        echo $this->html->image($img,['alt' => $post['title'],'class'=>'thumbnail','style'=>'width:50px;height:50px;' ]);
                    }?>
                    
                </td>
                <td><?= h($post->title) ?> 
                <?= $post->publish;?>

                    <div class="dropdown chart-dropdown float-left">
                        <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i> 
                        <div class="dropdown-menu dropdown-menu-right">
                            <?= $this->html->link(__('ویرایش سریع'),'/admin/shop/home/postsMeta/'.$post->id,
                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'dropdown-item','escape'=>false,
                                'data-whatever'=>Router::url('/admin/shop/home/postsMeta/'.$post->id.'?nonav=1') ]);?>

                            <?= $this->html->link(__('مدیریت موجودی'),'/admin/shop/home/postsStock/'.$post->id,
                                ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'dropdown-item','escape'=>false,
                                'data-whatever'=>Router::url('/admin/shop/home/postsStock/'.$post->id.'?nonav=1') ]);?>
                        </div>
                    </div>

                    <div class="hidme" style="padding-bottom: 5px;">
                        <?= $this->Query->permalink(__('نمایش'),$post);?>
                        <?= $this->Auths->link(__('ویرایش'), ['action' => 'Edit', $post->id],[]) ?>
                        <?php /* $this->Auths->link('حذف',
                            ['action'=>'Delete',$post->id ],
                            ['confirm'=>'برای حذف مطمئن هستید؟']); */?>
                    </div>
                </td>
                <td>
                    <?php /*  if($cat_access):?>
                        <?php foreach($post->categories as $cat){echo $this->Auths->link($cat['title'],'#').' ';} ?>
                    <?php endif;?>
                    <?php if($tag_access):?>
                        <?php foreach($post->tags as $tag){echo $this->Auths->link($tag['title'],'#').' ';} ?>
                    <?php endif; */?>

                    <?php if($cat_access):?>
                        <?php foreach($post->categories as $cat){
                        echo ''.
                            $this->Auths->link(
                                '<span class="badge badge-light-secondary">'.$cat['title'].'</span>',
                                ['?'=>['post_type'=> $post_types ,'categorie' => $cat['id']]],
                                ['escape'=>false]).'</span>';
                        } ?><br>
                    <?php endif;?>

                    <?php if($tag_access):?>
                        <?php foreach($post->tags as $tag){
                            echo $this->Auths->link(
                                '<span class="badge badge-light-primary">'.$tag['title'].'</span>',
                                ['?'=>['post_type'=> $post_types ,'tag' => $tag['id']]],
                                ['escape'=>false]).' ';} ?>
                    <?php endif;?>

                    
                    <br>
                    <?php // pr(ShopHelper::getStock($post->id));?>
                </td>
                <td><?= $this->cell('Postviews.View::view',[$post->id]);?></td>
                <td><?= $this->Func->date2($post->created)?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <?= $this->Form->end(); ?>
    </table></div>
</div></div>


<div class="paginator">
    <p class="float-left pt-1">
        <?= $this->Paginator->counter(['format' => __('صفحه {{page}} از {{pages}} / درحال نمایش {{current}} رکورد از {{count}} ')]) ?>
        </p>

    <ul class="pagination pagination-rounded pagination mt-4">
        <?php
        $this->Paginator->setTemplates([
            'prevDisabled' => '<li class="page-item disabled"><a class="page-link disabled" href="{{url}}">قبلی</a></li>',
            'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">قبلی</a></li>',
            'nextDisabled' => '<li class="page-item disabled"><a class="page-link disabled">بعدی</a></li>',
            'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">بعدی</a></li>',
            'first' => '<li class="page-item"><a class="page-link" href="{{url}}">اولین</a></li>',
            'last' => '<li class="page-item"><a class="page-link" href="{{url}}">آخرین</a></li>',
            'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>'
        ]);
        ?>
        <?= $this->Paginator->first('<< ' . __('اولین'),['class'=>'page-link']) ?>
        <?= $this->Paginator->prev('< ' . __('قبلی'),['class'=>'page-link']) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('بعدی') . ' >',['class'=>'page-link']) ?>
        <?= $this->Paginator->last(__('آخرین') . ' >>',['class'=>'page-link']) ?>
    </ul>
</div>

<script nonce="<?=get_nonce?>">
$('#dbutton').on('click',function(e) {
    $('.dlistbutton').removeClass('d-none');
    $('.box-shadow').attr("style",'background: none;');
    $('#dbutton').addClass('d-none');
    $('.submit').attr('style','display: initial;');
});
$('.dbutton2').on('click',function(e) {
    if (confirm("Are u sure to delete") == true) {
        $('form#dall').submit();
    }
});
</script>