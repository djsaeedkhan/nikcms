
<?php  use Cake\ORM\TableRegistry;?>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= __d('Postviews','پست تایپ')?></th>
                <th scope="col"><?= __d('Postviews','جمع بازدید')?></th>
            </tr>
        </thead>
        <tbody>
            
        <?php foreach($this->Func->posttype_list() as $lk => $lv){?>
            <tr>
                <td><?=$lv .' ('.$lk.')';?></td>
                <td>
                    <?php 
                    $result = TableRegistry::getTableLocator()->get('Admin.Posts')
                        ->find('list',['keyField'=>'id','valueField'=>'id'])
                        ->where(['post_type'=>$lk])
                        ->toArray();
                    if($result){

                        $query = TableRegistry::getTableLocator()->get('Admin.PostMetas')->find();
                        $p = $query->select(['sum' => $query->func()->sum('PostMetas.meta_value')])
                            ->where([
                                'PostMetas.meta_key'=>'post_views',
                                'PostMetas.post_id IN ' => $result])
                            ->first();
                        if(isset($p['sum']))
                            echo $p['sum'];
                        else
                            echo 0;
                    }
                    else
                        echo 0;
                    ?>
                </td>
            </tr>
        <?php 
        }
        ?>
        </tbody>
    </table></div>
</div></div>