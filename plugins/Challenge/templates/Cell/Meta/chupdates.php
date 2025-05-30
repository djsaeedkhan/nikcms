<?php
use Cake\Routing\Router;
$setting = unserialize($this->Func->OptionGet('setting'));
$setting = $setting['hsite'];
?>
<div class="box d1-none">
    <div class="card-body">
        <?php
        echo $this->Form->control('PostMetas.challenge_id',[
            'class'=>'form-control mb-3',
            'label'=>'آیدی '.__d('Template', 'همیاری').'',
            'type'=>'text',
            'default'=>(isset($post_meta_list['challenge_id'])?$post_meta_list['challenge_id']:
                    (isset($this->request->getQuery()['challenge_id'])?$this->request->getQuery()['challenge_id'] : 0)
                ),
            ]);
        ?>
    </div>
</div>