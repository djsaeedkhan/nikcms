<?php global $current_lang;?>
<div class="widget-posts fl-wrap">
    <ul class="no-list-style">
        <?php if(isset($value['title'])):
            $temp = $this->Query->post($value['post_type'],[
                'limit'=> ($value['count']!=''?$value['count']:10),
                'order'=>['Posts.created'=>'desc'],
                'contain'=>['PostMetas'] ]);
            global $result;
            foreach($temp as $result):?>
        <li>
            <div class="widget-posts-img" style="width: 20%;">
                <?php if(($img = $this->Query->postimage('thumbnail',$result))){ 
                    echo $this->html->image($img, ['alt'=>$result['title'], 'style'=>'']);}?>
            </div>
            <div class="widget-posts-descr">
                <h4><?= $this->Query->permalink($result['title'], $result);?></h4>

                <?php if($result['created'] !=''):?>
                <div class="geodir-category-location fl-wrap">
                    <i class="fal fa-calendar"></i> 
                    <?php //jdate('Y/m/d',strtotime($result['created']->format('Y-m-d')))?>
                    <?= $current_lang != 'fa'?
                        date('Y/m/d', strtotime($result['created']->format('Y-m-d'))):
                        $this->Query->the_time($result,'Y/m/d');
                        ?>
                </div>
                <?php endif?>
            </div>
        </li>
        <?php endforeach;endif;?>
    </ul>
</div>