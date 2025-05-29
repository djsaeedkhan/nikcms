<?php
use Cake\Routing\Router;
use Shop\View\Helper\ShopHelper;?>
<?= $this->element('Template.header');?>
<!-- Content
============================================= -->
<section id="content">
	<div class="content-wrap pt-4 pb-1" style="overflow: visible;">
        <div class="container clearfix">

            <?php if(isset($brands) and $brands != null):?>
            <div class="row" style="background-color: #ececee;">
                <div class="entry mb-0 pt-4">
                    <div class="grid-inner row no-gutters">
                        <div class="col-md-3">
                            <div class="entry-image">
                            <a href="<?=$brands['link']?>">
                                <?php if($brands['image'] != ''):?>
                                    <img src="<?=$brands['image']?>" class="px-5" alt="<?=$brands['title']?>" style="width:100%">
                                <?php endif?>
                            </a>
                            </div>
                        </div>
                        <div class="col-md-8 pl-md-4">
                            <div class="entry-title title-sm">
                                <h2><a href="<?=$brands['link']?>"><?=$brands['title']?></a></h2>
                            </div>
                            <div class="entry-content text-justify">
                                <p><?= $brands['descr']?></p>

                                <?php if($brands['link'] != ''):?>
                                    <a href="<?= $brands['link']?>" class="more-link">مشاهده محصولات</a>
                                <?php endif?>
                            </div>
                        </div>
                    </div><br>
            </div></div><br>
            <?php endif?>

            <?php if(isset($label) and $label != null):?>
            <div class="row" style="background-color: #ececee;">
                <div class="entry mb-0 pt-4">
                    <div class="grid-inner row no-gutters">
                        <div class="entry-image col-md-3">
                            <a href="<?=$label['link']?>">
                                <?php if($label['image'] != ''):?>
                                    <img src="<?=$label['image']?>" class="px-5" alt="<?=$label['title']?>" style="width:100%">
                                <?php endif?>
                            </a>
                        </div>
                        <div class="col-md-8 pl-md-4">
                            <div class="entry-title title-sm">
                                <h2><a href="<?=$label['link']?>">
                                    <?=$label['title']?>
                                </a></h2>
                            </div>
                            <div class="entry-content text-justify">
                                <p style="font-size:14px;"><?= $label['descr']?></p>
                                
                                <?php if($label['link'] != ''):?>
                                    <a href="<?=$label['link']?>" class="more-link">مشاهده محصولات</a>
                                <?php endif?>
                            </div>
                        </div>
                    </div>
                    <br>
            </div></div><br>
            <?php endif?>

            <div class="row">
                <!-- Post Content
                ============================================= -->
                <div class="postcontent col-lg-9 order-last">
                    <?php //include('breadcrumb.php')?>
                    
                    <div class="bk1 br-15 pt-1 px-3">
                        <div class="listings__header d-flex" style="align-items: baseline;">
                            <div class="d-inline fs-14">مرتب‌سازی بر اساس :</div>
                            <ul class="listings__sort">
                                <li><?= $this->html->link('پربازدیدترین',$this->Query->UrlCon2(['sort'=>"view.desc"]), 
                                    ['class'=> ($this->request->getQuery('sort') == 'view.desc')?'is-active':'' ]);?></li>

                                <li><?= $this->html->link('پرفروش‌ترین‌', $this->Query->UrlCon2(['sort'=>"order.desc"]),
                                    ['class'=> $this->request->getQuery('sort') == 'order.desc'?'is-active':'' ]);?></li>

                                <li><?= $this->html->link('محبوب‌ترین', $this->Query->UrlCon2(['sort'=>"popularity.desc"]),
                                    ['class'=> $this->request->getQuery('sort') == 'popularity.desc'?'is-active':'' ]);?></li>

                                <li><?= $this->html->link('جدیدترین', $this->Query->UrlCon2(['sort'=>"new.desc"]),
                                    ['class'=> $this->request->getQuery('sort') == 'new.desc'?'is-active':'' ]);?></li>

                                <li><?= $this->html->link('ارزان‌ترین',$this->Query->UrlCon2(['sort'=> "price.asc"]),
                                    ['class'=> $this->request->getQuery('sort') == 'price.asc'?'is-active':'' ]);?></li>

                                <li><?= $this->html->link('گران‌ترین',$this->Query->UrlCon2(['sort'=> "price.desc"]),
                                    ['class'=> $this->request->getQuery('sort') == 'price.desc'?'is-active':'' ]);?></li>

                            </ul>
                            <hr class="mt-0 mb-4" style="border-top-color: #f3f4f5;">
                        </div>
                        
                        <div id="shop" class="shop row grid-containers" data-layoutss="fitRows">
                            <?php global $result;foreach($data as $result): $metalist = $this->Func->MetaList($result);?>
                            <div class="product col-md-3 col-6 mb-2 box2 px-1">
                                <div class="grid-inner">
                                    
                                    <div class="product-image">
                                        
                                        <a href="<?= $this->Query->the_permalink(['id'=>$result['id']])?>">
                                        <?php if($img = $this->Query->postimage('medium',$result)){
                                            echo $this->html->image($img, ['alt'=>$result['title'],'class'=>'br-5' ]);
                                        }?>
                                        </a>

                                        <?php if(ShopHelper::Label($result['id'],['show'=>'title']) != ''):?>
                                        <a href="<?= ShopHelper::Label($result['id'],['show'=>'link'])?>">
                                            <div class="sale-flash badge badge-secondary p-2">
                                                <?= ShopHelper::Label($result['id'],['show'=>'title'])?>
                                            </div>
                                        </a>
                                        <?php endif?>
                                        
                                        <a href="<?= $this->Query->the_permalink(['id'=>$result['id']])?>">
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content align-items-end justify-content-between" 
                                                data-hover-animate="fadeIn" data-hover-speed="400">
                                                <span class="btn btn-dark text-white mr-2">
                                                    <i class="icon-shopping-basket"></i></span>
                                            </div>
                                            <div class="bg-overlay-bg bg-transparent"></div>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="product-desc text-center">
                                        <div class="product-title">
                                            <h3 class="fw-n fs-14" style="min-height: 45px;">
                                                <a href="<?= $this->Query->the_permalink(['id'=>$result['id']])?>">
                                                    <?= $result['title']?>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="product-price fs-13" style="<?= ShopHelper::CheckSpPrice() != false?'color: #d21e27;':''?>">
                                            <?php if( ($sp = ShopHelper::CheckSpPrice()) != false){
                                                echo '<span class="disc_price">';
                                                echo ShopHelper::PriceShow(ShopHelper::PriceGet($result['id'], ['with_spprice'=>1]));
                                                echo '</span>';
                                                echo '<div class="shop_spprice">
                                                <div class="shop_sptitle">قیمت فروش ویژه: </div>';
                                            }?>
                                            <?= ShopHelper::PriceShow(ShopHelper::PriceGet($result['id']))?>
                                            <?php if($sp != false) echo '</div>';?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div><!-- #shop end -->
                        <?php
                        if(count($data) == 0) 
                            echo '<div class="alert alert-warning">محصولی پیدا نشد</div>';
                        ?>
                    </div>
            
                    <ul class="pagination pagination-rounded pagination mt-4">
                        <?php
                        if(! isset( $this->request->getParam('getQuery')['page'])):
                            if(isset($amazing)){ 
                                $this->Paginator->options([
                                    'url' => [
                                        'plugin'=> 'Website',
                                        'controller' => 'product/amazing/' ,
                                        'action' => "amazing" ,
                                       /*  $this->request->getParam('catid'),
                                        $this->request->getParam('catslug') */
                                    ]
                                ]);
                            }
                            elseif(isset($brands)){ 
                                $this->Paginator->options([
                                    'url' => [
                                        'plugin'=> 'Website',
                                        'controller' => 'product/brand/' ,
                                        'action' => $this->request->getParam('brands') ,
                                       /*  $this->request->getParam('catid'),
                                        $this->request->getParam('catslug') */
                                    ]
                                ]);
                            }
                            elseif(isset($label)){ 
                                $this->Paginator->options([
                                    'url' => [
                                        'plugin'=> 'Website',
                                        'controller' => 'product/label/' ,
                                        'action' => $this->request->getParam('label') ,
                                    ]
                                ]);
                            }else{
                                $this->Paginator->options([
                                    'url' => [
                                        'plugin'=>'Website',
                                        'controller' => $post_type ,
                                        'action' => 'index' ,
                                        $this->request->getParam('catid'),
                                        $this->request->getParam('catslug')
                                    ]
                                ]);
                            }
                        endif;
                        $this->Paginator->setTemplates([
                            'prevDisabled' => '<li class="page-item disabled"><a class="page-link disabled" href="{{url}}">قبلی</a></li>',
                            'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">قبلی</a></li>',
                            'nextDisabled' => '<li class="page-item disabled"><a class="page-link disabled">بعدی</a></li>',
                            'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">بعدی</a></li>',
                            'first' => '<li class="page-item"><a class="page-link" href="{{url}}">اولین</a></li>',
                            'last' => '<li class="page-item"><a class="page-link" href="{{url}}">آخرین</a></li>',
                            'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                            'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>' ]);
                        ?>
                        <?= $this->Paginator->first('<< ' . __('first'),['class'=>'page-link']) ?>
                        <?= $this->Paginator->prev('< ' . __('previous'),['class'=>'page-link']) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >',['class'=>'page-link']) ?>
                        <?= $this->Paginator->last(__('last') . ' >>',['class'=>'page-link']) ?>
                    </ul>

                </div><!-- .postcontent end -->
                <?php include('product_index_sidebar.php')?>
            </div>
        </div>
    </div>
</section>
<?= $this->element('Template.footer');?>