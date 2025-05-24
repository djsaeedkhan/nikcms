<?= $this->element('Template.header');?>
<style>
#header{background: #FFF !important;}
</style>
<div class="clear clearfix"></div>
<section id="content">
	<div class="content-wrap pt-4 pb-4" style="overflow: visible;">
        <div class="container clearfix">
            <div class="row">
                <div class="postcontent col-lg-9 order-lg-first">
                    <?php //include('breadcrumb.php')?>
                    <div class="bk1 p-4 text-justify fs-14">

                        <div class="">
                            <h4><?= $this->Query->the_title();?></h4>
                        </div>
                        <div class="fs-13" style="line-height:30px;">
                            <div class="d-none d-sm-inline" style="max-height: 250px;max-width: 250px;float: left;margin-right: 50px;">
                                <?php 
                                if($img = $this->Query->postimage('medium',$result)){
                                    echo $this->html->link(
                                        $this->html->image($img,[
                                            'class'=>'rounded-4','alt' => $result['title'] ]),
                                        $this->Query->the_permalink(['id'=>$result['id']]),
                                        ['data-lightbox'=>'image1','escape'=>false]);
                                }?>
                            </div>
                            <div class="d-sm-none text-center">
                                <?php 
                                if($img = $this->Query->postimage('medium',$result)){
                                    echo $this->html->link(
                                        $this->html->image($img,[
                                            'class'=>'rounded-4','alt' => $result['title'] ]),
                                        $this->Query->the_permalink(['id'=>$result['id']]),
                                        ['data-lightbox'=>'image1','escape'=>false]);
                                }?>
                            </div>
                            <?= $this->Query->the_content();?>
                        </div>
                    </div><!-- #shop end -->
                </div><!-- .postcontent end -->
                <div class="postcontent col-lg-3 pt-0 pt-3">
                    
                    <div class="widget clearfix">

                        <h4>آخرین مقالات</h4>
                        <div class="posts-sm row col-mb-30" id="post-list-sidebar">

                        <?php
						$temps = $this->Query->post('post',[
							'get_type'=> 'all',
							'cat_type' => 'id',
							'cat_data' => setting['bx9_cat'],
							'limit'=>setting['bx9_num'],
							'order'=>false,
							'contain'=>['PostMetas'],
						]);
						global $result;
						foreach($temps as $result):
							$metalist = $this->Func->MetaList($result);?>
                            <div class="entry col-12">
                                <div class="grid-inner row no-gutters">
                                    <div class="col-auto">
                                        <div class="entry-image">
                                            <a href="<?= $this->Query->the_permalink()?>">
                                                <?php if($img = $this->Query->postimage('medium',$result)){
                                                    echo $this->html->image($img, [
                                                        'alt'=>$result['title'], 
                                                        'title'=>$result['title']
                                                    ]);
                                                }?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col pl-3">
                                        <div class="entry-title">
                                            <h4><a href="<?= $this->Query->the_permalink()?>">
                                                <?= $this->Query->the_title()?>
                                            </a></h4>
                                        </div>
                                        <div class="entry-meta">
                                            <ul>
                                                <!-- <li><?= $this->Query->the_category()?></li> -->
                                                <li><?= $this->Query->the_time($result, 'Y/m/d')?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                <div>
            </div>
        </div>
    </div>
</section>
<?= $this->element('Template.footer');?>