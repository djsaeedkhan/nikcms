<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($user->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Family') ?></th>
                    <td><?= h($user->family) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($user->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $user->has('role') ? $this->Html->link($user->role->title, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expired') ?></th>
                    <td><?= h($user->expired) ?></td>
                </tr>
                <tr>
                    <th><?= __('Enable') ?></th>
                    <td><?= $user->enable ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Logs') ?></h4>
                <?php if (!empty($user->logs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Action Id') ?></th>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('Value') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->logs as $logs) : ?>
                        <tr>
                            <td><?= h($logs->id) ?></td>
                            <td><?= h($logs->user_id) ?></td>
                            <td><?= h($logs->action_id) ?></td>
                            <td><?= h($logs->group_id) ?></td>
                            <td><?= h($logs->value) ?></td>
                            <td><?= h($logs->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Logs', 'action' => 'view', $logs->]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Logs', 'action' => 'edit', $logs->]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Logs', 'action' => 'delete', $logs->], ['confirm' => __('Are you sure you want to delete # {0}?', $logs->)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challengetags') ?></h4>
                <?php if (!empty($user->challengetags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challengetags as $challengetags) : ?>
                        <tr>
                            <td><?= h($challengetags->id) ?></td>
                            <td><?= h($challengetags->title) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challengetags', 'action' => 'view', $challengetags->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challengetags', 'action' => 'edit', $challengetags->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challengetags', 'action' => 'delete', $challengetags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengetags->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challengeblueticks') ?></h4>
                <?php if (!empty($user->challengeblueticks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challengeblueticks as $challengeblueticks) : ?>
                        <tr>
                            <td><?= h($challengeblueticks->id) ?></td>
                            <td><?= h($challengeblueticks->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challengeblueticks', 'action' => 'view', $challengeblueticks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeblueticks', 'action' => 'edit', $challengeblueticks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challengeblueticks', 'action' => 'delete', $challengeblueticks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeblueticks->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challengefollowers') ?></h4>
                <?php if (!empty($user->challengefollowers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Challenge Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challengefollowers as $challengefollowers) : ?>
                        <tr>
                            <td><?= h($challengefollowers->id) ?></td>
                            <td><?= h($challengefollowers->challenge_id) ?></td>
                            <td><?= h($challengefollowers->user_id) ?></td>
                            <td><?= h($challengefollowers->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challengefollowers', 'action' => 'view', $challengefollowers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challengefollowers', 'action' => 'edit', $challengefollowers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challengefollowers', 'action' => 'delete', $challengefollowers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengefollowers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challengeforums') ?></h4>
                <?php if (!empty($user->challengeforums)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Challenge Id') ?></th>
                            <th><?= __('Challengeforumtitle Id') ?></th>
                            <th><?= __('Lft') ?></th>
                            <th><?= __('Rght') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challengeforums as $challengeforums) : ?>
                        <tr>
                            <td><?= h($challengeforums->id) ?></td>
                            <td><?= h($challengeforums->challenge_id) ?></td>
                            <td><?= h($challengeforums->challengeforumtitle_id) ?></td>
                            <td><?= h($challengeforums->lft) ?></td>
                            <td><?= h($challengeforums->rght) ?></td>
                            <td><?= h($challengeforums->user_id) ?></td>
                            <td><?= h($challengeforums->text) ?></td>
                            <td><?= h($challengeforums->enable) ?></td>
                            <td><?= h($challengeforums->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challengeforums', 'action' => 'view', $challengeforums->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeforums', 'action' => 'edit', $challengeforums->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challengeforums', 'action' => 'delete', $challengeforums->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeforums->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challengeqanswers') ?></h4>
                <?php if (!empty($user->challengeqanswers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Challenge Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Challengequest Id') ?></th>
                            <th><?= __('Value') ?></th>
                            <th><?= __('Types') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challengeqanswers as $challengeqanswers) : ?>
                        <tr>
                            <td><?= h($challengeqanswers->id) ?></td>
                            <td><?= h($challengeqanswers->challenge_id) ?></td>
                            <td><?= h($challengeqanswers->user_id) ?></td>
                            <td><?= h($challengeqanswers->challengequest_id) ?></td>
                            <td><?= h($challengeqanswers->value) ?></td>
                            <td><?= h($challengeqanswers->types) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challengeqanswers', 'action' => 'view', $challengeqanswers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeqanswers', 'action' => 'edit', $challengeqanswers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challengeqanswers', 'action' => 'delete', $challengeqanswers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeqanswers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challenges') ?></h4>
                <?php if (!empty($user->challenges)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Img') ?></th>
                            <th><?= __('Img1') ?></th>
                            <th><?= __('Img2') ?></th>
                            <th><?= __('Challengestatus Id') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Chtype') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challenges as $challenges) : ?>
                        <tr>
                            <td><?= h($challenges->id) ?></td>
                            <td><?= h($challenges->title) ?></td>
                            <td><?= h($challenges->slug) ?></td>
                            <td><?= h($challenges->descr) ?></td>
                            <td><?= h($challenges->priority) ?></td>
                            <td><?= h($challenges->img) ?></td>
                            <td><?= h($challenges->img1) ?></td>
                            <td><?= h($challenges->img2) ?></td>
                            <td><?= h($challenges->challengestatus_id) ?></td>
                            <td><?= h($challenges->start_date) ?></td>
                            <td><?= h($challenges->end_date) ?></td>
                            <td><?= h($challenges->user_id) ?></td>
                            <td><?= h($challenges->enable) ?></td>
                            <td><?= h($challenges->chtype) ?></td>
                            <td><?= h($challenges->price) ?></td>
                            <td><?= h($challenges->password) ?></td>
                            <td><?= h($challenges->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challenges', 'action' => 'view', $challenges->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challenges', 'action' => 'edit', $challenges->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challenges', 'action' => 'delete', $challenges->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challenges->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challengeuserforms') ?></h4>
                <?php if (!empty($user->challengeuserforms)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Challenge Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Userinfo') ?></th>
                            <th><?= __('Filesrc') ?></th>
                            <th><?= __('Filesrc2') ?></th>
                            <th><?= __('Filesrc3') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Descr1') ?></th>
                            <th><?= __('Descr2') ?></th>
                            <th><?= __('Descr3') ?></th>
                            <th><?= __('Descr4') ?></th>
                            <th><?= __('Descr5') ?></th>
                            <th><?= __('Descr6') ?></th>
                            <th><?= __('Token1') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challengeuserforms as $challengeuserforms) : ?>
                        <tr>
                            <td><?= h($challengeuserforms->id) ?></td>
                            <td><?= h($challengeuserforms->challenge_id) ?></td>
                            <td><?= h($challengeuserforms->user_id) ?></td>
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
                            <td><?= h($challengeuserforms->token1) ?></td>
                            <td><?= h($challengeuserforms->enable) ?></td>
                            <td><?= h($challengeuserforms->approved) ?></td>
                            <td><?= h($challengeuserforms->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challengeuserforms', 'action' => 'view', $challengeuserforms->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeuserforms', 'action' => 'edit', $challengeuserforms->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challengeuserforms', 'action' => 'delete', $challengeuserforms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeuserforms->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Challengeuserprofiles') ?></h4>
                <?php if (!empty($user->challengeuserprofiles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Gender') ?></th>
                            <th><?= __('Provice') ?></th>
                            <th><?= __('Birth Date') ?></th>
                            <th><?= __('Single') ?></th>
                            <th><?= __('Eductions') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Mobile') ?></th>
                            <th><?= __('Center') ?></th>
                            <th><?= __('Center Name') ?></th>
                            <th><?= __('Semat') ?></th>
                            <th><?= __('Codemeli') ?></th>
                            <th><?= __('Field') ?></th>
                            <th><?= __('Univercity') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Extra') ?></th>
                            <th><?= __('Image') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->challengeuserprofiles as $challengeuserprofiles) : ?>
                        <tr>
                            <td><?= h($challengeuserprofiles->id) ?></td>
                            <td><?= h($challengeuserprofiles->user_id) ?></td>
                            <td><?= h($challengeuserprofiles->gender) ?></td>
                            <td><?= h($challengeuserprofiles->provice) ?></td>
                            <td><?= h($challengeuserprofiles->birth_date) ?></td>
                            <td><?= h($challengeuserprofiles->single) ?></td>
                            <td><?= h($challengeuserprofiles->eductions) ?></td>
                            <td><?= h($challengeuserprofiles->email) ?></td>
                            <td><?= h($challengeuserprofiles->mobile) ?></td>
                            <td><?= h($challengeuserprofiles->center) ?></td>
                            <td><?= h($challengeuserprofiles->center_name) ?></td>
                            <td><?= h($challengeuserprofiles->semat) ?></td>
                            <td><?= h($challengeuserprofiles->codemeli) ?></td>
                            <td><?= h($challengeuserprofiles->field) ?></td>
                            <td><?= h($challengeuserprofiles->univercity) ?></td>
                            <td><?= h($challengeuserprofiles->descr) ?></td>
                            <td><?= h($challengeuserprofiles->extra) ?></td>
                            <td><?= h($challengeuserprofiles->image) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Challengeuserprofiles', 'action' => 'view', $challengeuserprofiles->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Challengeuserprofiles', 'action' => 'edit', $challengeuserprofiles->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Challengeuserprofiles', 'action' => 'delete', $challengeuserprofiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeuserprofiles->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Comments') ?></h4>
                <?php if (!empty($user->comments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Post Id') ?></th>
                            <th><?= __('Author') ?></th>
                            <th><?= __('Author Email') ?></th>
                            <th><?= __('Author Url') ?></th>
                            <th><?= __('Author IP') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Post Type') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Lft') ?></th>
                            <th><?= __('Rght') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->comments as $comments) : ?>
                        <tr>
                            <td><?= h($comments->id) ?></td>
                            <td><?= h($comments->post_id) ?></td>
                            <td><?= h($comments->author) ?></td>
                            <td><?= h($comments->author_email) ?></td>
                            <td><?= h($comments->author_url) ?></td>
                            <td><?= h($comments->author_IP) ?></td>
                            <td><?= h($comments->content) ?></td>
                            <td><?= h($comments->approved) ?></td>
                            <td><?= h($comments->post_type) ?></td>
                            <td><?= h($comments->parent_id) ?></td>
                            <td><?= h($comments->lft) ?></td>
                            <td><?= h($comments->rght) ?></td>
                            <td><?= h($comments->user_id) ?></td>
                            <td><?= h($comments->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Comments', 'action' => 'edit', $comments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comments', 'action' => 'delete', $comments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Formbuilder Datas') ?></h4>
                <?php if (!empty($user->formbuilder_datas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Formbuilder Id') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Field') ?></th>
                            <th><?= __('Ips') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->formbuilder_datas as $formbuilderDatas) : ?>
                        <tr>
                            <td><?= h($formbuilderDatas->id) ?></td>
                            <td><?= h($formbuilderDatas->formbuilder_id) ?></td>
                            <td><?= h($formbuilderDatas->data) ?></td>
                            <td><?= h($formbuilderDatas->field) ?></td>
                            <td><?= h($formbuilderDatas->ips) ?></td>
                            <td><?= h($formbuilderDatas->user_id) ?></td>
                            <td><?= h($formbuilderDatas->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'FormbuilderDatas', 'action' => 'view', $formbuilderDatas->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'FormbuilderDatas', 'action' => 'edit', $formbuilderDatas->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'FormbuilderDatas', 'action' => 'delete', $formbuilderDatas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $formbuilderDatas->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Certificates') ?></h4>
                <?php if (!empty($user->lms_certificates)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lms Course Id') ?></th>
                            <th><?= __('Input Data') ?></th>
                            <th><?= __('Image') ?></th>
                            <th><?= __('Download') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Alert') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Accepted') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_certificates as $lmsCertificates) : ?>
                        <tr>
                            <td><?= h($lmsCertificates->id) ?></td>
                            <td><?= h($lmsCertificates->user_id) ?></td>
                            <td><?= h($lmsCertificates->lms_course_id) ?></td>
                            <td><?= h($lmsCertificates->input_data) ?></td>
                            <td><?= h($lmsCertificates->image) ?></td>
                            <td><?= h($lmsCertificates->download) ?></td>
                            <td><?= h($lmsCertificates->status) ?></td>
                            <td><?= h($lmsCertificates->alert) ?></td>
                            <td><?= h($lmsCertificates->enable) ?></td>
                            <td><?= h($lmsCertificates->created) ?></td>
                            <td><?= h($lmsCertificates->accepted) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsCertificates', 'action' => 'view', $lmsCertificates->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsCertificates', 'action' => 'edit', $lmsCertificates->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsCertificates', 'action' => 'delete', $lmsCertificates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCertificates->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Coursefilecans') ?></h4>
                <?php if (!empty($user->lms_coursefilecans)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lms Course Id') ?></th>
                            <th><?= __('Lms Coursefile Id') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Types') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_coursefilecans as $lmsCoursefilecans) : ?>
                        <tr>
                            <td><?= h($lmsCoursefilecans->id) ?></td>
                            <td><?= h($lmsCoursefilecans->user_id) ?></td>
                            <td><?= h($lmsCoursefilecans->lms_course_id) ?></td>
                            <td><?= h($lmsCoursefilecans->lms_coursefile_id) ?></td>
                            <td><?= h($lmsCoursefilecans->enable) ?></td>
                            <td><?= h($lmsCoursefilecans->types) ?></td>
                            <td><?= h($lmsCoursefilecans->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsCoursefilecans', 'action' => 'view', $lmsCoursefilecans->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsCoursefilecans', 'action' => 'edit', $lmsCoursefilecans->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsCoursefilecans', 'action' => 'delete', $lmsCoursefilecans->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCoursefilecans->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Courses') ?></h4>
                <?php if (!empty($user->lms_courses)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Lms Coursecategorie Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Textweb') ?></th>
                            <th><?= __('Image') ?></th>
                            <th><?= __('Date Start') ?></th>
                            <th><?= __('Date End') ?></th>
                            <th><?= __('Date Type') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Price Special') ?></th>
                            <th><?= __('Price Renew') ?></th>
                            <th><?= __('Show In List') ?></th>
                            <th><?= __('Can Add') ?></th>
                            <th><?= __('Can Renew') ?></th>
                            <th><?= __('Renew Day') ?></th>
                            <th><?= __('Total Time') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Options') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_courses as $lmsCourses) : ?>
                        <tr>
                            <td><?= h($lmsCourses->id) ?></td>
                            <td><?= h($lmsCourses->title) ?></td>
                            <td><?= h($lmsCourses->lms_coursecategorie_id) ?></td>
                            <td><?= h($lmsCourses->user_id) ?></td>
                            <td><?= h($lmsCourses->text) ?></td>
                            <td><?= h($lmsCourses->textweb) ?></td>
                            <td><?= h($lmsCourses->image) ?></td>
                            <td><?= h($lmsCourses->date_start) ?></td>
                            <td><?= h($lmsCourses->date_end) ?></td>
                            <td><?= h($lmsCourses->date_type) ?></td>
                            <td><?= h($lmsCourses->price) ?></td>
                            <td><?= h($lmsCourses->price_special) ?></td>
                            <td><?= h($lmsCourses->price_renew) ?></td>
                            <td><?= h($lmsCourses->show_in_list) ?></td>
                            <td><?= h($lmsCourses->can_add) ?></td>
                            <td><?= h($lmsCourses->can_renew) ?></td>
                            <td><?= h($lmsCourses->renew_day) ?></td>
                            <td><?= h($lmsCourses->total_time) ?></td>
                            <td><?= h($lmsCourses->enable) ?></td>
                            <td><?= h($lmsCourses->priority) ?></td>
                            <td><?= h($lmsCourses->options) ?></td>
                            <td><?= h($lmsCourses->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsCourses', 'action' => 'view', $lmsCourses->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsCourses', 'action' => 'edit', $lmsCourses->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsCourses', 'action' => 'delete', $lmsCourses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCourses->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Coursesessions') ?></h4>
                <?php if (!empty($user->lms_coursesessions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Lms Course Id') ?></th>
                            <th><?= __('Lms Courseweek Id') ?></th>
                            <th><?= __('Lms Coursefile Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_coursesessions as $lmsCoursesessions) : ?>
                        <tr>
                            <td><?= h($lmsCoursesessions->id) ?></td>
                            <td><?= h($lmsCoursesessions->lms_course_id) ?></td>
                            <td><?= h($lmsCoursesessions->lms_courseweek_id) ?></td>
                            <td><?= h($lmsCoursesessions->lms_coursefile_id) ?></td>
                            <td><?= h($lmsCoursesessions->user_id) ?></td>
                            <td><?= h($lmsCoursesessions->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsCoursesessions', 'action' => 'view', $lmsCoursesessions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsCoursesessions', 'action' => 'edit', $lmsCoursesessions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsCoursesessions', 'action' => 'delete', $lmsCoursesessions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCoursesessions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Courseusers') ?></h4>
                <?php if (!empty($user->lms_courseusers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Lms Course Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_courseusers as $lmsCourseusers) : ?>
                        <tr>
                            <td><?= h($lmsCourseusers->id) ?></td>
                            <td><?= h($lmsCourseusers->lms_course_id) ?></td>
                            <td><?= h($lmsCourseusers->user_id) ?></td>
                            <td><?= h($lmsCourseusers->status) ?></td>
                            <td><?= h($lmsCourseusers->enable) ?></td>
                            <td><?= h($lmsCourseusers->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsCourseusers', 'action' => 'view', $lmsCourseusers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsCourseusers', 'action' => 'edit', $lmsCourseusers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsCourseusers', 'action' => 'delete', $lmsCourseusers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCourseusers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Examresultlists') ?></h4>
                <?php if (!empty($user->lms_examresultlists)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lms Examresult Id') ?></th>
                            <th><?= __('Lms Exam Id') ?></th>
                            <th><?= __('Lms Examquest Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Answer') ?></th>
                            <th><?= __('Result') ?></th>
                            <th><?= __('Filesrc') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_examresultlists as $lmsExamresultlists) : ?>
                        <tr>
                            <td><?= h($lmsExamresultlists->id) ?></td>
                            <td><?= h($lmsExamresultlists->user_id) ?></td>
                            <td><?= h($lmsExamresultlists->lms_examresult_id) ?></td>
                            <td><?= h($lmsExamresultlists->lms_exam_id) ?></td>
                            <td><?= h($lmsExamresultlists->lms_examquest_id) ?></td>
                            <td><?= h($lmsExamresultlists->token) ?></td>
                            <td><?= h($lmsExamresultlists->answer) ?></td>
                            <td><?= h($lmsExamresultlists->result) ?></td>
                            <td><?= h($lmsExamresultlists->filesrc) ?></td>
                            <td><?= h($lmsExamresultlists->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsExamresultlists', 'action' => 'view', $lmsExamresultlists->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsExamresultlists', 'action' => 'edit', $lmsExamresultlists->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsExamresultlists', 'action' => 'delete', $lmsExamresultlists->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamresultlists->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Examresults') ?></h4>
                <?php if (!empty($user->lms_examresults)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lms Exam Id') ?></th>
                            <th><?= __('Lms Coursefile Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Result') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_examresults as $lmsExamresults) : ?>
                        <tr>
                            <td><?= h($lmsExamresults->id) ?></td>
                            <td><?= h($lmsExamresults->user_id) ?></td>
                            <td><?= h($lmsExamresults->lms_exam_id) ?></td>
                            <td><?= h($lmsExamresults->lms_coursefile_id) ?></td>
                            <td><?= h($lmsExamresults->token) ?></td>
                            <td><?= h($lmsExamresults->result) ?></td>
                            <td><?= h($lmsExamresults->descr) ?></td>
                            <td><?= h($lmsExamresults->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsExamresults', 'action' => 'view', $lmsExamresults->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsExamresults', 'action' => 'edit', $lmsExamresults->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsExamresults', 'action' => 'delete', $lmsExamresults->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamresults->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Exams') ?></h4>
                <?php if (!empty($user->lms_exams)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Timer') ?></th>
                            <th><?= __('Reexam') ?></th>
                            <th><?= __('Fail Count') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Options') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_exams as $lmsExams) : ?>
                        <tr>
                            <td><?= h($lmsExams->id) ?></td>
                            <td><?= h($lmsExams->title) ?></td>
                            <td><?= h($lmsExams->descr) ?></td>
                            <td><?= h($lmsExams->timer) ?></td>
                            <td><?= h($lmsExams->reexam) ?></td>
                            <td><?= h($lmsExams->fail_count) ?></td>
                            <td><?= h($lmsExams->user_id) ?></td>
                            <td><?= h($lmsExams->options) ?></td>
                            <td><?= h($lmsExams->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsExams', 'action' => 'view', $lmsExams->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsExams', 'action' => 'edit', $lmsExams->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsExams', 'action' => 'delete', $lmsExams->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExams->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Examusers') ?></h4>
                <?php if (!empty($user->lms_examusers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lms Exam Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Final Result') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_examusers as $lmsExamusers) : ?>
                        <tr>
                            <td><?= h($lmsExamusers->id) ?></td>
                            <td><?= h($lmsExamusers->user_id) ?></td>
                            <td><?= h($lmsExamusers->lms_exam_id) ?></td>
                            <td><?= h($lmsExamusers->token) ?></td>
                            <td><?= h($lmsExamusers->final_result) ?></td>
                            <td><?= h($lmsExamusers->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsExamusers', 'action' => 'view', $lmsExamusers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsExamusers', 'action' => 'edit', $lmsExamusers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsExamusers', 'action' => 'delete', $lmsExamusers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamusers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Factors') ?></h4>
                <?php if (!empty($user->lms_factors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('User Ids') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Old Price') ?></th>
                            <th><?= __('Lms Coupon Id') ?></th>
                            <th><?= __('Paid') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Options') ?></th>
                            <th><?= __('Types') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_factors as $lmsFactors) : ?>
                        <tr>
                            <td><?= h($lmsFactors->id) ?></td>
                            <td><?= h($lmsFactors->user_id) ?></td>
                            <td><?= h($lmsFactors->user_ids) ?></td>
                            <td><?= h($lmsFactors->price) ?></td>
                            <td><?= h($lmsFactors->old_price) ?></td>
                            <td><?= h($lmsFactors->lms_coupon_id) ?></td>
                            <td><?= h($lmsFactors->paid) ?></td>
                            <td><?= h($lmsFactors->status) ?></td>
                            <td><?= h($lmsFactors->descr) ?></td>
                            <td><?= h($lmsFactors->options) ?></td>
                            <td><?= h($lmsFactors->types) ?></td>
                            <td><?= h($lmsFactors->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsFactors', 'action' => 'view', $lmsFactors->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsFactors', 'action' => 'edit', $lmsFactors->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsFactors', 'action' => 'delete', $lmsFactors->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsFactors->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Payments') ?></h4>
                <?php if (!empty($user->lms_payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Lms Factor Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Terminal Ids') ?></th>
                            <th><?= __('Auth') ?></th>
                            <th><?= __('RefID') ?></th>
                            <th><?= __('TraceID') ?></th>
                            <th><?= __('Errcode') ?></th>
                            <th><?= __('Errtext') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_payments as $lmsPayments) : ?>
                        <tr>
                            <td><?= h($lmsPayments->id) ?></td>
                            <td><?= h($lmsPayments->lms_factor_id) ?></td>
                            <td><?= h($lmsPayments->token) ?></td>
                            <td><?= h($lmsPayments->price) ?></td>
                            <td><?= h($lmsPayments->user_id) ?></td>
                            <td><?= h($lmsPayments->terminal_ids) ?></td>
                            <td><?= h($lmsPayments->auth) ?></td>
                            <td><?= h($lmsPayments->RefID) ?></td>
                            <td><?= h($lmsPayments->TraceID) ?></td>
                            <td><?= h($lmsPayments->Errcode) ?></td>
                            <td><?= h($lmsPayments->Errtext) ?></td>
                            <td><?= h($lmsPayments->status) ?></td>
                            <td><?= h($lmsPayments->enable) ?></td>
                            <td><?= h($lmsPayments->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsPayments', 'action' => 'view', $lmsPayments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsPayments', 'action' => 'edit', $lmsPayments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsPayments', 'action' => 'delete', $lmsPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsPayments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Userfactors') ?></h4>
                <?php if (!empty($user->lms_userfactors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lms Factor Id') ?></th>
                            <th><?= __('Lms Course Id') ?></th>
                            <th><?= __('Lms Exam Id') ?></th>
                            <th><?= __('User Ids') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_userfactors as $lmsUserfactors) : ?>
                        <tr>
                            <td><?= h($lmsUserfactors->id) ?></td>
                            <td><?= h($lmsUserfactors->user_id) ?></td>
                            <td><?= h($lmsUserfactors->lms_factor_id) ?></td>
                            <td><?= h($lmsUserfactors->lms_course_id) ?></td>
                            <td><?= h($lmsUserfactors->lms_exam_id) ?></td>
                            <td><?= h($lmsUserfactors->user_ids) ?></td>
                            <td><?= h($lmsUserfactors->enable) ?></td>
                            <td><?= h($lmsUserfactors->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsUserfactors', 'action' => 'view', $lmsUserfactors->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsUserfactors', 'action' => 'edit', $lmsUserfactors->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsUserfactors', 'action' => 'delete', $lmsUserfactors->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsUserfactors->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Usernotes') ?></h4>
                <?php if (!empty($user->lms_usernotes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Lms Course Id') ?></th>
                            <th><?= __('Lms Coursefile Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_usernotes as $lmsUsernotes) : ?>
                        <tr>
                            <td><?= h($lmsUsernotes->id) ?></td>
                            <td><?= h($lmsUsernotes->user_id) ?></td>
                            <td><?= h($lmsUsernotes->lms_course_id) ?></td>
                            <td><?= h($lmsUsernotes->lms_coursefile_id) ?></td>
                            <td><?= h($lmsUsernotes->text) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsUsernotes', 'action' => 'view', $lmsUsernotes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsUsernotes', 'action' => 'edit', $lmsUsernotes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsUsernotes', 'action' => 'delete', $lmsUsernotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsUsernotes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Lms Userprofiles') ?></h4>
                <?php if (!empty($user->lms_userprofiles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->lms_userprofiles as $lmsUserprofiles) : ?>
                        <tr>
                            <td><?= h($lmsUserprofiles->id) ?></td>
                            <td><?= h($lmsUserprofiles->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LmsUserprofiles', 'action' => 'view', $lmsUserprofiles->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LmsUserprofiles', 'action' => 'edit', $lmsUserprofiles->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LmsUserprofiles', 'action' => 'delete', $lmsUserprofiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsUserprofiles->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Poll Votes') ?></h4>
                <?php if (!empty($user->poll_votes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Poll Id') ?></th>
                            <th><?= __('Vote') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->poll_votes as $pollVotes) : ?>
                        <tr>
                            <td><?= h($pollVotes->id) ?></td>
                            <td><?= h($pollVotes->poll_id) ?></td>
                            <td><?= h($pollVotes->vote) ?></td>
                            <td><?= h($pollVotes->content) ?></td>
                            <td><?= h($pollVotes->enable) ?></td>
                            <td><?= h($pollVotes->user_id) ?></td>
                            <td><?= h($pollVotes->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PollVotes', 'action' => 'view', $pollVotes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PollVotes', 'action' => 'edit', $pollVotes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PollVotes', 'action' => 'delete', $pollVotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pollVotes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Posts') ?></h4>
                <?php if (!empty($user->posts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Summary') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Image') ?></th>
                            <th><?= __('Published') ?></th>
                            <th><?= __('Post Status') ?></th>
                            <th><?= __('In Rss') ?></th>
                            <th><?= __('Meta Title') ?></th>
                            <th><?= __('Meta Description') ?></th>
                            <th><?= __('Meta Keywords') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Post Type') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->posts as $posts) : ?>
                        <tr>
                            <td><?= h($posts->id) ?></td>
                            <td><?= h($posts->title) ?></td>
                            <td><?= h($posts->slug) ?></td>
                            <td><?= h($posts->summary) ?></td>
                            <td><?= h($posts->content) ?></td>
                            <td><?= h($posts->image) ?></td>
                            <td><?= h($posts->published) ?></td>
                            <td><?= h($posts->post_status) ?></td>
                            <td><?= h($posts->in_rss) ?></td>
                            <td><?= h($posts->meta_title) ?></td>
                            <td><?= h($posts->meta_description) ?></td>
                            <td><?= h($posts->meta_keywords) ?></td>
                            <td><?= h($posts->user_id) ?></td>
                            <td><?= h($posts->post_type) ?></td>
                            <td><?= h($posts->priority) ?></td>
                            <td><?= h($posts->created) ?></td>
                            <td><?= h($posts->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Posts', 'action' => 'view', $posts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $posts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Posts', 'action' => 'delete', $posts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $posts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Profiles') ?></h4>
                <?php if (!empty($user->profiles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Family') ?></th>
                            <th><?= __('Bio') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->profiles as $profiles) : ?>
                        <tr>
                            <td><?= h($profiles->id) ?></td>
                            <td><?= h($profiles->user_id) ?></td>
                            <td><?= h($profiles->family) ?></td>
                            <td><?= h($profiles->bio) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Profiles', 'action' => 'view', $profiles->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Profiles', 'action' => 'edit', $profiles->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Profiles', 'action' => 'delete', $profiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $profiles->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Addresses') ?></h4>
                <?php if (!empty($user->shop_addresses)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Emails') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Nationalid') ?></th>
                            <th><?= __('Shop Useraddress Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_addresses as $shopAddresses) : ?>
                        <tr>
                            <td><?= h($shopAddresses->id) ?></td>
                            <td><?= h($shopAddresses->user_id) ?></td>
                            <td><?= h($shopAddresses->first_name) ?></td>
                            <td><?= h($shopAddresses->last_name) ?></td>
                            <td><?= h($shopAddresses->emails) ?></td>
                            <td><?= h($shopAddresses->phone) ?></td>
                            <td><?= h($shopAddresses->nationalid) ?></td>
                            <td><?= h($shopAddresses->shop_useraddress_id) ?></td>
                            <td><?= h($shopAddresses->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopAddresses', 'action' => 'view', $shopAddresses->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopAddresses', 'action' => 'edit', $shopAddresses->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopAddresses', 'action' => 'delete', $shopAddresses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopAddresses->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Favorites') ?></h4>
                <?php if (!empty($user->shop_favorites)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Post Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_favorites as $shopFavorites) : ?>
                        <tr>
                            <td><?= h($shopFavorites->id) ?></td>
                            <td><?= h($shopFavorites->post_id) ?></td>
                            <td><?= h($shopFavorites->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopFavorites', 'action' => 'view', $shopFavorites->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopFavorites', 'action' => 'edit', $shopFavorites->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopFavorites', 'action' => 'delete', $shopFavorites->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopFavorites->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Logesticusers') ?></h4>
                <?php if (!empty($user->shop_logesticusers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Logestic Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_logesticusers as $shopLogesticusers) : ?>
                        <tr>
                            <td><?= h($shopLogesticusers->id) ?></td>
                            <td><?= h($shopLogesticusers->shop_logestic_id) ?></td>
                            <td><?= h($shopLogesticusers->user_id) ?></td>
                            <td><?= h($shopLogesticusers->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopLogesticusers', 'action' => 'view', $shopLogesticusers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopLogesticusers', 'action' => 'edit', $shopLogesticusers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopLogesticusers', 'action' => 'delete', $shopLogesticusers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopLogesticusers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Orderlogesticlogs') ?></h4>
                <?php if (!empty($user->shop_orderlogesticlogs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Image') ?></th>
                            <th><?= __('Shop Logestic Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('Shop Orderlogestic Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_orderlogesticlogs as $shopOrderlogesticlogs) : ?>
                        <tr>
                            <td><?= h($shopOrderlogesticlogs->id) ?></td>
                            <td><?= h($shopOrderlogesticlogs->descr) ?></td>
                            <td><?= h($shopOrderlogesticlogs->image) ?></td>
                            <td><?= h($shopOrderlogesticlogs->shop_logestic_id) ?></td>
                            <td><?= h($shopOrderlogesticlogs->shop_order_id) ?></td>
                            <td><?= h($shopOrderlogesticlogs->shop_orderlogestic_id) ?></td>
                            <td><?= h($shopOrderlogesticlogs->user_id) ?></td>
                            <td><?= h($shopOrderlogesticlogs->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrderlogesticlogs', 'action' => 'view', $shopOrderlogesticlogs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrderlogesticlogs', 'action' => 'edit', $shopOrderlogesticlogs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrderlogesticlogs', 'action' => 'delete', $shopOrderlogesticlogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrderlogesticlogs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Orderlogestics') ?></h4>
                <?php if (!empty($user->shop_orderlogestics)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('Shop Orderproduct Id') ?></th>
                            <th><?= __('Shop Logestic Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Enable Descr') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_orderlogestics as $shopOrderlogestics) : ?>
                        <tr>
                            <td><?= h($shopOrderlogestics->id) ?></td>
                            <td><?= h($shopOrderlogestics->shop_order_id) ?></td>
                            <td><?= h($shopOrderlogestics->shop_orderproduct_id) ?></td>
                            <td><?= h($shopOrderlogestics->shop_logestic_id) ?></td>
                            <td><?= h($shopOrderlogestics->user_id) ?></td>
                            <td><?= h($shopOrderlogestics->enable) ?></td>
                            <td><?= h($shopOrderlogestics->enable_descr) ?></td>
                            <td><?= h($shopOrderlogestics->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrderlogestics', 'action' => 'view', $shopOrderlogestics->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrderlogestics', 'action' => 'edit', $shopOrderlogestics->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrderlogestics', 'action' => 'delete', $shopOrderlogestics->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrderlogestics->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Orderlogs') ?></h4>
                <?php if (!empty($user->shop_orderlogs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_orderlogs as $shopOrderlogs) : ?>
                        <tr>
                            <td><?= h($shopOrderlogs->id) ?></td>
                            <td><?= h($shopOrderlogs->shop_order_id) ?></td>
                            <td><?= h($shopOrderlogs->user_id) ?></td>
                            <td><?= h($shopOrderlogs->status) ?></td>
                            <td><?= h($shopOrderlogs->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrderlogs', 'action' => 'view', $shopOrderlogs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrderlogs', 'action' => 'edit', $shopOrderlogs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrderlogs', 'action' => 'delete', $shopOrderlogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrderlogs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Orderrefunds') ?></h4>
                <?php if (!empty($user->shop_orderrefunds)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Types') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_orderrefunds as $shopOrderrefunds) : ?>
                        <tr>
                            <td><?= h($shopOrderrefunds->id) ?></td>
                            <td><?= h($shopOrderrefunds->shop_order_id) ?></td>
                            <td><?= h($shopOrderrefunds->user_id) ?></td>
                            <td><?= h($shopOrderrefunds->types) ?></td>
                            <td><?= h($shopOrderrefunds->status) ?></td>
                            <td><?= h($shopOrderrefunds->enable) ?></td>
                            <td><?= h($shopOrderrefunds->descr) ?></td>
                            <td><?= h($shopOrderrefunds->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrderrefunds', 'action' => 'view', $shopOrderrefunds->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrderrefunds', 'action' => 'edit', $shopOrderrefunds->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrderrefunds', 'action' => 'delete', $shopOrderrefunds->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrderrefunds->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Orders') ?></h4>
                <?php if (!empty($user->shop_orders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Trackcode') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Shipmentcode') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Shop Address Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_orders as $shopOrders) : ?>
                        <tr>
                            <td><?= h($shopOrders->id) ?></td>
                            <td><?= h($shopOrders->user_id) ?></td>
                            <td><?= h($shopOrders->trackcode) ?></td>
                            <td><?= h($shopOrders->token) ?></td>
                            <td><?= h($shopOrders->shipmentcode) ?></td>
                            <td><?= h($shopOrders->currency) ?></td>
                            <td><?= h($shopOrders->enable) ?></td>
                            <td><?= h($shopOrders->status) ?></td>
                            <td><?= h($shopOrders->shop_address_id) ?></td>
                            <td><?= h($shopOrders->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrders', 'action' => 'view', $shopOrders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrders', 'action' => 'edit', $shopOrders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrders', 'action' => 'delete', $shopOrders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Ordershippings') ?></h4>
                <?php if (!empty($user->shop_ordershippings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Types') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Sendtime') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_ordershippings as $shopOrdershippings) : ?>
                        <tr>
                            <td><?= h($shopOrdershippings->id) ?></td>
                            <td><?= h($shopOrdershippings->shop_order_id) ?></td>
                            <td><?= h($shopOrdershippings->user_id) ?></td>
                            <td><?= h($shopOrdershippings->types) ?></td>
                            <td><?= h($shopOrdershippings->price) ?></td>
                            <td><?= h($shopOrdershippings->sendtime) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrdershippings', 'action' => 'view', $shopOrdershippings->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrdershippings', 'action' => 'edit', $shopOrdershippings->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrdershippings', 'action' => 'delete', $shopOrdershippings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrdershippings->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Ordertexts') ?></h4>
                <?php if (!empty($user->shop_ordertexts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Private') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_ordertexts as $shopOrdertexts) : ?>
                        <tr>
                            <td><?= h($shopOrdertexts->id) ?></td>
                            <td><?= h($shopOrdertexts->shop_order_id) ?></td>
                            <td><?= h($shopOrdertexts->user_id) ?></td>
                            <td><?= h($shopOrdertexts->text) ?></td>
                            <td><?= h($shopOrdertexts->private) ?></td>
                            <td><?= h($shopOrdertexts->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrdertexts', 'action' => 'view', $shopOrdertexts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrdertexts', 'action' => 'edit', $shopOrdertexts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrdertexts', 'action' => 'delete', $shopOrdertexts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrdertexts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Ordertokens') ?></h4>
                <?php if (!empty($user->shop_ordertokens)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_ordertokens as $shopOrdertokens) : ?>
                        <tr>
                            <td><?= h($shopOrdertokens->id) ?></td>
                            <td><?= h($shopOrdertokens->shop_order_id) ?></td>
                            <td><?= h($shopOrdertokens->user_id) ?></td>
                            <td><?= h($shopOrdertokens->token) ?></td>
                            <td><?= h($shopOrdertokens->status) ?></td>
                            <td><?= h($shopOrdertokens->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrdertokens', 'action' => 'view', $shopOrdertokens->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrdertokens', 'action' => 'edit', $shopOrdertokens->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrdertokens', 'action' => 'delete', $shopOrdertokens->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrdertokens->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Payments') ?></h4>
                <?php if (!empty($user->shop_payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Shop Order Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Terminalid') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Paid') ?></th>
                            <th><?= __('Au') ?></th>
                            <th><?= __('Err Code') ?></th>
                            <th><?= __('Err Text') ?></th>
                            <th><?= __('Return Data') ?></th>
                            <th><?= __('Mobile Number') ?></th>
                            <th><?= __('Myrahid') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_payments as $shopPayments) : ?>
                        <tr>
                            <td><?= h($shopPayments->id) ?></td>
                            <td><?= h($shopPayments->shop_order_id) ?></td>
                            <td><?= h($shopPayments->user_id) ?></td>
                            <td><?= h($shopPayments->terminalid) ?></td>
                            <td><?= h($shopPayments->price) ?></td>
                            <td><?= h($shopPayments->status) ?></td>
                            <td><?= h($shopPayments->paid) ?></td>
                            <td><?= h($shopPayments->au) ?></td>
                            <td><?= h($shopPayments->err_code) ?></td>
                            <td><?= h($shopPayments->err_text) ?></td>
                            <td><?= h($shopPayments->return_data) ?></td>
                            <td><?= h($shopPayments->mobile_number) ?></td>
                            <td><?= h($shopPayments->myrahid) ?></td>
                            <td><?= h($shopPayments->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopPayments', 'action' => 'view', $shopPayments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopPayments', 'action' => 'edit', $shopPayments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopPayments', 'action' => 'delete', $shopPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopPayments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Profiles') ?></h4>
                <?php if (!empty($user->shop_profiles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Family') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Nationalid') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_profiles as $shopProfiles) : ?>
                        <tr>
                            <td><?= h($shopProfiles->id) ?></td>
                            <td><?= h($shopProfiles->user_id) ?></td>
                            <td><?= h($shopProfiles->name) ?></td>
                            <td><?= h($shopProfiles->family) ?></td>
                            <td><?= h($shopProfiles->email) ?></td>
                            <td><?= h($shopProfiles->phone) ?></td>
                            <td><?= h($shopProfiles->nationalid) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopProfiles', 'action' => 'view', $shopProfiles->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopProfiles', 'action' => 'edit', $shopProfiles->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopProfiles', 'action' => 'delete', $shopProfiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopProfiles->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Shop Useraddresses') ?></h4>
                <?php if (!empty($user->shop_useraddresses)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Billing State') ?></th>
                            <th><?= __('Billing City') ?></th>
                            <th><?= __('Billing Address') ?></th>
                            <th><?= __('Billing Zip') ?></th>
                            <th><?= __('M1') ?></th>
                            <th><?= __('M2') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->shop_useraddresses as $shopUseraddresses) : ?>
                        <tr>
                            <td><?= h($shopUseraddresses->id) ?></td>
                            <td><?= h($shopUseraddresses->user_id) ?></td>
                            <td><?= h($shopUseraddresses->billing_state) ?></td>
                            <td><?= h($shopUseraddresses->billing_city) ?></td>
                            <td><?= h($shopUseraddresses->billing_address) ?></td>
                            <td><?= h($shopUseraddresses->billing_zip) ?></td>
                            <td><?= h($shopUseraddresses->m1) ?></td>
                            <td><?= h($shopUseraddresses->m2) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ShopUseraddresses', 'action' => 'view', $shopUseraddresses->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopUseraddresses', 'action' => 'edit', $shopUseraddresses->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopUseraddresses', 'action' => 'delete', $shopUseraddresses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopUseraddresses->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Sms Validations') ?></h4>
                <?php if (!empty($user->sms_validations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Mobile') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->sms_validations as $smsValidations) : ?>
                        <tr>
                            <td><?= h($smsValidations->id) ?></td>
                            <td><?= h($smsValidations->user_id) ?></td>
                            <td><?= h($smsValidations->mobile) ?></td>
                            <td><?= h($smsValidations->code) ?></td>
                            <td><?= h($smsValidations->status) ?></td>
                            <td><?= h($smsValidations->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SmsValidations', 'action' => 'view', $smsValidations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SmsValidations', 'action' => 'edit', $smsValidations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SmsValidations', 'action' => 'delete', $smsValidations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $smsValidations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Ticketaudits') ?></h4>
                <?php if (!empty($user->ticketaudits)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Operation') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Ticket Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->ticketaudits as $ticketaudits) : ?>
                        <tr>
                            <td><?= h($ticketaudits->id) ?></td>
                            <td><?= h($ticketaudits->operation) ?></td>
                            <td><?= h($ticketaudits->user_id) ?></td>
                            <td><?= h($ticketaudits->ticket_id) ?></td>
                            <td><?= h($ticketaudits->created) ?></td>
                            <td><?= h($ticketaudits->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Ticketaudits', 'action' => 'view', $ticketaudits->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Ticketaudits', 'action' => 'edit', $ticketaudits->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ticketaudits', 'action' => 'delete', $ticketaudits->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ticketaudits->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Ticketcomments') ?></h4>
                <?php if (!empty($user->ticketcomments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Ticket Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Filename') ?></th>
                            <th><?= __('Filesrc') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->ticketcomments as $ticketcomments) : ?>
                        <tr>
                            <td><?= h($ticketcomments->id) ?></td>
                            <td><?= h($ticketcomments->content) ?></td>
                            <td><?= h($ticketcomments->user_id) ?></td>
                            <td><?= h($ticketcomments->ticket_id) ?></td>
                            <td><?= h($ticketcomments->created) ?></td>
                            <td><?= h($ticketcomments->filename) ?></td>
                            <td><?= h($ticketcomments->filesrc) ?></td>
                            <td><?= h($ticketcomments->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Ticketcomments', 'action' => 'view', $ticketcomments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Ticketcomments', 'action' => 'edit', $ticketcomments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ticketcomments', 'action' => 'delete', $ticketcomments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ticketcomments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tickets') ?></h4>
                <?php if (!empty($user->tickets)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Html') ?></th>
                            <th><?= __('Ticketstatus Id') ?></th>
                            <th><?= __('Ticketpriority Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Agent Id') ?></th>
                            <th><?= __('Post Id') ?></th>
                            <th><?= __('Phone Number') ?></th>
                            <th><?= __('Alert Type') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Ticketcategory Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Completed') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->tickets as $tickets) : ?>
                        <tr>
                            <td><?= h($tickets->id) ?></td>
                            <td><?= h($tickets->subject) ?></td>
                            <td><?= h($tickets->content) ?></td>
                            <td><?= h($tickets->html) ?></td>
                            <td><?= h($tickets->ticketstatus_id) ?></td>
                            <td><?= h($tickets->ticketpriority_id) ?></td>
                            <td><?= h($tickets->user_id) ?></td>
                            <td><?= h($tickets->agent_id) ?></td>
                            <td><?= h($tickets->post_id) ?></td>
                            <td><?= h($tickets->phone_number) ?></td>
                            <td><?= h($tickets->alert_type) ?></td>
                            <td><?= h($tickets->email) ?></td>
                            <td><?= h($tickets->ticketcategory_id) ?></td>
                            <td><?= h($tickets->created) ?></td>
                            <td><?= h($tickets->modified) ?></td>
                            <td><?= h($tickets->completed) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tickets', 'action' => 'view', $tickets->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tickets', 'action' => 'edit', $tickets->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tickets', 'action' => 'delete', $tickets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tickets->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tmp Challengeforms') ?></h4>
                <?php if (!empty($user->tmp_challengeforms)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Tmp Challenge Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Info') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->tmp_challengeforms as $tmpChallengeforms) : ?>
                        <tr>
                            <td><?= h($tmpChallengeforms->id) ?></td>
                            <td><?= h($tmpChallengeforms->token) ?></td>
                            <td><?= h($tmpChallengeforms->tmp_challenge_id) ?></td>
                            <td><?= h($tmpChallengeforms->title) ?></td>
                            <td><?= h($tmpChallengeforms->info) ?></td>
                            <td><?= h($tmpChallengeforms->descr) ?></td>
                            <td><?= h($tmpChallengeforms->user_id) ?></td>
                            <td><?= h($tmpChallengeforms->enable) ?></td>
                            <td><?= h($tmpChallengeforms->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TmpChallengeforms', 'action' => 'view', $tmpChallengeforms->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TmpChallengeforms', 'action' => 'edit', $tmpChallengeforms->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TmpChallengeforms', 'action' => 'delete', $tmpChallengeforms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tmpChallengeforms->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tmp Members') ?></h4>
                <?php if (!empty($user->tmp_members)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Family') ?></th>
                            <th><?= __('Uid') ?></th>
                            <th><?= __('Birth Date') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Bakhsh') ?></th>
                            <th><?= __('Deh') ?></th>
                            <th><?= __('Favorite') ?></th>
                            <th><?= __('Gender') ?></th>
                            <th><?= __('Educate') ?></th>
                            <th><?= __('Job') ?></th>
                            <th><?= __('Mobile') ?></th>
                            <th><?= __('Images') ?></th>
                            <th><?= __('Scode') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->tmp_members as $tmpMembers) : ?>
                        <tr>
                            <td><?= h($tmpMembers->id) ?></td>
                            <td><?= h($tmpMembers->user_id) ?></td>
                            <td><?= h($tmpMembers->name) ?></td>
                            <td><?= h($tmpMembers->family) ?></td>
                            <td><?= h($tmpMembers->uid) ?></td>
                            <td><?= h($tmpMembers->birth_date) ?></td>
                            <td><?= h($tmpMembers->province) ?></td>
                            <td><?= h($tmpMembers->city) ?></td>
                            <td><?= h($tmpMembers->bakhsh) ?></td>
                            <td><?= h($tmpMembers->deh) ?></td>
                            <td><?= h($tmpMembers->favorite) ?></td>
                            <td><?= h($tmpMembers->gender) ?></td>
                            <td><?= h($tmpMembers->educate) ?></td>
                            <td><?= h($tmpMembers->job) ?></td>
                            <td><?= h($tmpMembers->mobile) ?></td>
                            <td><?= h($tmpMembers->images) ?></td>
                            <td><?= h($tmpMembers->scode) ?></td>
                            <td><?= h($tmpMembers->enable) ?></td>
                            <td><?= h($tmpMembers->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TmpMembers', 'action' => 'view', $tmpMembers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TmpMembers', 'action' => 'edit', $tmpMembers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TmpMembers', 'action' => 'delete', $tmpMembers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tmpMembers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tmp Personlikes') ?></h4>
                <?php if (!empty($user->tmp_personlikes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tmp Person Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->tmp_personlikes as $tmpPersonlikes) : ?>
                        <tr>
                            <td><?= h($tmpPersonlikes->id) ?></td>
                            <td><?= h($tmpPersonlikes->tmp_person_id) ?></td>
                            <td><?= h($tmpPersonlikes->user_id) ?></td>
                            <td><?= h($tmpPersonlikes->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TmpPersonlikes', 'action' => 'view', $tmpPersonlikes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TmpPersonlikes', 'action' => 'edit', $tmpPersonlikes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TmpPersonlikes', 'action' => 'delete', $tmpPersonlikes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tmpPersonlikes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tmp Persons') ?></h4>
                <?php if (!empty($user->tmp_persons)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Image') ?></th>
                            <th><?= __('Organ Name') ?></th>
                            <th><?= __('Organ Ids') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Yourdescr') ?></th>
                            <th><?= __('Likes') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Pcity') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Part') ?></th>
                            <th><?= __('Village') ?></th>
                            <th><?= __('File') ?></th>
                            <th><?= __('Semat') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Link') ?></th>
                            <th><?= __('Show Inlist') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->tmp_persons as $tmpPersons) : ?>
                        <tr>
                            <td><?= h($tmpPersons->id) ?></td>
                            <td><?= h($tmpPersons->token) ?></td>
                            <td><?= h($tmpPersons->title) ?></td>
                            <td><?= h($tmpPersons->image) ?></td>
                            <td><?= h($tmpPersons->organ_name) ?></td>
                            <td><?= h($tmpPersons->organ_ids) ?></td>
                            <td><?= h($tmpPersons->descr) ?></td>
                            <td><?= h($tmpPersons->yourdescr) ?></td>
                            <td><?= h($tmpPersons->likes) ?></td>
                            <td><?= h($tmpPersons->province) ?></td>
                            <td><?= h($tmpPersons->pcity) ?></td>
                            <td><?= h($tmpPersons->city) ?></td>
                            <td><?= h($tmpPersons->part) ?></td>
                            <td><?= h($tmpPersons->village) ?></td>
                            <td><?= h($tmpPersons->file) ?></td>
                            <td><?= h($tmpPersons->semat) ?></td>
                            <td><?= h($tmpPersons->enable) ?></td>
                            <td><?= h($tmpPersons->user_id) ?></td>
                            <td><?= h($tmpPersons->link) ?></td>
                            <td><?= h($tmpPersons->show_inlist) ?></td>
                            <td><?= h($tmpPersons->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TmpPersons', 'action' => 'view', $tmpPersons->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TmpPersons', 'action' => 'edit', $tmpPersons->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TmpPersons', 'action' => 'delete', $tmpPersons->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tmpPersons->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tmp Problemforms') ?></h4>
                <?php if (!empty($user->tmp_problemforms)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Tmp Problem Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('File') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->tmp_problemforms as $tmpProblemforms) : ?>
                        <tr>
                            <td><?= h($tmpProblemforms->id) ?></td>
                            <td><?= h($tmpProblemforms->token) ?></td>
                            <td><?= h($tmpProblemforms->tmp_problem_id) ?></td>
                            <td><?= h($tmpProblemforms->title) ?></td>
                            <td><?= h($tmpProblemforms->descr) ?></td>
                            <td><?= h($tmpProblemforms->file) ?></td>
                            <td><?= h($tmpProblemforms->user_id) ?></td>
                            <td><?= h($tmpProblemforms->enable) ?></td>
                            <td><?= h($tmpProblemforms->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TmpProblemforms', 'action' => 'view', $tmpProblemforms->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TmpProblemforms', 'action' => 'edit', $tmpProblemforms->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TmpProblemforms', 'action' => 'delete', $tmpProblemforms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tmpProblemforms->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tmp Problems') ?></h4>
                <?php if (!empty($user->tmp_problems)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Token') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Pcity') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Part') ?></th>
                            <th><?= __('Village') ?></th>
                            <th><?= __('Cats') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Descr') ?></th>
                            <th><?= __('Plan') ?></th>
                            <th><?= __('File') ?></th>
                            <th><?= __('Roles') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Enable') ?></th>
                            <th><?= __('Trcode') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->tmp_problems as $tmpProblems) : ?>
                        <tr>
                            <td><?= h($tmpProblems->id) ?></td>
                            <td><?= h($tmpProblems->token) ?></td>
                            <td><?= h($tmpProblems->level) ?></td>
                            <td><?= h($tmpProblems->province) ?></td>
                            <td><?= h($tmpProblems->pcity) ?></td>
                            <td><?= h($tmpProblems->city) ?></td>
                            <td><?= h($tmpProblems->part) ?></td>
                            <td><?= h($tmpProblems->village) ?></td>
                            <td><?= h($tmpProblems->cats) ?></td>
                            <td><?= h($tmpProblems->title) ?></td>
                            <td><?= h($tmpProblems->descr) ?></td>
                            <td><?= h($tmpProblems->plan) ?></td>
                            <td><?= h($tmpProblems->file) ?></td>
                            <td><?= h($tmpProblems->roles) ?></td>
                            <td><?= h($tmpProblems->user_id) ?></td>
                            <td><?= h($tmpProblems->enable) ?></td>
                            <td><?= h($tmpProblems->trcode) ?></td>
                            <td><?= h($tmpProblems->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TmpProblems', 'action' => 'view', $tmpProblems->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TmpProblems', 'action' => 'edit', $tmpProblems->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TmpProblems', 'action' => 'delete', $tmpProblems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tmpProblems->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related User Metas') ?></h4>
                <?php if (!empty($user->user_metas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Meta Type') ?></th>
                            <th><?= __('Meta Key') ?></th>
                            <th><?= __('Meta Value') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->user_metas as $userMetas) : ?>
                        <tr>
                            <td><?= h($userMetas->id) ?></td>
                            <td><?= h($userMetas->user_id) ?></td>
                            <td><?= h($userMetas->meta_type) ?></td>
                            <td><?= h($userMetas->meta_key) ?></td>
                            <td><?= h($userMetas->meta_value) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'UserMetas', 'action' => 'view', $userMetas->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'UserMetas', 'action' => 'edit', $userMetas->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserMetas', 'action' => 'delete', $userMetas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userMetas->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
