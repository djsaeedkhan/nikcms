<?= $this->element('Template.header');?>
<!-- Content
============================================= -->
<section id="content">
	<div class="content-wrap pt-4 pb-1" style="overflow: visible;">
        <div class="container clearfix">
            <div class="row">
                <!-- Post Content
                ============================================= -->
                <div class="postcontent order-lg-last">
                    
                <section id="page-title" class="page-title-mini mb-3 border-0">
                    <div class="container clearfix">
                        <h2>
                            <?= $this->Query->the_category2()?>
                        </h2>
                    </div>
                </section>

                <div class="postcontent">
                    <!-- Shop
                    ============================================= -->
                    <div id="posts" class="row gutter-40" data-layouts="fitRows">
                        <?php global $result;foreach($data as $result):$metalist = $this->Func->MetaList($result);?>

                        <div class="entry col-12">
                            <div class="grid-inner row no-gutters">
                                <div class="col-md-4">
                                    <div class="entry-image">
                                    <?php 
                                    if($img = $this->Query->postimage('medium',$result)){
                                        echo $this->html->link(
                                            $this->html->image($img,['alt' => $result['title'] ]),
                                            $this->Query->the_permalink(['id'=>$result['id']]),
                                            ['data-lightbox'=>'image1','escape'=>false]);
                                    }?>
                                    </div>
                                </div>
                                <div class="col-md-8 pl-md-4">
                                    <div class="entry-title title-sm">
                                        <h2>
                                            <a class="fs-14" href="<?= $this->Query->the_permalink()?>">
                                                <?= $this->Query->the_title()?>
                                            </a>
                                        </h2>
                                    </div>
                                    <div class="entry-meta">
                                        <ul>
                                            <li><i class="icon-calendar3"></i> <?= $this->Query->the_time()?></li>
                                            <!-- <li><a href="#"><i class="icon-user"></i> admin</a></li> -->
                                            <li><i class="icon-folder-open"></i> <?= $this->Query->the_category()?></li>
                                            <!-- <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li> -->
                                            <!-- <li><a href="#"><i class="icon-camera-retro"></i></a></li> -->
                                        </ul>
                                    </div>
                                    <div class="entry-content fs-13" style="text-align: justify;">
                                        <p><?= $this->Query->the_excerpt($result , 400)?></p>
                                        <a href="<?= $this->Query->the_permalink()?>" class="more-link">بیشتر</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach?>
                    </div>

                    <ul class="pagination pagination-rounded pagination mt-4">
                        <?php
						if(! $this->request->getQuery('page')):
                            $this->Paginator->options([
                                'url' => [
                                    'plugin'=>'Website',
                                    'controller' => $post_type ,
                                    'action' => 'index' ,
                                    $this->request->getParam('catid'),
                                    $this->request->getParam('catslug')
                                ]
                            ]);
                        endif;
                        $this->Paginator->setTemplates([
                            'prevDisabled' => '<li class="page-item disabled"><a class="page-link disabled" href="{{url}}">قبلی</a></li>',
                            'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">قبلی</a></li>',
                            'nextDisabled' => '<li class="page-item disabled"><a class="page-link disabled">بعدی</a></li>',
                            'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">بعدی</a></li>',
                            'first' => '<li class="page-item"><a class="page-link" href="{{url}}">اولین</a></li>',
                            'last' => '<li class="page-item"><a class="page-link" href="{{url}}">آخرین</a></li>',
                            'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                            'current' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>' ]);
                        ?>
                        <?= $this->Paginator->first('<< ' . __('first'),['class'=>'page-link']) ?>
                        <?= $this->Paginator->prev('< ' . __('previous'),['class'=>'page-link']) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >',['class'=>'page-link']) ?>
                        <?= $this->Paginator->last(__('last') . ' >>',['class'=>'page-link']) ?>
                    </ul>

                </div><!-- .postcontent end -->
                
            </div>
        </div>
    </div>
</section>
<?= $this->element('Template.footer');?>