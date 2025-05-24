<?php
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
global $result;
$bk_result = $result;
$meta = $this->Func->MetaList($result);
?>
<?= $this->element('Template.header');?>
<!-- Content
============================================= -->
<section id="content">
    <div class="content-wrap pt-4 pb-4" style="overflow: visible;">
		<div class="container clearfix">
            <?php //include('breadcrumb.php')?>
			<div class="single-product">
				<div class="product pl-4 py-4 br-25 bg-white">
					<div class="row">
                        <div class="col-md-1 col-3">
                            <div class="feature-box fbox-plain fbox-dark fbox-sm pr-3" style="margin: 0 auto;    justify-content: center;">
                                <div class="fbox-icon">
                                    <a href="<?= $this->Func->loggined()?ShopHelper::addto_favorite():'#modal-login-form" data-lightbox="inline"'?>">
                                        <i class="<?=ShopHelper::get_favorite()?'icon-heart fill-heart':'icon-line-heart'?> mb-2 fs-25" style="cursor:pointer;"
                                            data-toggle="tooltip" data-placement="right" title="افزودن به علاقه‌مندی"></i>
                                    </a><hr> 
                                    
                                    <a data-toggle="modal" data-target="#shareitplg">
                                        <i class="icon-line-share mb-2 fs-25" style="cursor:pointer;fill: #9C9E9F;"
                                            data-toggle="tooltip" data-placement="right" title="اشتراک گذاری" ></i>
                                    </a><hr>
                                    
                                    <!-- <i class="icon-line-bell mb-4 fs-25" style="cursor:pointer;fill: #9C9E9F;"
                                        data-toggle="tooltip" data-placement="right" title="اطلاع‌رسانی شگفت‌انگیز"></i> -->
                                    
                                    <a data-toggle="modal" data-target="#pricechart">
                                        <i class="icon-chart-bar1 mb-2 fs-25" style="cursor:pointer;fill: #9C9E9F;"
                                        data-toggle="tooltip" data-placement="right" title="نمودار قیمت"></i>
                                    </a><hr>
                                    
                                    <a href="<?= CartHelper::Link('compare');?>/<?=$result['id']?>">
                                        <i class="icon-line-repeat mb-2 fs-25" style="cursor:pointer;fill: #9C9E9F;"
                                        data-toggle="tooltip" data-placement="right" title="مقایسه"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                            
						<div class="col-md-3 col-9">
                            <div class="product-image">
                                <div class="fslider" dir="ltr" data-pagi="false" data-arrows="false" data-thumbs="true">
                                    <div class="flexslider flexslider2">
                                        <div class="slider-wrap" data-lightbox="gallery">
                                           
                                            <?php if(($img = $this->Query->postimage('medium',$result)) != ""){
                                                echo '<div class="slide" data-thumb="'.$img.'">';
                                                    echo '<a href="'.$img.'" data-lightbox="gallery-item">';
                                                        echo $this->html->image($img, ['alt'=>$result['title'] ]);
                                                    echo '</a>';
                                                echo '</div>';
                                            }?>
                                            

                                            <?php foreach(ShopHelper::Imagelist() as $img):?>
                                                <div class="slide" data-thumb="<?= $img[0]?>">
                                                    <a href="<?= $img[0]?>" data-lightbox="gallery-item">
                                                        <img src="<?= $img[0]?>" alt="<?= $img[1]?>">
                                                    </a>
                                                </div>
                                            <?php endforeach?>
                                        </div>
                                    </div>
                                </div>

                                <?php if(ShopHelper::Label($result['id'],['show'=>'title']) != ''):?>
                                <a href="<?=ShopHelper::Label($result['id'],['show'=>'link'])?>">
                                    <div class="sale-flash badge badge-danger p-2">
                                        <?=ShopHelper::Label($result['id'],['show'=>'title'])?>
                                    </div>
                                </a>
                                <?php endif?>
                                
                            </div>
						</div>

						<div class="col-md-5 col-12 product-desc position-lg-sticky h-100 px-3">
                            
                            <h1 class="mb-2" style="font-size:25px;display: contents;">
                                <?= $result['title']?>
                            </h1>

                            <div class="float-right fs-14 pt-md-2">
                                <?=ShopHelper::Meta('sku') != ""?'کدمحصول: '.ShopHelper::Meta('sku'):''?>
                            </div>

                            <h2 class="mb-1 fs-14 fw-n" style="font-family: none;">
                                <?= ShopHelper::Meta('en_title')?>
                            </h2>
                            
							<div class="card1 product-meta d-flex1 mb-2">
								<div class="card-body px-0">
									<div class="posted_in">
                                        دسته بندی: 
                                        <?= $this->Query->the_category($result);?>
                                    </div>
									<div class="tagged_as">
                                        <?= $this->Query->tags('برچسب: ',$result,['split'=>'span','limit'=>'4']);?>
                                    </div>
								</div>
							</div>

                            <div class="mb-4">
                                <?= ShopHelper::CreateForm(null,['addbtn_show'=>false])?>
                            </div>

                            <?php if(ShopHelper::Meta('short_descr') != ''):?>
                            <small>ویژگی های کالا:</small>
                            <ul class="iconlist fs-14" style="letter-spacing: -0.5px;">
                                <?php foreach($this->Func->newline(ShopHelper::Meta('short_descr')) as $text):if(strlen($text) > 0):?>
                                    <li class="mb-1"><i class="icon-caret-left"></i> <?=$text?></li>
                                <?php endif;endforeach;?>
                            </ul>
                            <?php endif;?>

						</div>
                        <div class="col-md-3 col-12 product-desc position-lg-sticky h-100  px-3">
                            
                            <?php 

                            $disc = ShopHelper::Meta('special_price');
                            $sp = str_replace(',','',ShopHelper::PriceGet($result['id'], ['with_spprice'=>1]));
                            $sp2 = ShopHelper::PriceShow($sp);
                            $past = $date = false;
                            if(ShopHelper::Meta('special_date_end') != ''){
                                $date = $this->Func->shm_to_mil(ShopHelper::Meta('special_date_end'),'/');
                                $past = (date("Y-m-d") < date("Y-m-d",strtotime($date)))?1:0;
                            }

                            if(ShopHelper::Meta('special_date_end') != '' and $sp != 'اتمام موجودی'){
                                $date2 = explode('-',$date);
                                if(is_array($date2) and $past){
                                    echo '<div class="countdown1 show" data-Date="'.str_replace('-','/',$date).'" style="padding-top: 10px;text-align: center;">
                                    پیشنهاد شگفت انگیز
                                    <br><br>
                                    <div class="running d-block" style="padding-bottom:20px;">
                                        <i class="icon-time"></i>
                                        <timer class="timers">
                                        <span class="days"></span>
                                        <span>:</span>
                                        <span class="hours"></span>
                                        <span>:</span>
                                        <span class="minutes"></span>
                                        <span>:</span>
                                        <span class="seconds"></span>
                                        </timer>
                                    </div>
                                    </div><div class="line"></div>
                                    <style>
                                        .countdown1.show .running timer {color: #d21e27;}
                                        .countdown1 i {color: #d21e27;}
                                    </style>';
                                }
                            }
                            ?>
                            

                            <?php 
                            if( ($p = ShopHelper::WholesaleList()) != '<ul id="moqRanges" class="moqRangesborder"></ul>'){
                                echo $p;
                                echo '<div class="line"></div>';
                            }?>
                            

                            <form class="cart mb-0 d-flex justify-content-between align-items-center" method="post" enctype='multipart/form-data'>
                                
                                <div class="quantity clearfix" style="font-size:13px;">
                                    <?php if(intval(ShopHelper::Meta('minimum_order')) > 1):?>
                                        حداقل سفارش : 
                                        <span> <?= ShopHelper::Meta('minimum_order')?></span>
                                    <?php endif?>
                                </div>

                                <div class="quantity clearfix m-0">
                                    <input type="button" value="-" class="minus">
                                    <input type="number" step="1" 
                                        min = "<?= ShopHelper::Meta('minimum_order')?>" 
                                        max = "<?= ShopHelper::Meta('maximum_order')?>"
                                        name = "quantity" value="1" title="تعداد سفارش" class="qty" />
                                    <input type="button" value="+" class="plus">
                                </div>
                            </form>

                            <div class="mt-4 mb-3 text-center d1-flex align-items-center justify-content-between">

                                <?php if( ($sp = ShopHelper::CheckSpPrice()) != false) echo '<div class="shop_spprice">
                                    <div class="shop_sptitle">قیمت فروش ویژه: </div>';?>
                                <div class="product-price shop-price text-black">
                                    <?= ShopHelper::PriceShow(ShopHelper::PriceGet());?>
                                </div>
                                <?php if($sp != false) echo '</div>';?>

                                <?= ShopHelper::Stock()?>
                            </div>
                            <div class="mt-4 mb-3 text-center d1-flex align-items-center justify-content-between">
                                <?= ShopHelper::TotalPrice()?>
                            </div>
                            
                            <button type="submit" style="width: 100%;" class="add-to-cart button m-0 ls0">افزودن به سبد خرید</button>
                            <script>
                            $(".add-to-cart").click(function(){
                                $("#shopforms").validate();
                                if($('#shopforms').valid())
                                    $('#shopforms').submit();
                                return false;
                            });

                            $('.qty').change(function() {
                                $("#shop-qty").val($('.qty').val());
                                document.getElementById("shop-qty").dispatchEvent(new Event('change',{}));
                            });
                            $('.qty').on('keyup',function(e) {
                                $("#shop-qty").val($('.qty').val());
                                document.getElementById("shop-qty").dispatchEvent(new Event('change',{}));
                            });

                            $('.qty').bind("keypress", function(e) {
                                if (e.keyCode == 13) {               
                                    e.preventDefault();
                                    return false;
                                }
                            });

                            $('#shop-qty').on('change', function (e) { var items = [];
                                var count = $('#shop-qty').val();

                                <?php if(ShopHelper::CheckSpPrice() == false):?>
                                    $('.zoFloatLeft').css('background', '#FFF');
                                    jQuery('.zoFloatLeft').each(function() {
                                        var min = $(this).attr("data-min") != ''? $(this).attr("data-min") :-1;
                                        var max = $(this).attr("data-max") != ''? $(this).attr("data-max") :9999999999;
                                        if( parseInt(min) <= parseInt(count) && parseInt(max) >= parseInt(count)){
                                            $(this).css('background', '#fee4e2');
                                        }
                                    });
                                <?php endif?>
                                var price = $('.shop-price span').text().replace(",",'');
                                price = price.replace(",",'');
                                price = price.replace(",",'');
                                price = price.replace(",",'');
                                price = parseInt(price) * parseInt($('.qty').val());
                                prc = parseFloat(price, 10).toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                                prc = prc.substring( 0, prc.indexOf( ".0" ) );
                                $('.total_price').html(prc);
                                if(! isNaN(price))
                                    $('.total_price_box').removeClass('d-none');
                            });
                            $(function () {
                                $( ".qty" ).change(function() {
                                    var max = parseInt($(this).attr('max'));
                                    var min = parseInt($(this).attr('min'));
                                    if ($(this).val() > max)
                                        $(this).val(max);
                                    else if ($(this).val() < min)
                                        $(this).val(min);
                                }); 
                            });
                            </script>
                            <div class="line"></div>
                            <?php
                            $result = $bk_result;
                            echo $this->cell('Ticketing.Question');?>
                        </div>
					</div>
				</div>
			</div>

            <!--------------------------------------------------------------------->

            <div class="single-product box2 mb-4">
				<div class="product owbox1">

                    <div class="tabs clearfix" id="tab-1">
                        <ul class="tab-nav clearfix">
                            <li><a href="#tabs-1">
                                <i class="icon-list-alt1 text-dark"></i>
                                مشخصات محصول</a></li>

                            <li><a href="#tabs-2">
                                <i class="icon-comment-alt1 text-dark"></i>
                                دیدگاه ها</a></li>
                        </ul>
                        <div class="tab-container">

                            <div class="tab-content clearfix text-justify" id="tabs-1">
                                <table class="table table-striped table-borderless br-15" style="font-size: 14px;">
                                    <tbody>
                                        <?php
                                        $result = $bk_result;
                                        foreach(ShopHelper::ProductDetail() as $dk => $dv):
                                        if($dv == '-'):?>
                                            <tr><td colspan="2">
                                                <h2 class="p-0 m-0" style="font-size: 15px;">
                                                    <?= $dk?>
                                                </h2>
                                            </td></tr>
                                        <?php else:?>
                                            <tr>
                                                <td width="200" style="opacity: 0.5;"><?=$dk?></td>
                                                <td><?= nl2br($dv);?></td>
                                            </tr>
                                        <?php endif;
                                        endforeach?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-content clearfix text-justify" id="tabs-2">
                                <div id="reviews" class="clearfix">
                                    <?php
                                    $result = $bk_result;
                                    echo $this->Func->the_comments(null,['viewlist','form'])?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--------------------------------------------------------------------->

            <div class="single-product mb-4">
				<div class="product">
                    <div class="owbox1 text-justify mt-4 fs-12 lh-30" id="tabs-1">
                        <div class="fancy-title title-border1">
                            <h4 class="fw-n">توضیحات محصول</h4>
                        </div>
                        <?= $this->Query->the_content()?>
                    </div>
                </div>
            </div>

            <!--------------------------------------------------------------------->
            <?php if(count(ShopHelper::SuggestShow()) > 0):?>
            <div class="single-product mt-4 box2">
				<div class="product"><div class="owbox1">
                    <div class="fancy-title">
                        <h4 class="text-dark fw-n">محصولات مرتبط
                            <!-- خریداران این محصول، محصول زیر را هم خریده اند --></h4>
                    </div>
                    <div id="oc-images" class="real-product owl-carousel image-carousel carousel-widget owl-loaded owl-drag with-carousel-dots" data-items-xs="1" data-items-sm="2" data-items-lg="4" data-items-xl="4" data-pagi="false" >
                        <?php 
                        global $result;
                        foreach(ShopHelper::SuggestShow() as $result)://$result = null;
                            $meta = $this->Func->MetaList();
                            ?>
                            <!-- <div class="oc-item"><div class="grid-inner"><div class="product">
                                <div class="product-image">
                                    <div class="fslider" data-arrows="false" dir="ltr">
                                        <div class="flexslider">
                                            <div class="slider-wrap">
                                                <div class="slide">
                                                <?php /* if($img = $this->Query->postimage('thumbnail',$item)){
                                                    echo $this->html->image($img, ['alt'=> $item['title'], 'title'=> $item['title'] ]);
                                                } */?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-overlay">
                                        <div class="bg-overlay-content align-items-end justify-content-between" data-hover-animate="fadeIn" data-hover-speed="400">
                                            <a href="<?php // $this->Query->the_permalink(['id'=>$item['id']])?>" title="<?=$item['title']?>" class="btn btn-dark mr-2">
                                                <i class="icon-shopping-basket"></i></a>
                                        </div>
                                        <div class="bg-overlay-bg bg-transparent"></div>
                                    </div>
                                </div>
                                <div class="product-desc text-center">
                                    <div class="product-title">
                                        <h3 class="fw-n fs-14" style="min-height: 45px;">
                                            <a href="<?php // $this->Query->the_permalink(['id'=>$item['id']])?>">
                                                <?php // $item['title']?>
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="product-price">
                                        <?php // ShopHelper::PriceShow( ShopHelper::PriceGet($item['id']) )?>
                                    </div>
                                </div>
                        </div></div></div> -->
                            <div class="oc-item"><?php include('loop-product.php');?></div>
                        <?php endforeach?>
                    </div>
                </div></div>
            </div>
            <?php endif?>

            <!--------------------------------------------------------------------->
            
            

            <?php if( count(ShopHelper::RelatedShow()) > 0):?>
            <div class="single-product box2 mb-4">
				<div class="product"><div class="owbox1 p-4 rounded-5" style="background: #868a96;">
                    <div class="fancy-title">
                        <h4 class="text-white">محصولات مشابه</h4>
                    </div>
                    <div id="oc-images" class="real-product owl-carousel image-carousel carousel-widget owl-loaded owl-drag with-carousel-dots" data-items-xs="1" data-items-sm="2" data-items-lg="4" data-items-xl="4" data-pagi="false" >
                        <?php 
                        foreach(ShopHelper::RelatedShow() as $result):
                            $meta = $this->Func->MetaList();?>
                            <div class="oc-item"><?php include('loop-product.php');?></div>
                        <?php endforeach?>
                    </div>
                </div></div>
            </div>
            <?php endif?>

            <!--------------------------------------------------------------------->
            

		</div>
	</div>
</section><!-- #content end -->

<style>
.tagged_as span:after{ content:' , ';}
.tagged_as span:last-child:after{ content:'';}
</style>
<?= $this->element('Template.footer');?>