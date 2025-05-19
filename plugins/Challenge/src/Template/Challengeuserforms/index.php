<style>
.dropdown-menu .dropdown-item {
    font-size: 14px;
    letter-spacing: -0.4px;
}
.btn-group .dropdown-menu {
    left: 0 !important;
}
</style>
<h3>
    <?= __('لیست مشارکت ها') ?>

    <div class="btn-group btn-sm" role="group">
        <button class="btn btn-secondary btn-sm dropdown-toggle " id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">دانلود</button>
        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" >
            <?= $this->Form->postlink('فایل Excel لیست کل مشارکت ها',
                ['action'=>'index','?'=>['getlist'=>1]],['class'=>'dropdown-item'])?>

            <?= $this->Form->postlink('فایل Excel لیست مشارکت بر اساس کاربر',
                ['action'=>'index','?'=>['userforms'=>1]],['class'=>'dropdown-item'])?>


            <a href="#" class="dropdown-item"></a>

            <?= $this->Form->postlink('ایجاد فایل PDF کل مشارکت ها',
                ['controller'=>'challengeuserforms','action'=>'index','?'=>['create_all_pdf'=>'pdf']],
                ['class'=>'dropdown-item','confirm'=>'فایل PDF تمام مشارکت هایی که ساخته نشده اند ، ساخته می شود. در صورتی که از قبل وجود داشته باشد، ساخته نخواهند شد'])?> 

            <?= $this->Form->postlink('ایجاد فایل Word کل مشارکت ها',
                ['controller'=>'challengeuserforms','action'=>'index','?'=>['create_all_word'=>'word']],
                ['class'=>'dropdown-item','confirm'=>'فایل Word تمام مشارکت هایی که ساخته نشده اند ، ساخته می شود. در صورتی که از قبل وجود داشته باشد، ساخته نخواهند شد'])?> 

            <a href="#" class="dropdown-item"></a>
            
            <?= $this->Form->postlink('Zip فایل  Word مشارکت ها',
                ['controller'=>'challengeuserforms','action'=>'index','?'=>['zip'=>'word']],
                ['class'=>'dropdown-item','confirm'=>'ابتدا می بایست برای هر '.__d('Template', 'همیاری').' ، خروجی Word و PDF را انجام بدهید . این بخش فقط فایل هایی که خروجی (Word , Pdf) آن را قبلا ایجاد کرده باشید  بصورت Zip ذخیره میکند'])?> 
            
            <?= $this->Form->postlink('Zip فایل  PDF مشارکت ها',
                ['controller'=>'challengeuserforms','action'=>'index','?'=>['zip'=>'pdf']],
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
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('کدپیگیری') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('عنوان راهکار') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('عنوان '.__d('Template', 'همیاری').'') ?></th>
                <th scope="col"><?= $this->Paginator->sort('نام کاربر') ?></th>
                <th scope="col"><?= $this->Paginator->sort('فایل ضمیمه') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('enable') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('تایید') ?></th>
                <th scope="col"><?= $this->Paginator->sort('تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challengeuserforms as $challengeuserform): ?>
            <tr>
                <td><?= $this->Number->format($challengeuserform->id) ?></td>
                <td><?= h($challengeuserform->token1) ?></td>
                <!-- <td><?= h($challengeuserform->title) ?></td> -->
                <td>
                    <?= $challengeuserform->has('challenge') ? $this->Html->link($challengeuserform->challenge->title, ['controller' => 'Challenges', 'action' => 'view', $challengeuserform->challenge->id]) : '' ?>

                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش'), ['action' => 'view', $challengeuserform->id]) ?>
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'edit', $challengeuserform->id]) ?>
                        <?= $this->Form->postlink(__('حذف'), ['action' => 'delete', $challengeuserform->id], ['nonce'=>get_nonce,'confirm' => __('Are you sure you want to delete # {0}?', $challengeuserform->id)]) ?>
                    </div>
                
                </td>
                <td><?= isset($challengeuserform->user->username) ? $this->Html->link(
                    $challengeuserform->user->family.' ('.$challengeuserform->user->username.')', 
                    ['plugin'=>'admin','controller' => 'Users', 'action' => 'view', $challengeuserform->user->id]) : '' ?></td>
                <td>
                    <?= $challengeuserform->filesrc!=''?$this->Html->link('دانلود','/challenge/'.$challengeuserform->filesrc):'-' ?> 
                    <?= $challengeuserform->filesrc2!=''?$this->Html->link('دانلود','/challenge/'.$challengeuserform->filesrc2):'' ?> 
                    <?= $challengeuserform->filesrc3!=''?$this->Html->link('دانلود','/challenge/'.$challengeuserform->filesrc3):'' ?> 
                </td>
                <td><?= h($challengeuserform->approved) ?></td>
                <td><?= $this->Query->the_time($challengeuserform) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>