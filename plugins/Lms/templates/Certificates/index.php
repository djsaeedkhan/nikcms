<?php use Lms\Predata;$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت گواهینامه ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-sm btn-primary'])?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <!-- <th scope="col"><?= $this->Paginator->sort('id') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lms_course_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('download') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('enable') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accepted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsCertificates as $lmsCertificate): ?>
            <tr>
                <!-- <td><?= $this->Number->format($lmsCertificate->id) ?></td> -->
                <td><?= $lmsCertificate->has('user') ? $this->Html->link($lmsCertificate->user->family, ['controller' => 'Users', 'action' => 'view', $lmsCertificate->user->id]) : '' ?></td>
                <td><?= $lmsCertificate->has('lms_course') ? $this->Html->link($lmsCertificate->lms_course->title, ['controller' => 'LmsCourses', 'action' => 'view', $lmsCertificate->lms_course->id]) : '' ?></td>
                <td><?= h($lmsCertificate->image) ?></td>
                <td><?= h($lmsCertificate->download) ?></td>
                <td><?= $this->Number->format($lmsCertificate->status) ?></td>
                <td><?= h($lmsCertificate->enable) ?></td>
                <td><?= h($lmsCertificate->created) ?></td>
                <td><?= h($lmsCertificate->accepted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'add', $lmsCertificate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lmsCertificate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCertificate->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </tbody>
    </table></div>
</div></div>
<?= $this->element('Admin.paginate')?>