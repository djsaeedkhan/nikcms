<?php
use Challenge\Predata;
$predata = new Predata();
?>
<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= h($user->family) ?> (<?= h($user->username) ?>)
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <div class="btn-group pull-left" role="group">
                            <?= $this->html->link('ویرایش پسورد',
                                ['plugin'=>'Admin','controller'=>'Users','action'=>'edit',$user->id],['class'=>'btn btn-sm btn-primary mr-11'])?>
                            <?= $this->html->link('ویرایش پروفایل',
                                ['action'=>'add',$user->id],['class'=>'btn btn-sm btn-secondary'])?>
                                  
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card cart1"><div class="card-body">
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="row" width="200"><?= __('نام کاربری') ?></th>
                <td><?= h($user->username) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('نام و نام خانوادگی') ?></th>
                <td><?= h($user->family) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('آدرس ایمیل') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('شماره تماس') ?></th>
                <td><?= h($user->phone) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('حق دسترسی') ?></th>
                <td><?= $user->has('role') ? $this->Html->link($user->role->title, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('تاریخ ثبت') ?></th>
                <td><?= $this->Func->date2($user->created) ?></td>
            </tr>
        
            <tr>
                <th scope="row"><?= __('وضعیت ') ?></th>
                <td><?= $user->enable ? __('فعال') : __('غیرفعال'); ?></td>
            </tr>
            </table></div>
        </div></div> 
    </div>
    <div class="col-sm-6">
        <?php if (!empty($user->challengeuserprofile)):
            $challengeuserprofiles = $user->challengeuserprofile; ?>
            <div class="card cart1"><div class="card-body">
                <h4><?= __('اطلاعات پروفایل کاربری') ?></h4>
                <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                <?php //foreach ($user->challengeuserprofiles as $challengeuserprofiles): ?>
                <tr>
                    <th scope="col" width="200"><?= __('جنسیت') ?></th>
                    <td><?= h($predata->getvalue('gender',$challengeuserprofiles['gender'])) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('استان') ?></th>
                    <td>
                        <?= isset($challengeuserprofiles['provice'])?$this->Func->province_list($challengeuserprofiles['provice']):'' ?>
                    </td>
                </tr>
                <tr>
                    <th scope="col"><?= __('تاریخ تولد') ?></th>
                    <td><?= h($challengeuserprofiles['birth_date']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('نوع مشارکت') ?></th>
                    <td><?= h($predata->getvalue('group',$challengeuserprofiles['single'])) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('آخرین مدرک تحصیلی') ?></th>
                    <td><?= h($predata->getvalue('eductions',$challengeuserprofiles['eductions'])) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('آدرس ایمیل') ?></th>
                    <td><?= h($challengeuserprofiles['email']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('شماره موبایل') ?></th>
                    <td><?= h($challengeuserprofiles['mobile']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('نوع مرکز') ?></th>
                    <td><?= h($predata->getvalue('center',$challengeuserprofiles['center'])) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('نام مرکز') ?></th>
                    <td><?= h($challengeuserprofiles['enter_name']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('سِمت') ?></th>
                    <td><?= h($challengeuserprofiles['semat']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('کدملی') ?></th>
                    <td><?= h($challengeuserprofiles['codemeli']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('رشته تحصیلی') ?></th>
                    <td><?= h($challengeuserprofiles['field']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('دانشگاه محل تحصیل') ?></th>
                    <td><?= h($challengeuserprofiles['univercity']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('تصویر پروفایل') ?></th>
                    <td><?= h($challengeuserprofiles['image']) ?></td>
                </tr>
                <tr>
                    <th scope="col"><?= __('حوزه تخصصی') ?></th>
                    <td>
                        <?php 
                        foreach($challengeuserprofiles->challengetopics as $topic):
                            echo '<span class="badge badge-info mr-1">'.$topic->title.'</span>';
                        endforeach;?>
                    </td>
                </tr>
                <!-- <tr>
                    <th scope="col"><?= __('دسترسی') ?></th>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Challengeuserprofiles', 'action' => 'view', $challengeuserprofiles->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeuserprofiles', 'action' => 'edit', $challengeuserprofiles->id]) ?>
                        <?= $this->Form->postlink(__('Delete'), ['controller' => 'Challengeuserprofiles', 'action' => 'delete', $challengeuserprofiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeuserprofiles->id)]) ?>
                    </td>
                </tr> -->
                <?php //endforeach; ?>
                </table></div>
            </div></div>
        <?php endif; ?>
    </div>

</div>
        
   
<div>    
    <div class="related">
        
        <?php if (!empty($user->challengefollowers)): ?>
        <h4><?= __d('Template', 'همیاری').' های پیگیر شده' ?></h4>
        <div class="card cart1"><div class="card-body">
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="col"><?= __('نام') ?></th>
                <th scope="col"><?= __('تاریخ ثبت') ?></th>
            </tr>
            <?php foreach ($user->challengefollowers as $challengefollowers): ?>
            <tr>
                <td><?= isset($challengefollowers->challenge->title)?h($challengefollowers->challenge->title):'-';?></td>
                <td><?= $this->Func->date2($challengefollowers->created) ?></td>
                <!-- <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Challengefollowers', 'action' => 'view', $challengefollowers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Challengefollowers', 'action' => 'edit', $challengefollowers->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Challengefollowers', 'action' => 'delete', $challengefollowers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengefollowers->id)]) ?>
                </td> -->
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div>


    <div class="related">
        
        <?php if (!empty($user->challengeforums)): ?>
        <h4><?= __('نظرات ثبت شده') ?></h4>
        <div class="card cart1"><div class="card-body">
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="col"><?= 'نام '.__d('Template', 'همیاری').''?></th>
                <th scope="col"><?= __('عنوان') ?></th>
                <th scope="col"><?= __('متن') ?></th>
                <th scope="col"><?= __('وضعیت') ?></th>
                <th scope="col"><?= __('تاریخ ثبت') ?></th>
            </tr>
            <?php foreach ($user->challengeforums as $challengeforums): ?>
            <tr>
                <td><?= h($challengeforums->challenge_id) ?></td>
                <td><?= h($challengeforums->challengeforumtitle_id) ?></td>
                <td><?= h($challengeforums->text) ?></td>
                <td><?= h($challengeforums->enable) ?></td>
                <td><?= $this->Func->date2($challengeforums->created) ?></td>
                <!-- <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Challengeforums', 'action' => 'view', $challengeforums->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeforums', 'action' => 'edit', $challengeforums->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Challengeforums', 'action' => 'delete', $challengeforums->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeforums->id)]) ?>
                </td> -->
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div>


    <div class="related">
        
        <?php if (!empty($user->challengeuserforms)): ?>
        <h4><?= __('مشارکت های انجام شده') ?></h4>
        <div class="card cart1"><div class="card-body">
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="col"><?= 'نام '.__d('Template', 'همیاری').'' ?></th>
                <th scope="col"><?= __('Userinfo') ?></th>
                <th scope="col"><?= __('پیوست 1') ?></th>
                <th scope="col"><?= __('پیوست 2') ?></th>
                <th scope="col"><?= __('پیوست 3') ?></th>
                <th scope="col"><?= __('عنوان') ?></th>
                <th scope="col"><?= __('توضیحات 1') ?></th>
                <th scope="col"><?= __('توضیحات 2') ?></th>
                <th scope="col"><?= __('توضیحات 3') ?></th>
                <th scope="col"><?= __('توضیحات 4') ?></th>
                <th scope="col"><?= __('توضیحات 5') ?></th>
                <th scope="col"><?= __('توضیحات 6') ?></th>
                <th scope="col"><?= __('وضعیت') ?></th>
                <th scope="col"><?= __('تایید شده') ?></th>
                <th scope="col"><?= __('تاریخ ثبت') ?></th>
            </tr>
            <?php foreach ($user->challengeuserforms as $challengeuserforms): ?>
            <tr>
                <td><?= h($challengeuserforms->challenge_id) ?></td>
                <td><?= h($challengeuserforms->userinfo) ?></td>
                <td><?= h($challengeuserforms->filesrc) ?></td>
                <td><?= h($challengeuserforms->filesrc2) ?></td>
                <td><?= h($challengeuserforms->filesrc3) ?></td>
                <td><?= h($challengeuserforms->title) ?></td>
                <td><?= h($challengeuserforms->descr1) ?></td>
                <td><?= h($challengeuserforms->descr2) ?></td>
                <td><?= h($challengeuserforms->descr3) ?></td>
                <td><?= h($challengeuserforms->descr4) ?></td>
                <td><?= h($challengeuserforms->descr5) ?></td>
                <td><?= h($challengeuserforms->descr6) ?></td>
                <td><?= h($challengeuserforms->enable) ?></td>
                <td><?= h($challengeuserforms->approved) ?></td>
                <td><?= $this->Func->date2($challengeuserforms->created) ?></td>
                <!-- <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Challengeuserforms', 'action' => 'view', $challengeuserforms->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeuserforms', 'action' => 'edit', $challengeuserforms->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Challengeuserforms', 'action' => 'delete', $challengeuserforms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeuserforms->id)]) ?>
                </td> -->
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div>

    

    <!-- <div class="related">
        <h4><?= __('Related User Metas') ?></h4>
        <?php /*if (!empty($user->user_metas)): ?>
        <div class="card cart1"><div class="card-body">
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Meta Type') ?></th>
                <th scope="col"><?= __('Meta Key') ?></th>
                <th scope="col"><?= __('Meta Value') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->user_metas as $userMetas): ?>
            <tr>
                <td><?= h($userMetas->id) ?></td>
                <td><?= h($userMetas->user_id) ?></td>
                <td><?= h($userMetas->meta_type) ?></td>
                <td><?= h($userMetas->meta_key) ?></td>
                <td><?= h($userMetas->meta_value) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserMetas', 'action' => 'view', $userMetas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserMetas', 'action' => 'edit', $userMetas->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'UserMetas', 'action' => 'delete', $userMetas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userMetas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; */ ?>
    </div> -->
</div>
