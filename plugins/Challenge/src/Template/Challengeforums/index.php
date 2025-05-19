<h3>
    <?= __('لیست نظرات') ?>
    
    <?php
    echo $this->html->link('تایید نشده',
        '/admin/challenge/challengeforums/index/?action=unapproved',['class'=>'ml-2 btn btn-sm btn-primary']);
    echo $this->html->link('نمایش همه',
        '/admin/challenge/challengeforums/index/',['class'=>'btn btn-sm btn-primary']);
    ?>
</h3>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col" style="width:55%">متن نظر</th>
                <th scope="col">مشخصات <?=__d('Template', 'همیاری')?></th>
                <th scope="col">نام کاربری</th>
                <th scope="col">تاریخ ثبت</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach ($challengeforums as $challengeforum): ?>
            <tr <?=($challengeforum->enable?'class="alert alert-success"':'class="alert alert-danger"')?> >
                <td><?= $i++ ?></td>
                <td><?= h(mb_substr($challengeforum->text,0,400)). 
                        (strlen($challengeforum->text)>350 ?' ...':'') ?>
                    <div class="hidme">
                        <?php
                        if( !$challengeforum->enable){
                            echo $this->Html->link(__('تایید شود'), ['action' => 'approve', $challengeforum->id]) ;
                        }?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $challengeforum->id]) ?>
                        <?= $this->Form->postlink(__('Delete'), ['action' => 'delete', $challengeforum->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeforum->id)]) ?>
                    </div>
                </td>
                <td>
                    <?= $challengeforum->has('challenge') ? $this->Html->link($challengeforum->challenge->title, ['controller' => 'Admin', 'action' => 'view', $challengeforum->challenge->id]) : '' ?><br>
                    <?= $challengeforum->has('challengeforumtitle') ? $challengeforum->challengeforumtitle->title: '' ?>
                </td>
                <td><?= $challengeforum->has('user') ? $this->Html->link($challengeforum->user->family, ['controller' => 'Users', 'action' => 'view', $challengeforum->user->id]) : '' ?></td>
                <td><?= $this->Query->the_time($challengeforum) ?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>