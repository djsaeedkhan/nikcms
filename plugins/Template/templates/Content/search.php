<?php
use Cake\Routing\Router;
use Shop\View\Helper\ShopHelper;?>
<?= $this->element('Template.header');?>
<!-- Content
============================================= -->
<section id="content">
	<div class="content-wrap pt-4 pb-1" style="overflow: visible;">
        <div class="container clearfix">

            <div class="row">
                <!-- Post Content
                ============================================= -->
                <div class="postcontent col-lg-10 order-lg-last">
                    <?php include('breadcrumb.php')?>
                    <!-- Shop
                    ============================================= -->
                    <div class="bk1 br-15 pt-1 px-3">
                        
                        <div id="shop" class="shop row grid-container" data-layout="fitRows">
                            <?php global $result;foreach($data as $result):
                                $metalist = $this->Func->MetaList($result);?>
                            <div class="product col-md-3 col-sm-6 mb-4 box2">
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
                                        <div class="product-price" style="<?= ShopHelper::CheckSpPrice() != false?'color: #d21e27;':''?>">
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
                            <?php endforeach?>
                        </div><!-- #shop end -->
                    </div>
            
                    <ul class="pagination pagination-rounded pagination mt-4">
                        <?php
                        /* if(! isset( $this->request->getParam('getQuery')['page'])):
                            $this->Paginator->options([
                                'url' => [
                                    'plugin'=> 'Website',
                                    'controller' => 'search' ,
                                    'action' => 'search' ,
                                    $this->request->getQuery()
                                ]
                            ]);
                        endif; */
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