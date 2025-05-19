<?php $this->assign('shop_title','علاقه مندی')?>
<div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
    <thead>
        <tr>
            <th scope="col" width="50"><?= $this->Paginator->sort('#') ?></th>
            <th scope="col" width="100"><?= $this->Paginator->sort('تصویر') ?></th>
            <th scope="col"><?= $this->Paginator->sort('عنوان محصول') ?></th>
            <th scope="col" width="100"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;foreach ($results as $result):
            $posts = $this->Query->post('product',['id'=>$result['post_id'],'get_type'=>'first']);
            ?>
        <tr>
            <td><?= ++$i;?></td>
            <td><?php if($img = $this->Query->postimage('thumbnail',$posts)){
                echo $this->html->image($img,['style'=>'width:50px;']);
            }?>
            </td>
            <td>
                <?= isset($posts['title'])?$this->html->link($posts['title'],$this->Query->the_permalink($posts)):'';?>
            </td>
            <td>
                <?= $this->Form->postlink('حذف',
                    ['favorites','?'=>['delete'=>$result['id']]],
                    ['confirm'=>'برای حذف از علاقه مندی ها موافق هستید؟'])?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table></div>