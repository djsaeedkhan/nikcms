<?php $rand =rand(100,999);?>
<div class="card">
    <button class="btn btn-link text-right" data-toggle="collapse" data-target="#coll_<?= $post_type.$rand;?>" aria-expanded="true" aria-controls="coll_<?= $post_type.$rand;?>">
        <?php echo $title;?>
    </button>
    <div id="coll_<?= $post_type.$rand;?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body list_data">
            <?php
                echo $this->Form->control('post_type', ['type'=>'hidden', 'default'=>$post_type,'class'=>'post_type']);
                echo $this->Form->control('link', ['type'=>'hidden', 'default'=>'','class'=>'link']);
                echo $this->Form->control('type', ['type'=>'hidden', 'default'=>'category','class'=>'type']);
                echo $this->Form->control('groups', ['type'=>'select','class'=>'sareee', 'multiple'=>'checkbox','options'=>$data,'label'=>false]);
            ?>
        </div>
        <div class="card-body mihaan" style="padding: 10px;">
            <?= $this->Form->submit(
                 __d('Admin', 'افزودن به لیست'),[
                'type'=>'submit','label'=>false,'class'=>'pull-left btn btn-primary btn-sm']);?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>       