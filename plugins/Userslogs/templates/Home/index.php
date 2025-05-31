<h3>
    <b><?= __d('Userslogs', 'گزارش فعالیت');?></b> : 
    <?= isset($user['family'])?$user['family']:__d('Userslogs', 'همه کاربران')?>

    <?= $this->html->link(
        __d('Userslogs', 'نمایش همه'),
        ['?'=>['last'=>true]],
        ['class'=>'btn btn-primary btn-sm float-left'])?>
</h3>
<div class="clearfix"></div><Br>
<div class="card cart1"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= __d('Userslogs', 'ردیف')?></th>
                <?php if(!isset($user['id'])) echo '<th scope="col">'.__d('Userslogs', 'کاربر') .'</th>'?>
                <?php if(!isset($user['id'])) echo '<th scope="col">'.__d('Userslogs', 'یوزرنیم') .'</th>'?>
                <th scope="col"><?= __d('Userslogs', 'وضعیت')?></th>
                <th scope="col"><?= __d('Userslogs', 'تاریخ')?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;foreach ($results as $result): ?>
            <tr>
                <td><?= ++$i;?></td>
                <?php if(!isset($user['id'])):?>
                    <td><?= isset($result['user']['id'])?
                    $this->html->link(
                        $result['user']['family'].' ('.$result['user']['username'].')',
                        ['plugin'=>'Admin','controller'=>'Users','action'=>'view',$result['user']['id'] ],
                        ['title'=>__d('Userslogs', 'نمایش مشخصات کاربر') ])
                    :""?></td>
                <?php endif;?>

                <?php if(!isset($user['id'])):?>
                    <td><?= !isset($result['user']['id'])?$result['username']:""?></td>
                <?php endif;?>


                <td><?php
                if($result['types'] != null):
                    echo $result['types']==1?
                        '<span class="badge badge-success">'.__d('Userslogs', 'موفقیت آمیز') .'</span>':
                        '<span class="badge badge-danger">'.__d('Userslogs', 'ناموفق') .'</span>';
                endif;?></td>
                <td><?= $this->Func->date2($result);?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>
<?= $this->element('Admin.paginate')?>

