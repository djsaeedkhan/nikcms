<h3><?= (isset($category['id'])?__d('Admin', 'ویرایش برچسب'):__d('Admin', 'ثبت برچسب جدید'))?></h3>
<div class="box box-primary">
    <div class="card-body">
    <?= $this->Form->create($tag,['class'=>'col-sm-12 col-md-8']) ?>
    <?php
        echo $this->Form->control('post_type',[
            'type'=>'hidden',
            'default'=>$post_types]);

        echo $this->Form->control('title',[
            'type'=>'text',
            'class'=>'form-control',
            'div'=>'form-group']);

        echo $this->Form->control('slug',[
            'type'=>'text',
            'class'=>'form-control',
            'div'=>'form-group']);

    ?><bR>
    <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    </div>
</div>
