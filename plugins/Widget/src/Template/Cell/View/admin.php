<li class="mb-1" id="<?= isset($value['name'])?$value['name']:''?>" 
    data-id="<?= isset($value['name'])?$value['name']:''?>" 
    data-name="<?= isset($value['name'])?$value['name']:''?>" 
    data-widgetname = "<?= $widget['name']?>" 
    data-widget="<?= $widget['widget']?>" >
    <div class="card-header pl-1" style="padding: 10px;color: #82868b;font-size: 14px;">
        <i data-feather="more-vertical" class="drag" title="<?= __d('Widget','جابجایی ویجت')?>">:</i>
        <?= isset($widget['title'])?$widget['title']:__d('Widget','نامشخص')?>
        <i class="wid fa fa-close pull-left" title="<?=__d('Widget','حذف')?>" style="color: #9E9E9E;margin-top: 4px;cursor:pointer" data-feather='x'></i>
        <i data-feather='chevron-down' class="fa fa-caret-down pull-left" title="<?=__d('Widget','باز/بسته')?>" style="color: #9E9E9E;margin-top: 4px;cursor:pointer"></i>
    </div>
    <div class="card-body text-justify bg-white p-0">
        <div class="wgt-desc">
            <?= (isset($widget['desc']) and $widget['desc'] != null )?'
                <div class="px-1 pb-1"><span class="text-muted small">'.$widget['desc'].'</span></div>':''?>
        </div>
        <div class="wgt-text pb-1" style="padding-right:10px;padding-left:10px;" >
            <?php
            if(isset($widget['widget'])):
                echo '<form accept-charset="utf-8" id="f'.(isset($value['name'])?$value['name']:'').'" class="'.(isset($value['name'])?$value['name']:'').'" onsubmit="return false;">';
                $field = "sidebar_".(isset($value['name'])?$value['name']:'');
                $temp = [];
                if($tmp = $this->Func->OptionGet($field)){
                    $temp = json_decode(($tmp), true);
                }
                foreach($temp as $k => $tp){
                    unset($temp[$k]);
                    $name = str_replace(['[',']',$field],'',$k);
                    $temp[$name] = $tp;
                }
                echo $this->cell($widget['widget'].'::admin',[$field , $temp ]);
                echo $this->Form->control(__d('Widget','ثبت اطلاعات'),['type'=>'submit','class'=>'btn btn-primary btn-sm','escape'=>false]);
                echo $this->Form->end();
            endif;
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</li>