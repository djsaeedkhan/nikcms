<div class="sidebar sticky-sidebar sidebar-tech">
    <!--Tabs with Posts-->
    <div class="widget p1-cb pb-3" style="margin:0;">
        <div class="tabs">
            <ul class="nav nav-tabs" id="tabs-posts" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#popular" role="tab" 
                    aria-controls="popular" aria-selected="true"><?= isset($value['tab1_title'])?$value['tab1_title']:''?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#featured" role="tab" 
                    aria-controls="featured" aria-selected="false"><?= isset($value['tab2_title'])?$value['tab2_title']:''?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#recent" role="tab" 
                    aria-controls="recent" aria-selected="false"><?= isset($value['tab3_title'])?$value['tab3_title']:''?></a>
                </li>
            </ul>
            <div class="tab-content" id="tabs-posts-content">
                <div class="tab-pane fade show active pt-3" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                    <div class="post-thumbnail-list">
                        <?php if(isset($value['tab1_title'])):
                        $temp = $this->Query->post($value['tab1_post_type'],['limit'=> $value['tab1_count'],'contain'=>['PostMetas'] ]);
                        foreach($temp as $result):?>
                        <div class="post-thumbnail-entry col-sm-12" dir="rtl">
                            <?php if(($img = $this->Query->postimage('thumbnail',$result))){ 
                                echo $this->html->image($img, ['alt'=>$result['title'], 'style'=>'height:inherit']);}?>
                            <div class="post-thumbnail-content pt-3">
                                <?= $this->Query->permalink($result['title'], $result)?>
                                <!-- <small></small> -->
                            </div>
                        </div>
                        <?php endforeach;endif;?>
                    </div>
                </div>
                <div class="tab-pane fade pt-3" id="featured" role="tabpanel" aria-labelledby="featured-tab">
                    <div class="post-thumbnail-list">
                        <?php if(isset($value['tab2_title'])):
                        $temp = $this->Query->post($value['tab2_post_type'],['limit'=> $value['tab2_count'],'contain'=>['PostMetas'] ]);
                        foreach($temp as $result):?>
                        <div class="post-thumbnail-entry col-sm-12" dir="rtl">
                            <?php if(($img = $this->Query->postimage('thumbnail',$result))){ 
                                echo $this->html->image($img, ['alt'=>$result['title'], 'style'=>'height:inherit']);}?>
                            <div class="post-thumbnail-content pt-3" >
                                <?= $this->Query->permalink($result['title'], $result)?>
                                <!-- <small></small> -->
                            </div>
                        </div>
                        <?php endforeach;endif;?>
                    </div>
                </div>
                <div class="tab-pane fade pt-3" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                    <div class="post-thumbnail-list">
                        <?php if(isset($value['tab3_title'])):
                        $temp = $this->Query->post($value['tab3_post_type'],['limit'=> $value['tab3_count'],'contain'=>['PostMetas'] ]);
                        foreach($temp as $result):?>
                        <div class="post-thumbnail-entry col-sm-12" dir="rtl">
                            <?php if(($img = $this->Query->postimage('thumbnail',$result))){ 
                                echo $this->html->image($img, ['alt'=>$result['title'], 'style'=>'height:inherit']);}?>
                            <div class="post-thumbnail-content pt-3" >
                                <?= $this->Query->permalink($result['title'], $result)?>
                                <!-- <small></small> -->
                            </div>
                        </div>
                        <?php endforeach;endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End: Tabs with Posts-->
</div>