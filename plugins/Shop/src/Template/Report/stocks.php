<?= $this->element('Shop.report');?>
<div class="table-responsive"><table class="table table-striped bg-white table-bordered table-hover1" id="tbexample">
    <thead>
        <tr>
            <th scope="col">عنوان محصول</th>
            <th scope="col">عنوان ویژگی</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;foreach ($results as $k => $result): ?>
        <tr>
            <td width="300">
                <?= isset($result['title'])?
                $this->html->link($result['title'],'/admin/posts/edit/'.$result['id'],
                    ['target'=>'_blank','title'=>'ویرایش محصول']):'نامشخص'?>
            </td>
            <td>
                <div class="table-responsive"><table class="table1 table-borderless" style="width:100%;">
                    <tbody>
                        <?php foreach ($result['shop_productstocks'] as $k => $res): ?>
                            <tr>
                                <td width="200">
                                    <?php 
                                    if($res['pattern'] == null){
                                        echo '<span class="badge badge-primary">پیش فرض</span>';
                                        $lists[$k]['pattern'] = 0;
                                    }
                                    else{
                                        foreach( explode(',',$res['pattern']) as $tmp)
                                        echo isset($pattern[$tmp])?'<span class="badge badge-primary mr-1">'.$pattern[$tmp].'</span>' : '[-]';
                                    }?>
                                </td>

                                <td class="ltr" width="200">
                                    <?=  $res['stock']?>
                                </td>
                                
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table></div>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table></div>

<style>
    .table td{
        padding-right:15px;
        padding-left:15px;
        font-size:13px;
    }
</style>