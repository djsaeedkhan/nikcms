<?= $this->element('Template.header');?>
<style>
#header{background: #FFF !important;}
@media (min-width: 992px){
    .header-wrap-clone {
        display: initial;
    }
    .col-lg-10 {
        -ms-flex: 0 0 80%;
        flex: 0 0 80%;
        max-width: 80%;
    }
    .col-lg-2 {
        -ms-flex: 0 0 20%;
        flex: 0 0 20%;
        max-width: 20%;
    }
}
</style>
<!-- Content
============================================= -->
<section id="content">
    <div class="content-wrap pt-4 pb-4" style="overflow: visible;">
        <div class="container-fluid clearfix">
            <div class="row">
                <div class="entry col-12"><div class="bk1">
                    <div class="grid-inner row no-gutters">
                        <div class="entry-image col-md-3">
                            <a href="#" data-lightbox="image">
                            <img src="https://dkstatics-public.digikala.com/digikala-adservice-banners/1000024403.jpg?x-oss-process=image/quality,q_80" class="px-5" alt="#" style="width:100%"></a>
                        </div>
                        <div class="col-md-8 pl-md-4">
                            <div class="entry-title title-sm">
                                <h2><a href="#">معرفی برند سامسونگ</a></h2>
                            </div>
                            <div class="entry-content">
                                <p>سامسونگ یکی از بزرگترین شرکت‌ های کره جنوبی و یک شرکت چندملیتی است که از تعداد زیادی زیرمجموعه تشکیل شده‌ است. این شرکت‌ها در صنایع مختلف از جمله کالای دیجیتال، لوزام خانگی، صوتی و تصویری فعالیت می‌کنند.</p>
                                <a href="#" class="more-link">مشاهده محصولات</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div></div>


            <div class="row">
                <!-- Post Content
                ============================================= -->
                <div class="postcontent col-lg-10 order-lg-last">

                    <?php //include('breadcrumb.php')?>
                    <!-- Shop
                    ============================================= -->
                    <div class="bk1"><div id="shop" class="shop row grid-container " data-layout="fitRows">
                        <?php 
                        
                        for($i=0;$i<12;$i++):?>
                        <div class="product col-md-3 col-sm-6 mb-4 box2">
                            <div class="grid-inner" style="">
                                <div class="product-image">
                                    <a href="single.php"><img src="<?= $list[($p =rand(0,19))]?>" <?=$p?> alt="شارژر همراه ژیپین"></a>
                                    <a href="single.php"><img src="#image" alt="شارژر همراه ژیپین"></a>
                                    <div class="sale-flash badge badge-secondary p-2">
                                        <!-- Label -->
                                    </div>
                                    <div class="bg-overlay">
                                        <div class="bg-overlay-content align-items-end justify-content-between" data-hover-animate="fadeIn" data-hover-speed="400">
                                            <a href="single.php" class="btn btn-dark mr-2"><i class="icon-shopping-cart"></i></a>
                                            <a href="single.php" class="btn btn-dark" data-lightbox="ajax"><i class="icon-line-expand"></i></a>
                                        </div>
                                        <div class="bg-overlay-bg bg-transparent"></div>
                                    </div>
                                </div>
                                <div class="product-desc text-center">
                                    <div class="product-price">
                                        <ins style="font-weight:normal;font-size:15px;">14 هزارتومان</ins>
                                    </div>
                                    <div class="product-title">
                                        <h3 style="font-weight:normal;font-size:15px;"><a href="single.php">شارژر همراه ژیپین</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endfor?>

                    </div><!-- #shop end -->
                </div></div><!-- .postcontent end -->
                <?php include('sidebar.php')?>
            </div>

        </div>
    </div>
</section><!-- #content end -->
<?= $this->element('Template.footer');?>