<h3><?= __d('Admin', 'پاسخ به دیدگاه');?></h3>
<div class="box box-primary">
    <div class="card-body">
    <?= $this->Form->create($comment) ?>

    <div class="row">
        <div class="col-sm-12"><div class="row">
            <?php
            echo $this->Form->control('author',[
                'type'=>'hidden',
                'class'=>'form-control',
                'templates' => [
                    'inputContainer' => '<div class="col-sm-4">{{content}}</div>',
                ],
                'div'=>'form-group']);
            echo $this->Form->control('author_email',[
                'type'=>'hidden',
                'class'=>'form-control',
                'templates' => [
                    'inputContainer' => '<div class="col-sm-4">{{content}}</div>',
                ],
                'div'=>'form-group']);
            echo $this->Form->control('author_url',[
                'type'=>'hidden',
                'class'=>'form-control',
                'templates' => [
                    'inputContainer' => '<div class="col-sm-4">{{content}}</div>',
                ]]);
            /* echo $this->Form->control('author_IP',[
                'type'=>'text',
                'class'=>'form-control',
                'div'=>'form-group']); */
            echo $this->Form->control('content',[
                'type'=>'textarea',
                'value'=>'',
                'class'=>'form-control',
                'rows'=>10,
                'templates' => [
                    'inputContainer' => '<div class="col-sm-12">{{content}}</div>',
                ]]);
            ?>
        </div></div>

        <?php
        echo $this->Form->control('post_id', [
            'type' => 'hidden',
            'class'=>'form-control',
            'div'=>'form-group']);
        
        echo $this->Form->control('approved',[
            'type'=>'hidden',
            'value'=>1,
            'class'=>'form-control',
            'div'=>'form-group']);
        echo $this->Form->control('post_type',[
            'type'=>'hidden',
            'class'=>'form-control',
            'div'=>'form-group']);
        echo $this->Form->control('parent_id',[
            'type'=>'hidden',
            'value'=>$comment['id'],
            'class'=>'form-control',
            'div'=>'form-group']);
        echo $this->Form->control('user_id', [
            'type' =>'hidden',
            'value'=> $this->request->getAttribute('identity')->get('id'),
            'class'=>'form-control',
            'div'=>'form-group']);?>
    </div>
        
        <br>
        <?= $this->Form->button( __d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']);?>
        <?= $this->Form->end(); ?>
    </div>
</div>
