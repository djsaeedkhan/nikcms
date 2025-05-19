<h3><?= (isset($comment['id'])? __d('Admin', 'ویرایش دیدگاه'): __d('Admin', 'ثبت دیدگاه'))?></h3>
<div class="box box-primary">
    <div class="card-body">
    <?= $this->Form->create($comment) ?>

    <div class="row">
        <div class="col-sm-8"><div class="row">
            <?php
            echo $this->Form->control('author',[
                'type'=>'text',
                'class'=>'form-control',
                'templates' => [
                    'inputContainer' => '<div class="col-sm-4">{{content}}</div>',
                ],
                'div'=>'form-group']);

            echo $this->Form->control('author_email',[
                'type'=>'text',
                'class'=>'form-control',
                'templates' => [
                    'inputContainer' => '<div class="col-sm-4">{{content}}</div>',
                ],
                'div'=>'form-group']);

            echo $this->Form->control('author_url',[
                'type'=>'text',
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
                'class'=>'form-control',
                'rows'=>10,
                'templates' => [
                    'inputContainer' => '<div class="col-sm-12">{{content}}</div>',
                ]]);
            ?>
        </div></div>

        <div class="col-sm-4">
            <?php
            echo  __d('Admin', 'نمایش پست: ').

            $this->Auths->link(
                $comment['post']['title'],
                ['controller'=>'Posts','action'=>'edit',$comment['post']['id']],
                ['class'=>'btn btn-primary']
                ).'<br><br>';

            /* echo $this->Form->control('post_id', [
                'options' => $posts,
                'class'=>'form-control',
                'div'=>'form-group']); */

            echo $this->Form->control('approved',[
                'type'=>'select',
                'options'=>[
                    0 =>  __d('Admin', 'پذیرفته نشده'),
                    1 =>  __d('Admin', 'پذیرفته شده')
                ],
                'class'=>'form-control',
                'div'=>'form-group']);

            echo $this->Form->control('post_type',[
                'type'=>'hidden',
                'class'=>'form-control',
                'div'=>'form-group']);

            echo $this->Form->control('parent_id',[
                'type'=>'hidden',
                'class'=>'form-control',
                'div'=>'form-group']);

            echo $this->Form->control('user_id', [
                'options' => $users,
                'class'=>'form-control',
                'div'=>'form-group']);?>
        </div>
    </div>
        <br>
        <?= $this->Form->button( __d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']);?>
        <?= $this->Form->end(); ?>
    </div>
</div>
