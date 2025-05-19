<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Admin', 'مدیریت کاربران');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link(
                            __d('Admin', 'ثبت کاربر جدید'),
                            ['action'=>'Add'],
                            ['class'=>'btn btn-sm btn-primary']); ?>

                        <?= $this->Form->postlink(
                            __d('Admin', 'خروجی Excel'),
                            ['?'=>['csv'=>true]],
                            ['class'=>'btn btn-sm btn-secondary mx-1']); ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
        <div class="row">
                <?= $this->Form->control('text', [
                'label'=>false,
                'type' => 'text', 
                'class' => 'form-control form-control-sm',
                'placeholder'=>__d('Admin', 'عنوان را وارد کنید'),
                'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):''),
                ]);?>

                <?= $this->Form->button(
                    __d('Admin', 'جستجو'),
                    ['class'=>'btn btn-success btn-sm ml-1']);?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>


<div class="card"><div class="card-body">

    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort(' ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('family',__d('Admin', 'نام و نام خانوادگی')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('username',__d('Admin', 'نام کاربری')) ?></th>
                <th scope="col"><?= $this->Paginator->sort(__d('Admin', 'لاگین فعال')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('role',__d('Admin', 'حق دسترسی')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('created',__d('Admin', 'تاریخ ثبت')) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach ($users as $user):?>
            <tr>
                <td><?= $i++ ;?></td>
                <td>
                    <?= $user->family!=''?h($user->family) :$user->username; ?>
                    <?= $user->enable == 0?'<span class="badge badge-danger fw-n">'.__d('Admin', 'غیرفعال').'</span>':null; ?>
                    <div class="hidme">
                        <?= $this->Auths->link(__d('Admin', 'مشاهده'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Auths->link(__d('Admin', 'ویرایش'), ['action' => 'Edit', $user->id]) ?>
                        <?= $this->Auths->link(
                            __d('Admin', 'گزارشات'), 
                            ['plugin'=>'Userslogs','controller'=>'Home','action' => 'index', $user->id],
                            ['title'=> 'گزارش فعالیت های کاربر']) ?>
                        <?php // $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    </div>
                </td>
                <td><?= h($user->username) ?></td>
                <td><?php

                    
                    $cnt = 0;
                    foreach($activity as $ack => $acv){
                        if($acv['username'] ==  $user->username)
                            $cnt +=1;
                    }
                    echo $cnt!=0?$cnt.' '.__d('Admin', 'کاربر'):'-';
                    foreach($activity as $ack => $acv){
                        if($acv['username'] ==  $user->username)
                            echo '<span class="badge badge-secondary fw-n float-left">'.str_replace('_',' » ',$acv['url']).'</span><br>';
                    }
                    
                    if(isset($user['users_logs'][0]) ){
                        echo '<span '. 
                            'class="float-left badge fw-n '.($user['users_logs'][0]['types']==1?'badge-success':'badge-danger'). '" '.
                            'title="'.($user['users_logs'][0]['types']==1?
                                __d('Admin', 'ورود موفق'):
                                __d('Admin', 'ورود ناموفق')).'"'.
                            '">'.
                        $this->Func->date2($user['users_logs'][0]['created']).'</span>';
                    }
                    ?>
                </td>
                <td><?= $user->role?($user->role->title):'' ?></td>
                <td><?= $this->Query->the_time($user,'Y/m/d') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
