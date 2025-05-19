<?php
$list = [];
$temp = $this->Func->OptionGet('plugin_registerfield');
if( $temp != ''){
    foreach(unserialize($temp) as $k => $v){
        if(isset($v['query']) and $v['query'] != ''){
            $list[$v['query']] = $v['title'];
        }
    }
}

if(count($list)){?>
    <form method="get">
        <div class="row">
            <div class="mr-1">فیلد های ثبت نام</div>
            <?= $this->Form->control('type',[
                'empty'=>' -- ',
                'label' =>false,
                'type'=>'select',
                'options'=>$list,
                'class' =>'form-control form-control-sm',
                'default'=>($this->request->getQuery('type')),
                'onchange' =>"this.form.submit();",
            ])?>
        </div>
    </form>
<?php }?>