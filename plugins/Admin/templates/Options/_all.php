<h3><?= __d('Admin', 'همه تنظیمات');?></h3>
<div class="box box-primary"><div class="card-body">
    <?php
    echo $this->Form->create(null, ['class'=>'col-sm-6','url'=>['action'=>'SaveSetting']]);

    $field = [
        ['name'=>'st__login_background','type'=>'', 'label'=>'تصویر پس زمینه لوگین','dir'=>'l'],
        ['name'=>'st__register_info','type'=>'textarea','label'=>'توضیحات ثبت نام','dir'=>'l'],
        [],
        ['name'=>'st__plugin_avlist','type'=>'textarea','label'=>'پلاگین های فعال','dir'=>'l'],
        ['name'=>'','type'=>'','label'=>'','dir'=>''],
        //['name'=>'','type'=>'','label'=>'','dir'=>''],
    ];

    foreach($field as $fld):if(isset($fld['name'])):
        echo $this->Form->control($fld['name'], [
            'type'=>$fld['type']==''?'text':$fld['type'],
            'label'=>$fld['label'],
            'dir'=>$fld['dir']==''?'rtl':'ltr',
            'default'=>isset($result[$fld['name']])?$result[$fld['name']]:'',
            'class'=>'form-control mb-3']);
        else:
        echo '<hr><br>';
        endif;
    endforeach;
    ?>
    <br><br>
    <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']);?>
    <?= $this->Form->end() ?>
</div></div>