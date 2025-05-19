<div class="col-lg-<?= isset($setting['col'])?$setting['col']:'6'?>">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
            <?= isset($setting['title'])?$setting['title']: __d('Admin', 'نامشخص')?>
            </h4>
        </div>

        <?= $this->Form->create(null, ['url'=>['controller'=>'Posts','action'=>'add']]);?>
        <?= $this->Form->control('post_type',['default'=>'post', 'type'=>'hidden']);?>
        <?= $this->Form->control('published',['default'=> 0, 'type'=>'hidden']);?>
        <?= $this->Form->control('user_id',['default'=>$this->getRequest()->getSession()->read('Auth.User.id'), 'type'=>'hidden']);?>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <input class="form-control" id="text-input" type="text" name="title" placeholder="<?= __d('Admin', 'عنوان نوشته')?>" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                <textarea class="form-control" id="textarea-input" name="content" rows="11" placeholder="<?= __d('Admin', 'متن')?>"></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">
            <i class="fa fa-dot-circle-o"></i> <?=  __d('Admin',"ثبت پیش نویس")?></button>
        </div>
    </div>
</div>