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
