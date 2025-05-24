<?php
$maxrow = 15;
use Shop\Predata;
use Shop\View\Helper\ShopHelper;
global $result;
$predata = new Predata;?>
<?= $this->element('Template.header');?>

<section id="content">
	<div class="content-wrap mb-0 pb-0 pt-4">

		<section class="section bg-transparent pt-2 pb-4 my-0">
			<div class="container"><div class="grid-inners row">
				
				<div class="col-sm-12 home-slider">
					<div class="fslider mb-4" data-pagi="false" data-lightbox="gallery">
						<div class="flexslider">
							<div class="slider-wrap">
								<?php for($i=0;$i<$maxrow;$i++):if(isset(setting['bx1_slimg'. $i]) and setting['bx1_slimg'. $i]):?>
								<div class="slide">
									<a href="<?= setting['bx1_sllink'. $i]?>" data-lightbox="gallery-item">
										<img src="<?= setting['bx1_slimg'. $i]?>" alt="<?= setting['bx1_stitle'.$i]?>" 
											class="min-vh-sm-50 rounded-10">
									</a>
								</div>
								<?php endif;endfor?>
							</div>
						</div>
					</div>
				</div>
				
				<!-- <div class="col-sm-3">
					<div class="min-vh-sm-50 rounded-10 pt-4 px-3 text-center vertical-middle top-special">
						
						<div id="oc-special" class="owl-carousel image-carousel carousel-widget mt-4 dir-ltr" data-margin="20" data-nav="true" data-pagi="false" data-items-xs="1" data-items-sm="1" data-items-md="1" data-items-lg="1" data-items-xl="1">
							<?php 
								/* $temps = $this->Query->post('product',[
									'get_type'=> 'all',
									'cat_type' => 'id',
									'cat_data' => setting['bx1_spc_cat'],
									'limit'=>setting['bx1_spc_num'],
									'order'=>false,
									'contain'=>['PostMetas'] ,
								]);
								global $result;
								foreach($temps as $result):
									$metalist = $this->Func->MetaList($result);?>
								<div class="oc-item dir-rtl" >
									
									<?php if($img = $this->Query->postimage('medium',$result)){
										echo $this->html->image($img, [
											'class'=>'rounded-3',
											'alt'=>$result['title'], 
											'title'=>$result['title']]);
									}?>
									<a href="<?= $this->Query->the_permalink($result)?>">
										<h3 class="py-2 mb-0 lh-25 text-white fs-13">
											<?=$result['title']?>
										</h3>
									</a>
									
									<?php if(ShopHelper::Meta('short_descr') != ''):?>
										<?php $i=0;
										foreach($this->Func->newline(ShopHelper::Meta('short_descr')) as $text):if(strlen($text) > 0):
											if($i > 0 ) break;?>
											<div class="rounded-4 mb-1">
												<div class="col-lg-12 p-0 d-flex1 text-center fs-13 text-white">
													<?= $text?>
												</div>
											</div>
										<?php $i++;endif;endforeach;?>
									<?php endif;?>
									
									<div class="p-2 fs-14 mt-2 text-white">
										قیمت: <?= ShopHelper::PriceShow(ShopHelper::PriceGet($result['id']))?>
									</div>
								</div>
							<?php endforeach; */?>
						</div>

					</div>
				</div> -->

			</div></div>
		</section>

		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">
				<div class="d-sm-flex big-title">
					<?php if( setting['bxc_title'] != ""):?>
					<div class="heading-block border-bottom-0 mb-0">
						<h1 class="nott font-secondary ls0 fs-15 lh-30">
							<?= setting['bxc_title']?>
							<span class="font-primary fw-normal fs-12 color-AAA">
								<?= setting['bxc_desc']?>
							</span>
						</h1>
					</div>
					<?php endif?>

					<?php if(setting['bxc_linkt'] != ""):?>
						<a href="<?= setting['bxc_link']?>" class="fw-medium m-0 fs-13 text-black">
							<?= setting['bxc_linkt']?>
							<i class="icon-line-arrow-left"></i>
						</a>
					<?php endif?>
				</div>

				<div id="oc-category" class="owl-carousel image-carousel carousel-widget mt-4 dir-ltr" data-margin="20" data-nav="false" data-pagi="true" data-items-xs="3" data-items-sm="3" data-items-md="4" data-items-lg="5" data-items-xl="8">
					<?php
					for($i=0;$i<$maxrow;$i++):if(isset(setting['bxc_dimg'.$i]) and setting['bxc_dimg'.$i] != ""):?>
					<div class="oc-item dir-rtl">
						<?= $this->html->link(
							$this->html->image(setting['bxc_dimg'.$i],['class'=>'rounded-10','alt'=>setting['bxc_dtitle'.$i] ]).
							'<div class="titles fs-13 py-1 px-1 text-dark text-center">
								<div class="fw-bold">'.setting['bxc_dtitle'.$i].'</div>
							</div>'
							,
							setting['bxc_dlink'.$i],
							['escape'=>false]
						)?>
					</div>
					<?php endif;endfor;?>
				</div>
			</div>
		</section>


		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">
				<div class="d-sm-flex big-title">
					<div class="heading-block border-bottom-0 mb-0">
						<h1 class="nott font-secondary ls0 fs-15 lh-30">
							<?= setting['bx2_title']?>
							<span class="font-primary fw-normal fs-12 color-AAA">
								<?= setting['bx2_desc']?>
							</span>
						</h1>
					</div>
					<a href="<?= setting['bx2_link']?>" class="fw-medium m-0 fs-13 text-black">
						<?= setting['bx2_linkt']?>
						<i class="icon-line-arrow-left"></i>
					</a>
				</div>

				<?php $brands = ShopHelper::get_brands(null,[
					'width_product'=>[
						'type'=>'count',
						//'limit'=>-1,
					],
					'limit'=> setting['bx2_count']
					]);?>
				<div id="oc-brands" class="owl-carousel image-carousel carousel-widget mt-4 dir-ltr" data-margin="20" data-nav="false" data-pagi="true" data-items-xs="3" data-items-sm="3" data-items-md="4" data-items-lg="5" data-items-xl="8">
					<?php
					
					foreach($brands as $brand):?>
					<div class="oc-item dir-rtl">
						<?= $this->html->link(
							$this->html->image($brand['image'],['class'=>'rounded-10','alt'=>$brand['title'] ]).

							'<div class="titles fs-13 d-flex py-3 px-1 text-dark">
								<div>'.$brand['title'].'</div>
								<div class="fw-bold">'.($brand['product_count']).'</div>
							</div>'
							,
							'/product/brand/'.$brand['slug'],
							['escape'=>false]
						)?>
					</div>
					<?php endforeach;?>
				</div>
			</div>
		</section>


		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">

				<div id="top-charts" class="portfolio grid-containers row gutter-10" data-layouts="fitRows">
					<?php for($i=1;$i<4;$i++):if(isset(setting['bx3_image'.$i]) and setting['bx3_image'.$i] != ""):?>
					<article class="portfolio-item col-12 col-md-4 col-lg-4" data-animate="fadeIn">
						<div class="grid-inner">
							<div class="portfolio-image rounded-10">
								<a href="<?= setting['bx3_link'.$i]?>" title="<?= setting['bx3_title'.$i]?>">
									<img src="<?= setting['bx3_image'.$i]?>" alt="">
								</a>
								<div class="bg-overlay">
									<div class="bg-overlay-content dark" data-hover-animate="fadeIn">
									</div>
									<div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
								</div>
							</div>
						</div>
					</article>
					<?php endif;endfor?>
				</div>
			</div>
		</section>

		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">

				<div class="d-sm-flex big-title bp-2">
					<div class="heading-block border-bottom-0 mb-0">
						<h1 class="nott font-secondary ls0 fs-15 lh-30">
							<?= setting['bx5last_title']?>
							<span class="font-primary fw-normal fs-12 color-AAA">
								<?= setting['bx5last_desc']?>
							</span>
						</h1>
					</div>
					<a href="<?= setting['bx5last_link']?>" class="fw-medium m-0 fs-13 text-black">
						<?= setting['bx5last_linkt']?>
						<i class="icon-line-arrow-left"></i>
					</a>
				</div>
			</div>

			<div class="py-3 section1">
				<div class="container">
					<div class="real-product owl-carousel image-carousel carousel-widget bottommargin-lgs dir-ltr" data-margin="10" data-nav="true" data-loop="true" data-pagi="true" data-items-xs="2" data-items-sm="2" data-items-md="3" data-items-lg="5" data-items-xl="5">
						<?php
						$temps = $this->Query->post('product',[
							'get_type'=> 'all',
							setting['bx5last_cat'] != ''?[
								'cat_type' => 'id',
								'cat_data' => setting['bx5last_cat'],
							]:false,
							'limit'=>setting['bx5last_num'],
							'order'=>['Posts.id'=>'desc'],
							'contain'=>['PostMetas'] ,
						]);
						global $result;
						foreach($temps as $result):
							$metalist = $this->Func->MetaList($result);?>
							<div class="oc-item dir-rtl">
								<?php $position = "home";include('loop-product.php');?>
							</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</section>

		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">

				<div class="d-sm-flex big-title bp-2">
					<div class="heading-block border-bottom-0 mb-0">
						<h1 class="nott font-secondary ls0 fs-15 lh-30">
							<?= setting['bx5_title']?>
							<span class="font-primary fw-normal fs-12 color-AAA">
								<?= setting['bx5_desc']?>
							</span>
						</h1>
					</div>
					<a href="<?= setting['bx5_link']?>" class="fw-medium m-0 fs-13 text-black">
						<?= setting['bx5_linkt']?>
						<i class="icon-line-arrow-left"></i>
					</a>
				</div>
			</div>

			<div class="py-3 section1">
				<div class="container">
				
					<div class="real-product owl-carousel image-carousel carousel-widget bottommargin-lgs dir-ltr" data-margin="10" data-nav="true" data-loop="true" data-pagi="true" data-items-xs="2" data-items-sm="2" data-items-md="3" data-items-lg="5" data-items-xl="5">

						<?php
						$temps = $this->Query->post('product',[
							'get_type'=> 'all',
							'cat_type' => 'id',
							'cat_data' => setting['bx5_cat'],
							'limit'=>setting['bx5_num'],
							'order'=>['Posts.id'=>'desc'],
							'contain'=>['PostMetas'] ,
						]);
						global $result;
						foreach($temps as $result):
							$metalist = $this->Func->MetaList($result);?>
							<div class="oc-item dir-rtl">
								<?php $position = "home";include('loop-product.php');?>
							</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</section>


		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">

				<div id="top-charts" class="portfolio grid-containers row gutter-0" data-layouts="fitRows">
					<?php for($i=1;$i<4;$i++):if(isset(setting['bx4_image'.$i]) and setting['bx4_image'.$i] != ""):?>
					<article class="portfolio-item col-12 col-md-6 col-lg-6" data-animate="fadeIn">
						<div class="grid-inner">
							<div class="portfolio-image rounded-10">
								<a href="<?= setting['bx4_link'.$i] ?>" alt="<?= setting['bx4_title'.$i] ?>">
									<img src="<?= setting['bx4_image'.$i] ?>" alt="<?= setting['bx4_title'.$i] ?>">
								</a>
							</div>
						</div>
					</article>
					<?php endif;endfor?>
				</div>
			</div>
		</section>

		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">

				<div class="d-sm-flex big-title bp-2">
					<div class="heading-block border-bottom-0 mb-0">
						<h1 class="nott font-secondary ls0 fs-15 lh-30">
							<?= setting['bx55_title']?>
							<span class="font-primary fw-normal fs-12 color-AAA">
								<?= setting['bx55_desc']?>
							</span>
						</h1>
					</div>
					<a href="<?= setting['bx55_link']?>" class="fw-medium m-0 fs-13 text-black">
						<?= setting['bx55_linkt']?>
						<i class="icon-line-arrow-left"></i>
					</a>
				</div>
			</div>

			<div class="py-3 section1">
				<div class="container">
				
					<div class="real-product owl-carousel image-carousel carousel-widget bottommargin-lgs dir-ltr" data-margin="10" data-nav="true" data-loop="true" data-pagi="true" data-items-xs="2" data-items-sm="2" data-items-md="3" data-items-lg="5" data-items-xl="5">

						<?php
						$result = null;
						$temps = $this->Query->post('product',[
							'get_type'=> 'all',
							'cat_type' => 'id',
							'cat_data' => setting['bx55_cat'],
							'limit'=>setting['bx55_num'],
							'order'=>['Posts.id'=>'desc'],
							'contain'=>['PostMetas'] ,
						]);
						global $result;
						foreach($temps as $result):
							$metalist = $this->Func->MetaList($result);?>
							<div class="oc-item dir-rtl">
								<?php $position = "home";include('loop-product.php');?>
							</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</section>

		<section class="section about-section bg-transparent py-4 my-0">
			<div class="container clearfix">
				<div class="page-section topmargin bottommargin-lgs">
					<div class="row clearfix">
						<div class="col-lg-6 mb-5">
							<div class="vertical-middle">
								<!-- <div class="topmargin-lg d-none d-lg-block"></div> -->
								<div class="emphasis-title bottommargin-sm">
									<span class="before-headings"><?= setting['bx6_title1']?></span>
									<h2 class="font-body1 fw-bold fs-21 ls-0">
										<?= setting['bx6_title2']?>
									</h2>
								</div>
								<p class="lead fs-14 color-AAA text-justify">
									<?= setting['bx6_desc']?>
								</p>
								<div class="buttons">
									<?php if(setting['bx6_linkt'] != ""):?>
									<a href="<?= setting['bx6_link']?>" class="btn1 button button-circle button-large m-0 fw-semibold nott ls0 text-end mb-2">
										<?= setting['bx6_linkt']?>
										<i class="icon-angle-left"></i>
									</a>
									<?php endif?>

									<?php if(setting['bx6_linkt2'] != ""):?>
									<a href="<?= setting['bx6_link2']?>">
										<button type="button" class="bg-white btn2 button button-circle button-large m-0 dark fw-semibold nott ls0 text-end">
											<?= setting['bx6_linkt2']?>
										</button>
									</a>
									<?php endif?>

								</div>
							</div>
						</div>

						<div class="col-lg-6 center ">
							<div class="row">
								<div class="col-8">
									<img src="<?= setting['bx6_filmc']?>" alt="<?= setting['bx6_film']?>" data-animate="fadeInLeft">
								</div>
								<div class="col-4">
									
									<div class="row col-mb-50 vertical-middle">
										<?php for($i=1;$i<4;$i++):if(isset(setting['bx6_icont'.$i]) and setting['bx6_icont'.$i] != ""):?>
										<div class="col-sm-12 text-center pb-3" data-animate="bounceIn">
											<div class="counter counter-lined fs-30"><span data-from="100" data-to="<?= setting['bx6_icon'.$i]?>" data-refresh-interval="10" data-speed="2000"></span><!-- K+ --></div>
											<h5 class="fs-14 ls-0"><?= setting['bx6_icont'.$i]?></h5>
										</div>
										<?php endif;endfor?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">

				<div id="oc-cars" class="owl-carousel image-carousel carousel-widget mt-4 dir-ltr" data-margin="20" data-nav="false" data-pagi="true" data-items-xs="1" data-items-sm="2" data-items-md="4" data-items-lg="4" data-items-xl="4">
					<?php $labels = ShopHelper::get_labels(null,[
					'width_product'=>[
						'type'=>'count',
						//'limit'=>-1,
					],
					'limit'=> setting['bx7_count']
					]);?>

					<?php foreach($labels as $label):?>
					<div class="oc-item dir-rtl">
						<div>
							<div class="d1 d-flex p-3 rounded-6">
								<?= $this->html->link(
									$this->html->image($label['image'],['class'=>'rounded-10','alt'=>$label['title'] ]).
									'<div>
										<div class="fs-13">'.$label['title'].'</div>
										<div class="fw-bold fs-14">'.($label['product_count']).'</div>
									</div>'
									,
									'/label/'.$label['slug'],
									['escape'=>false]
								)?>
							</div>
						</div>
					</div>
					<?php endforeach;?>
				</div>
			</div>
		</section>


		<section class="section bg-transparent py-4 my-0 section-special">
			<div class="container clearfix rounded-10">
				<div class="row p-4">
					<div class="col-sm-3">
						<div class="emphasis-title bottommargin-sm vertical-middle text-center text-white">
							<h2 class="fs-22 ls-0 text-white fw-bold">
								<?= setting['bx8_title1']?>
							</h2>

							<span class="before-headings mb-5 fs-13">
								<?= setting['bx8_title2']?>
							</span>

							<?= setting['bx8_image'] != ""?
									$this->html->image(setting['bx8_image'],['class'=>'mb-5','alt'=>setting['bx8_title1']])
									:'';?>

							<?php if(setting['bx8_linkt'] != ""):?>
							<div>
								<a href="<?= setting['bx8_link']?>">
									<button type="button" class="button button-circle button-large m-0 dark fw-semibold nott ls0 text-end">
										<?= setting['bx8_linkt']?>
									</button>
								</a>
							</div>
							<?php endif?>

						</div>
					</div>

					<div class="col-sm-9">

						<div class="real-product owl-carousel image-carousel carousel-widget bottommargin-lgs py-3 dir-ltr" data-margin="10" data-nav="true" data-loop="true" data-pagi="true" data-items-xs="1" data-items-sm="1" data-items-md="2" data-items-lg="4" data-items-xl="4">
							
						<?php
						$temps = $this->Query->post('product',[
							'get_type'=> 'all',
							'cat_type' => 'id',
							'cat_data' => setting['bx8_cat'],
							'limit'=>setting['bx8_num'],
							'order'=>false,
							'contain'=>['PostMetas'] ,
						]);
						global $result;
						foreach($temps as $result):
							$metalist = $this->Func->MetaList($result);?>
							<div class="oc-item dir-rtl">
								<?php include('loop-product.php');?>
							</div>
						<?php endforeach;?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section bg-transparent py-4 my-0">
			<div class="container clearfix">
				<div class="d-sm-flex big-title pb-2">
					<div class="heading-block border-bottom-0 mb-0">
						<h1 class="nott font-secondary ls0 fs-15 lh-30">
							<?= setting['bx9_title']?>
							<span class="font-primary fw-normal fs-12 color-AAA">
								<?= setting['bx9_desc']?>
							</span>
						</h1>
					</div>
					<a href="<?= setting['bx9_link']?>" class="fw-medium m-0 fs-13 text-black">
						<?= setting['bx9_linkt']?>
						<i class="icon-line-arrow-left"></i>
					</a>
				</div>
			</div>

			<div class="py-3 section1">
				<div class="container">

					<div id="oc-posts" class="owl-carousel posts-carousel carousel-widget posts-md dir-ltr" data-margin="20" data-nav="true" data-pagi="true" data-items-xs="1" data-items-xl="4">

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
						<div class="oc-item dir-rtl">
							<div class="entry">
								<div class="entry-image">
									<a href="<?= $this->Query->the_permalink($result)?>">
										<?php if($img = $this->Query->postimage('medium',$result)){
											echo $this->html->image($img, ['alt'=>$result['title'], 'title'=>$result['title']]);
										}?>
									</a>

									<div class="card-img-overlay rounded-10 p-3 dark d-flex align-items-end flex-column ">
										<div class="mt-auto w-100 px-3 h-translate-y all-ts">
											<a href="<?= $this->Query->the_permalink($result)?>">
												<h3 class="card-title mb-2 text-white fs-16 fw-normal ls-30">
													<?=$result['title']?>
												</h3>
											</a>
										</div>
									</div>
								</div>
								<!-- <div>
									<?= $this->Query->the_excerpt()?>
								</div> -->
							</div>
						</div>
						<?php endforeach;?>
					</div>

				</div>
			</div>
		</section>
	</div>
</section>
<?= $this->element('Template.footer');?>