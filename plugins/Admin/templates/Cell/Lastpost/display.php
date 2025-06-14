<div class="col-lg-<?= isset($setting['col'])?$setting['col']:'6'?>">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
            <?= isset($setting['title'])?$setting['title']: __d('Admin', 'نامشخص')?>
            </h4>
        </div>
        <div class="card-body p-0">
            <ul class="list-group">
            <?php 
            global $result;
            foreach($last_post as $result):?>
                <li class="list-group-item list-group-item-action justify-content-between align-items-center">
                    <span class="text-muted"><?= h($this->Query->the_time($result));?></span> &nbsp;&nbsp;
                    <?= $this->Auths->link($result['title'],['controller'=>'Posts','action'=>'edit',$result['id']]);?>
                    <?= $result['published'] == 0?'<small class="float-left">'.  __d('Admin', 'پیش نویس').'</small>':'';?>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>