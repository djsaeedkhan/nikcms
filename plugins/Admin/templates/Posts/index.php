<!-- <?= $this->Form->postlink(__d('Admin', 'حذف'),['action'=>'Delete',12 ],[
        'confirm'=>__d('Admin', 'برای حذف مطمئن هستید؟')]);?> -->
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0"><?= $this->Func->get_label($post_types,'index_header');?></h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link( $this->Func->get_label($post_types,'index_add'),
                            ['action'=>'Add','?'=>['post_type'=>$post_types]],['class'=>'btn btn-sm btn-primary']);?>
                        
                        <span id="dbutton" class="btn btn-sm ml-1 btn-warning">
                            <?= __d('Admin', 'حذف')?>
                        </span>
                        <?= $this->Auths->link(
                            __d('Admin', 'حذف انتخاب شده ها'),
                            '#',
                            ['class'=>'btn ml-1 btn-sm btn-danger dlistbutton dbutton2 d-none']);?>
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
                'placeholder'=>__d('Admin', 'جستجو در عنوان و محتوا'),
                'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                ]);?>

            <?= $this->Form->button(__d('Admin', 'جستجو'),['class'=>'btn btn-sm btn-success ml-1']);?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>
<div class="row">
    <!-- <?= $this->Form->control('action',['label'=>'کارهای دسته جمعی',
        'type'=>'select',
        'options'=>[
            'delete'=>'حذف',
            'priority'=>'ویرایش اولویت'
        ]]);?> -->
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id',' ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title',__d('Admin', 'عنوان')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id',__d('Admin', 'نویسنده')) ?></th>

                <?php if(($cat_access = $this->Func->get_ptaccess($post_types,'category'))):?>
                    <th scope="col">
                        <?= __d('Admin', 'دسته بندی')?>
                    </th>
                <?php endif;?>

                <?php if(($tag_access = $this->Func->get_ptaccess($post_types,'tag'))):?>
                    <th scope="col" style="min-width: 12%">
                        <?= __d('Admin', 'برچسب')?>
                    </th>
                <?php endif;?>
                <th scope="col">
                    <?= __d('Admin', 'ترجمه')?>
                </th>
                <th scope="col">
                    <?= __d('Admin', 'تعداد نمایش')?>
                </th>
                <!-- <th scope="col"><?= __d('Admin', 'اولویت') ?></th> -->

                <th scope="col"><?= $this->Paginator->sort('created',__d('Admin', 'تاریخ ثبت') ) ?></th>
            </tr>
        </thead>

        <?= $this->Form->create(null, ['url'=>['action'=>'delete','list'],'type' => 'post','id'=>'dall','validate'=>false]); ?>
        <tbody>
            <?php foreach ($posts as $post): $metalist = $this->Func->MetaList($post);?>
            <tr class="<?= (!$post->published?'table-warning':'');?>">
                <td class="px-1"><?= ($post->id) ?>
                    <div class="custom-control custom-checkbox dlistbutton d-none">
                        <input type="checkbox" name="<?= $post->id;?>" class="custom-control-input" id="customCheck<?= $post->id;?>"  />
                        <label class="custom-control-label" for="customCheck<?= $post->id;?>"></label>
                    </div>
                </td>
                <td class="px-1">
                    
                    <?php 
                    if(isset($metalist['pin']) and $metalist['pin'] == 1)
                        echo '<span title="'.__d('Admin', 'پین شده').'"><i data-feather="flag"></i></span>';
                    ?>
                    <?= h($post->title) ?>
                    <?= $post->publish;?>
                    <div class="hidme">
                    <!--  -->
                    
                        <?= $this->Query->permalink(
                            __d('Admin', 'نمایش'),
                            $post);?>

                        <?= $this->Auths->link(__d('Admin', 'ویرایش'), 
                            ['action' => 'Edit', $post->id],[]) ?>

                        <!-- <?php /* $this->Form->postlink(
                            __d('Admin', 'حذف'),
                            ['action'=>'Delete',$post->id ],[
                            'confirm'=>__d('Admin', 'برای حذف مطمئن هستید؟'),'class'=>'d-none']); */?> -->
                           
                        <!-- <?php /* $this->Form->postlink(__d('Admin', 'حذف'),
                            ['action'=>'Delete',$post->id ],
                            ['class'=>'d-none']); */?> -->

                        <!-- <?php /* $this->Form->postlink(
                            __d('Admin', 'حذف'),
                            ['action'=>'Delete',$post->id ],
                            ['confirm'=>'برای حذف مطمئن هستید؟' ]); */?> -->

                    </div>
                </td>
                <td class="px-1">
                    <?= $post->has('user') ? $this->Auths->link($post->user->username, ['controller' => 'Users', 'action' => 'view', $post->user->id]) : '' ?>
                </td>
                
                <?php if($cat_access):?>
                    <td class="px-1"><?php foreach($post->categories as $cat){
                        echo $this->Auths->link(
                            '<span class="badge badge-light-secondary">'.$cat['title'].'</span>',
                            ['?'=>['post_type'=> $post_types ,'categorie' => $cat['id']]],
                            ['escape'=>false]);} ?></td>
                <?php endif;?>

                <?php if($tag_access):?>
                    <td class="px-1"><?php foreach($post->tags as $tag){
                        echo $this->Auths->link(
                            '<span class="badge badge-light-secondary">'.$tag['title'].'</span>',
                            ['?'=>['post_type'=> $post_types ,'tag' => $tag['id']]],
                            ['escape'=>false]);} ?></td>
                <?php endif;?>
                
                <td class="px-1">
                    <?php
                    if(isset($post['_i18n']) and is_array($post['_i18n'])){
                        $langlist = $this->Func->language_list();
                        foreach($post['_i18n'] as $trans){
                            if($trans['field'] == 'title'){
                                echo $this->html->link('<span class="badge badge-light-secondary fw-n">'.
                                (isset($langlist[$trans['locale']])?$langlist[$trans['locale']]:$trans['locale']).
                                '</span>'
                                ,['action'=>'Edit', $post->id , '?'=>['langview'=>$trans['locale']] ],['escape'=>false]);
                            }
                        }
                    }
                    ?>
                </td>
                
                <td class="px-1">
                    <?= $this->cell('Postviews.View::view',[$post->id]);?>
                </td>
                <!-- <td class="px-1">
                    <?= $this->Form->control('priority',[
                        'label'=>false,
                        'type'=>'text',
                        'maxlength'=>5,
                        'style'=>'width:70px;',
                        'class'=>'form-control ltr priority',])?>
                </td> -->
                
                <td class="px-1 small"><?= $this->Func->date2($post->created) ?></td>
            </tr>
            <?php endforeach; ?>

           <!--  <tr class="bg-transparent">
                <td colspan="7"></td>
                <td class="px-1">ddd</td>
                <td class="px-1 small"></td>
            </tr> -->
        </tbody>
        <?= $this->Form->end(); ?>
    </table></div>
</div></div>

<div class="paginator">
    <p class="float-left pt-1">
        <?= $this->Paginator->counter(['format' => __d('Admin', 'صفحه {{page}} از {{pages}} / درحال نمایش {{current}} رکورد از {{count}} ')]) ?>
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
        <?= $this->Paginator->first('<< ' . __d('Admin', 'اولین'),['class'=>'page-link']) ?>
        <?= $this->Paginator->prev('< ' . __d('Admin', 'قبلی'),['class'=>'page-link']) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__d('Admin', 'بعدی') . ' >',['class'=>'page-link']) ?>
        <?= $this->Paginator->last(__d('Admin', 'آخرین') . ' >>',['class'=>'page-link']) ?>
    </ul>
</div>

<script nonce="<?= get_nonce?>">
$('#dbutton').on('click',function(e) {
    $('.dlistbutton').removeClass('d-none');
    $('.box-shadow').attr("style",'background: none;');
    $('#dbutton').addClass('d-none');
    $('.submit').attr('style','display: initial;');
});
$('.dbutton2').on('click',function(e) {
    if (confirm("<?= __d('Admin', 'آیا برای حذف موارد انتخاب شده مطمین هستید؟')?>") == true) {
        $('form#dall').submit();
    }
});
$('.priority').on('keyup',function(e) {
    $(".priority").each(function(){
        var input = $(this).val();
        if(input != ""){
            var regex = new RegExp("^[0-9]+$");
            if(! regex.test(input)) {
                alert("<?= __d('Admin', 'لطفا فقط عدد وارد کنید.')?>");
                $(this).val("");
                return false;
            }
        }
        
    });
});

/* document.addEventListener('click', function(event) {
  let link = event.target.closest('[data-alert]')
  if (link) {
    let message = link.dataset.alert
    alert(message)
    event.preventDefault()
  }
  alert(link);
}) */

</script>

<style>
    .badge.badge-light-secondary{
        margin-left: 3px;
        margin-bottom: 2px;
    }
    .badge.badge-light-secondary:hover{
        color:#000;
    }
    .fw-n{
        font-weight: normal !important;
    }
</style>