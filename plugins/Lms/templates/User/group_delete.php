<h3>حذف گروهی کاربر</h3>
<?php 
echo $this->Form->create(null);
echo $this->Form->control('user_id', [
    'label'=>'انتخاب کاربران','style'=>'min-height: 250px !important;',
    'multiple'=>'multiple',
    'class'=>'select2 form-control mb-2',
    'default'=>(($this->request->getQuery('user_id'))?$this->request->getQuery('user_id'):false),
    'options' => $users]);
?>
<?= $this->Form->button(__('حذف کاربران'),['class'=>'mt-1 mb-3 btn btn-sm btn-danger']);?>
<?= $this->Form->end() ?>