<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Formbuilder', 'مدیریت فرم ساز');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?=$this->Auths->link(__d('Formbuilder', 'فرم جدید'),['action'=>'add'],['class'=>'btn btn-sm btn-primary']);?>
                        <?=$this->Auths->link(__d('Formbuilder', 'آخرین فرمهای ثبت شده'),
                            ['action'=>'view','last'],
                            ['class'=>'btn btn-sm btn-secondary ml-1']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
        <div class="row">
            <?= $this->Form->control('text', [
                'label'=>false,
                'type' => 'text', 
                'class' => 'form-control form-control-sm',
                'placeholder'=>__d('Formbuilder', 'عنوان را وارد کنید'),
                'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):'') ]);?>
            <?= $this->Form->button(__d('Formbuilder', 'جستجو'),['class'=>'btn btn-sm btn-success ml-1']);?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <!-- <th scope="col"><?= $this->Paginator->sort('id',__d('Formbuilder', 'ردیف')) ?></th> -->
                <th scope="col"><?= __d('Formbuilder', 'نمایش توسط')?></th>
                <th scope="col"><?= $this->Paginator->sort('title',__d('Formbuilder', 'عنوان فرم')) ?></th>
                <th scope="col"><?=__d('Formbuilder', 'تعداد بازدید')?></th>
                <th scope="col"><?=__d('Formbuilder', 'فرم ثبت شده')?></th>
                <th scope="col">ShortCode</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;foreach ($results as $result):?>
            <tr>
                <!-- <td><?= ++$i;?></td> -->
                <td>
                    <?= $this->html->link(
                        __d('Formbuilder', 'آیدی'),
                        '/form/'.$result->id ,
                        ['target'=>'_blank'])?> / 
                    <?= $this->html->link(
                        __d('Formbuilder', 'عنوان'),
                        '/form/'.$result->title ,
                        ['target'=>'_blank'])?>
                </td>
                <td><?= h($result->title) ?>
                    <?= $result['enable'] == 0?'<span class="badge badge-danger">غیرفعال</span>':''?>
                    <div class="row-actions"><span class="hidme">
                        <?= $this->Auths->link(
                            __d('Formbuilder', 'ویرایش'),
                            ['action'=>'add',$result->id]);?>

                        <?= $this->Auths->link(
                            __d('Formbuilder', 'ویرایش Html'),
                            ['action'=>'edit',$result->id]);?>

                        <?= $this->Form->postlink(
                            __d('Formbuilder', 'حذف'),
                            ['action'=>'delete',$result->id],
                            ['confirm'=>__d('Formbuilder', 'برای حذف مطمئن هستید؟')]);?>
                        <?php 
                        if(count($result->formbuilder_datas) > 0):
                            echo $this->html->link(
                                __d('Formbuilder', 'نمایش نتایج'),
                                ['action'=>'view',$result->id],
                                ['class'=>'']);

                            echo $this->Form->postlink(
                                __d('Formbuilder', 'خروجی Excel'),
                                ['action'=>'view',$result->id,'?'=>['csv'=>true]],
                                ['class'=>'text-white badge btn-sm badge-success']);
                        endif;?>
                    </span></div>
                </td>
                
                <td><?= $result['counts']?></td>
                <td>
                    <?= count($result->formbuilder_datas) > 0?count($result->formbuilder_datas).' '.
                    __d('Formbuilder', 'فرم'):'0'?> 
                </td>
                <td style="direction:ltr;text-align:center">[code_formbuilder="<?=$result->id?>"]</td>
                
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>