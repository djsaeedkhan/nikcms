<h3>مدیریت <?=__d('Template', 'همیاری')?>
    <?= $this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-sm btn-primary'])?>
    <div class="btn-group" role="group">
        <button class="btn btn-sm btn-secondary dropdown-toggle " id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خروجی</button>
        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" >
            <?= $this->html->link('صفحه لیست کاربران',
                ['controller'=>'challengeusers','action'=>'index'],
                ['class'=>'dropdown-item'])?>
          
            <?php $this->Form->postlink('Zip فایل مشارکت ها',
                ['controller'=>'challengeuserforms','action'=>'index','?'=>['zip'=>1]],
                ['class'=>'dropdown-item','confirm'=>'ابتدا می بایست برای هر '.__d('Template', 'همیاری').' ، خروجی Word و PDF را انجام بدهید . این بخش فقط فایل هایی که خروجی (Word , Pdf) آن را قبلا ایجاد کرده باشید  بصورت Zip ذخیره میکند'])?> 
        </div>
    </div>
    
    <div class="pull-left ml-3">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
        <div class="row">
        <div class="pull-left">
            <?= $this->Form->control('text', [
                'label'=>false,
                'type' => 'text', 
                'class' => 'form-control form-control-sm',
                'placeholder'=>'عنوان را وارد کنید',
                'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                ]);?></div>
        <div class="pull-left">
            <?= $this->Form->button(__('جستجو'),['class'=>'btn btn-sm btn-success']);?></div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</h3>
<div class="clear clearfix"></div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ردیف') ?></th>
                <th scope="col"><?= $this->Paginator->sort('عنوان') ?></th>
                <th scope="col"><?= $this->Paginator->sort('میزان مشارکت') ?></th>
                <th scope="col"><?= $this->Paginator->sort('دنبال کنندگان') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('کاربر') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challenges as $post):?>
            <tr class="<?= (!$post->enable?'table-secondary':'');?>">
                <td><?= ($post->id) ?></td>
                <td>
                    <?= ($post->priority!= ''?'<span class="badge badge-secondary fw-n">اولویت: '.$post->priority.'</span>':'');?>
                        
                    <?= h($post->title) ?> 
                    <?= (!$post->enable?'<span class="badge badge-warning">غیرفعال</span>':'');?>

                    <div class="hidme">
                        <?= $this->html->link(__('جزئیات'), ['action' => 'view', $post->id]) ?>
                        <?= $this->html->link(__('مشارکت ها'), '/admin/challenge/challengeuserforms/index/'.$post->id) ?>
                        <?= $this->html->link(__('ویرایش'), ['action' => 'Edit', $post->id]) ?>
                        <!-- <?= $this->html->link('سوالات',['controller'=>'challengequests','action'=>'index',$post->id],['class'=>'badge badge-info'])?> -->
                        <?= $this->html->link('آمار',['controller'=>'challengequests','action'=>'report',$post->id],['class'=>''])?>
                        <?= $this->html->link('نمایش در سایت','/challenge/'.$post->slug,['target'=>'_blank'])?>
                    </div>
                </td>
                <td><?= count($post->challengeuserforms) ?> فرم</td>
                <td><?= count($post->challengefollowers) ?> نفر</td>
                <!-- <td><?= $post->has('user') ? $this->Auths->link($post->user->username, ['controller' => 'Users', 'action' => 'view', $post->user->id]) : '' ?></td> -->
                <td><?= $this->Query->the_time($post) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
