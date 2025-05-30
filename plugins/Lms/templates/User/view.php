<?php
use Lms\Predata;
$predata = new Predata;
?>
    <h3>کاربر: <?= h($user->username) ?></h3>
    <div class="card"><div class="card-body">
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
            <th scope="row"><?= __('تلفن') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('نوع کاربری') ?></th>
            <td><?= $user->has('role') ? $user->role->title : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('توکن') ?></th>
            <td><?= h($user->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('وضعیت اکانت') ?></th>
            <td><?= $user->enable ? __('فعال') : __('غیرفعال'); ?></td>
        </tr>
        </table></div>
    </div></div>


    <!-- <div class="related">
        <h4><?= __('Related Lms Coursefilecans') ?></h4>
        <?php if (!empty($user->lms_coursefilecans)): ?>
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-bordered ">
            <tr>
                <th scope="col"><?= __('Lms Coursefile Id') ?></th>
                <th scope="col"><?= __('Enable') ?></th>
                <!-- <th scope="col" class="actions"><?= __('Actions') ?></th> -->
            </tr>
            <?php foreach ($user->lms_coursefilecans as $lmsCoursefilecans): ?>
            <tr>
                <td><?= h($lmsCoursefilecans->lms_coursefile_id) ?></td>
                <td><?= h($lmsCoursefilecans->enable) ?></td>
                <!-- <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Coursefilecans', 'action' => 'view', $lmsCoursefilecans->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Coursefilecans', 'action' => 'edit', $lmsCoursefilecans->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Coursefilecans', 'action' => 'delete', $lmsCoursefilecans->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCoursefilecans->id)]) ?>
                </td> -->
            </tr>
            <?php endforeach; ?>
        </table></div>
        </div></div>
        <?php endif; ?>
    </div> -->

    <div class="related">
        
        <?php if (!empty($user->lms_courses)): ?>
        <br><h4><?= __('Related Lms Courses') ?></h4>
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-bordered ">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Text') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Show In List') ?></th>
                <th scope="col"><?= __('Can Add') ?></th>
                <th scope="col"><?= __('Enable') ?></th>
                <th scope="col"><?= __('Priority') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->lms_courses as $lmsCourses): ?>
            <tr>
                <td><?= h($lmsCourses->id) ?></td>
                <td><?= h($lmsCourses->title) ?></td>
                <td><?= h($lmsCourses->user_id) ?></td>
                <td><?= h($lmsCourses->text) ?></td>
                <td><?= h($lmsCourses->image) ?></td>
                <td><?= h($lmsCourses->show_in_list) ?></td>
                <td><?= h($lmsCourses->can_add) ?></td>
                <td><?= h($lmsCourses->enable) ?></td>
                <td><?= h($lmsCourses->priority) ?></td>
                <td><?= $this->Func->date2($lmsCourses->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Courses', 'action' => 'view', $lmsCourses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Courses', 'action' => 'edit', $lmsCourses->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Courses', 'action' => 'delete', $lmsCourses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCourses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div>
    
    <div class="related">
        <?php if (!empty($user->lms_examresults)): ?>
        <br><h4><?= __('لیست آزمون ها') ?></h4>
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-bordered ">
            <tr>
                <th scope="col"><?= __('عنوان آزمون') ?></th>
                <th scope="col"><?= __('کلید') ?></th>
                <th scope="col"><?= __('نتیجه آزمون') ?></th>
                <th scope="col"><?= __('تاریخ ثبت') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->lms_examresults as $lmsExamresults): ?>
            <tr>
                <td><?= h($lmsExamresults->lms_exam->title) ?></td>
                <td><?= h($lmsExamresults->token) ?></td>
                <td><?= $predata->getvalue('exam_result',$lmsExamresults->result) ?></td>
                <td><?= $this->Func->date2($lmsExamresults->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('نمایش'), ['controller' => 'Examresults', 'action' => 'edit', $lmsExamresults->id]) ?>
                    <?= $this->Form->postlink(__('حذف'), ['controller' => 'Examresults', 'action' => 'delete', $lmsExamresults->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamresults->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div>


    <!-- <div class="related">
        <?php if (!empty($user->lms_examusers)): ?>
        <br><h4><?= __('Related Lms Examusers') ?></h4>
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-bordered ">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Lms Exam Id') ?></th>
                <th scope="col"><?= __('Token') ?></th>
                <th scope="col"><?= __('Final Result') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->lms_examusers as $lmsExamusers): ?>
            <tr>
                <td><?= h($lmsExamusers->id) ?></td>
                <td><?= h($lmsExamusers->user_id) ?></td>
                <td><?= h($lmsExamusers->lms_exam_id) ?></td>
                <td><?= h($lmsExamusers->token) ?></td>
                <td><?= h($lmsExamusers->final_result) ?></td>
                <td><?= $this->Func->date2($lmsExamusers->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Examusers', 'action' => 'view', $lmsExamusers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Examusers', 'action' => 'edit', $lmsExamusers->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Examusers', 'action' => 'delete', $lmsExamusers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamusers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div> -->


    <div class="related">
        <?php if (!empty($user->lms_usernotes)): ?>
        <br><h4><?= __('نوت های ثبت شده') ?></h4>
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-bordered ">
            <tr>
                <th scope="col"><?= __('Lms Course Id') ?></th>
                <th scope="col"><?= __('Lms Coursefile Id') ?></th>
                <th scope="col"><?= __('Text') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->lms_usernotes as $lmsUsernotes): ?>
            <tr>
                <td><?= h($lmsUsernotes->lms_course_id) ?></td>
                <td><?= h($lmsUsernotes->lms_coursefile_id) ?></td>
                <td><?= h($lmsUsernotes->text) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Usernotes', 'action' => 'view', $lmsUsernotes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Usernotes', 'action' => 'edit', $lmsUsernotes->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Usernotes', 'action' => 'delete', $lmsUsernotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsUsernotes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div>


    <!-- <div class="related">
        <?php if (!empty($user->lms_userprofiles)): ?>
        <br><h4><?= __('Related Lms Userprofiles') ?></h4>
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-bordered ">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->lms_userprofiles as $lmsUserprofiles): ?>
            <tr>
                <td><?= h($lmsUserprofiles->id) ?></td>
                <td><?= h($lmsUserprofiles->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Userprofiles', 'action' => 'view', $lmsUserprofiles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Userprofiles', 'action' => 'edit', $lmsUserprofiles->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Userprofiles', 'action' => 'delete', $lmsUserprofiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsUserprofiles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div> -->


    <!-- <div class="related">
        <?php if (!empty($user->profiles)): ?>
        <br><h4><?= __('Related Profiles') ?></h4>
        <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-bordered ">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Family') ?></th>
                <th scope="col"><?= __('Bio') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->profiles as $profiles): ?>
            <tr>
                <td><?= h($profiles->id) ?></td>
                <td><?= h($profiles->user_id) ?></td>
                <td><?= h($profiles->family) ?></td>
                <td><?= h($profiles->bio) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Profiles', 'action' => 'view', $profiles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Profiles', 'action' => 'edit', $profiles->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['controller' => 'Profiles', 'action' => 'delete', $profiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $profiles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table></div>
        </div></div>
        <?php endif; ?>
    </div> -->