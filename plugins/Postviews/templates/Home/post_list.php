<?php  use Cake\ORM\TableRegistry;?>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= __d('Postviews','آیدی')?></th>
                <th scope="col"><?= __d('Postviews','عنوان نوشته')?></th>
                <th scope="col"><?= __d('Postviews','تعداد بازدید')?></th>
            </tr>
        </thead>
        <tbody>
            
        <?php
            $ptype = $this->Func->posttype_list(['type'=>'list_key']);
            unset( $ptype['media']);
            $results = TableRegistry::getTableLocator()->get('Admin.Posts')
                ->find('all')
                ->contain(['PostMetas'])
                ->order(['Posts.created'=>'DESC'])
                ->where(['post_type IN'=>$ptype ])
                //->limit(100)
                ->toarray();
            foreach($results as $result){?>
            <tr>
                <td><?= $result['id'];?></td>
                <td><?= $result['title'];?></td>
                <td><?= isset($result['meta_list']['post_views'])?$result['meta_list']['post_views']:0?></td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table></div>
</div></div>