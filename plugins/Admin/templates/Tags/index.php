<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= $this->Func->get_label($post_types,'tag_header');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link($this->Func->get_label($post_types,'index_add'),
                            ['action'=>'Add','?'=>['post_type'=>$post_types]],
                            ['class'=>'btn btn-sm btn-primary']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card-body">
        <?= $this->Form->create($tag, ['url'=>['action'=>'Add']]) ?>
        <?php
        echo $this->Form->control('post_type',[
            'type'=>'hidden',
            'default'=>$post_types]);

        echo $this->Form->control('title',[
            'type'=>'text',
            'label'=>__d('Admin', 'عنوان'),
            'class'=>'form-control mb-2']);

        echo $this->Form->control('slug',[
            'type'=>'text',
            'label'=>__d('Admin', 'نامک'),
            'class'=>'form-control mb-2']);

        echo $this->Form->control('description',[
            'type'=>'textarea',
            'label'=>__d('Admin', 'توضیحات'),
            'class'=>'form-control mb-2']);
            
        ?><bR>
        <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
        <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id',' ') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('title','عنوان') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('slug','نامک') ?></th>
                    <th scope="col" class="actions">تعداد نوشته</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($tags as $tags):
                $tag = $this->Query->category('post',[
                    'contain'=>'Posts',
                    'get_type'=>'first','id'=>$tags->id]); 
                ?>
                <tr>
                    <td><?= $this->Number->format($i++); ?></td>
                    <td><?= $tags->title ?>
                        <div class="hidme">
                            <?= $this->Auths->link(__d('Admin', 'نمایش'), ['action' => 'view', $tags->id]) ?>
                            <?= $this->Auths->link(__d('Admin', 'ویرایش'), ['action' => 'add', $tags->id]) ?>
                            <?= $this->Form->postLink(__d('Admin', 'حذف'), ['action' => 'delete', $tags->id], 
                                ['confirm' => __d('Admin', 'Are you sure you want to delete # {0}?', $tags->id)]) ?>
                        </div>
                    </td>
                    <td><?= $tags->slug ?></div>
                    <td><?php
                        if(isset($tag['posts'])){
                            echo $this->html->link(count($tag['posts'])> 0?count($tag['posts']):'',
                                ['controller'=>'Posts','?'=>['post_type'=> $post_types,'tag'=>$tags->id ]],
                                [
                                    'target'=>'_blank',
                                    'title'=>__d('Admin', 'نمایش پست های این تگ') 
                                ]);
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

