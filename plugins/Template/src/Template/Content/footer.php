		<footer id="footer" class="border-0 bg-transparent fs-13">
			<div class="container">
				<div class="footer-widgets-wrap pb-3 clearfix">
					<div class="row">
						<div class="col-lg-4 col-md-2 col-6">
							<div class="widget clearfix">
								<h4 class="ls0 mb-4 nott text-dark">
									<?= setting['footer_title1']?>
								</h4>
								<?= $this->Query->Navmenu(isset(setting['footer_menu1'])?setting['footer_menu1']:null,[
									'nav'=>false, 'nav_class'=>'',
									'div'=>false,
									'ul'=> true,'ul_class'=>'list-unstyled ms-0 fs-12',
									'li_class'=>'mb-2',
									'a_class'=>'' ]);?>
							</div>
						</div>
						<div class="col-lg-4 col-md-2 col-6">
							<div class="widget clearfix">
								<h4 class="ls0 mb-4 nott text-dark">
									<?= setting['footer_title2']?>
								</h4>
								<?= $this->Query->Navmenu(isset(setting['footer_menu2'])?setting['footer_menu2']:null,[
									'nav'=>false, 'nav_class'=>'',
									'div'=>false,
									'ul'=> true, 'ul_class'=>'list-unstyled ms-0 fs-12',
									'li_class'=>'mb-2',
									'a_class'=>'' ]);?>
							</div>
						</div>
						<div class="col-lg-4 col-md-2 col-12">
							<div class="widget clearfix">
								<h4 class="ls0 mb-4 nott text-dark">
									<?= setting['footer_soc_title']?>
								</h4>
								<div>
									<?php if(setting['footer_soc_insta']):?>
									<a href="<?= setting['footer_soc_insta']?>" class="social-icon si-rounded si-small si-light si-instagram" 
										title="<?= setting['footer_soc_insta']?>">
										<i class="icon-instagram"></i>
										<i class="icon-instagram"></i>
									</a>
									<?php endif?>

									<?php if(setting['footer_soc_twitt']):?>
									<a href="<?= setting['footer_soc_twitt']?>" class="social-icon si-rounded si-small si-light si-twitter" 
										title="<?= setting['footer_soc_twitt']?>">
										<i class="icon-twitter"></i>
										<i class="icon-twitter"></i>
									</a>
									<?php endif?>

									<?php if(setting['footer_soc_faceb']):?>
									<a href="<?= setting['footer_soc_faceb']?>" class="social-icon si-rounded si-small si-light si-facebook" 
										title="<?= setting['footer_soc_faceb']?>">
										<i class="icon-facebook"></i>
										<i class="icon-facebook"></i>
									</a>
									<?php endif?>

									<?php if(setting['footer_soc_teleg']):?>
									<a href="<?= setting['footer_soc_teleg']?>" class="social-icon si-rounded si-small si-light si-telegram" 
										title="<?= setting['footer_soc_teleg']?>">
										<i class="icon-telegram"></i>
										<i class="icon-telegram"></i>
									</a>
									<?php endif?>

									<?php if(setting['footer_soc_linked']):?>
									<a href="<?= setting['footer_soc_linked']?>" class="social-icon si-rounded si-small si-light si-linkedin" 
										title="<?= setting['footer_soc_linked']?>">
										<i class="icon-linkedin"></i>
										<i class="icon-linkedin"></i>
									</a>
									<?php endif?>

									<?php if(setting['footer_soc_aprt']):?>
									<a href="<?= setting['footer_soc_aprt']?>" class="social-icon si-rounded si-small si-light si-facebook" 
										title="<?= setting['footer_soc_aprt']?>">
										<i class="icon-facebook"></i>
										<i class="icon-facebook"></i>
									</a>
									<?php endif?>
									
								</div>
							</div>

							<div class="widget clearfix mt-4 fs-14">
								<div class="widget subscribe-widget clearfix">
									<p class="mb-3 mb-sm-0 fs-13">
										<?= setting['footer_newst']?>
										<!-- <strong>خبرنامه: </strong>از جدید ترین اخبار ما پیگیری کنید -->
									</p>
									<form id="form-subscribe-form" action="#" method="post" class="mb-0">
										<div class="input-group mx-auto">
											<input type="email" id="widget-subscribe-form-email" name="email" 
												class="form-control required email" placeholder="<?= setting['footer_newspl']?>">
											<button class="btn btn-success" type="submit"><?= setting['footer_news_btn']?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

					<div>
						<div class="d-sm-flex f-dd">
							<div>
								<strong>
									<?= setting['footer_info_title']?>
								</strong>
								<p class="mb-0 fs-12 text-justify lh-30">
									<?= setting['footer_info_desc']?>
								</p>
							</div>
							<div>
								<a href="<?= setting['footer_call_link']?>" class="d-flex f-d1">
									<div class="fs-18 f-d2">
										<?= setting['footer_call_title1']?>
										<div class="fs-13">
											<?= setting['footer_call_title2']?>
										</div>
									</div>
									<i class="icon-line-phone-call fs-20"></i>
								</a>
							</div>
						</div>
					</div>
							
					<div class="row align-items-center col-mb-50 mt-5">
						<div class="col-md-8 text-center text-md-start pb-1">
							<div class="heading-block border-bottom-0 mb-2">
								<h4><?= setting['footer_about_title']?></h4>
							</div>
							<p class="text-justify lh-30 fs-12">
								<?= setting['footer_about_desc']?>
							</p>
						</div>
						<div class="col-md-4 text-center">
							<?= $this->html->image('/template/images/enamad.png')?>
						</div>
					</div>
					<div>
						<div class="d-sm-flex f-d3">
							<div class="mb-3 mb-sm-0 text-justify ls-0">
								<?=isset(setting['footer_copyt'])?setting['footer_copyt']:null?>
							</div>
							<div>
								<?= $this->html->link($this->html->image('/template/img/logo.jpg',[
									'alt'=>'گروه برنامه نویسی مهرگان سیستم',
									'title'=>'گروه برنامه نویسی مهرگان سیستم']),
									'http://mehregan-system.com/',['target'=>'_blank','escape'=>false])?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<div id="gotoTop" class="icon-angle-up"></div>
	<?= $this->html->script([
		'/template/js/plugins.min.js',
		'/template/js/functions.js',
	]);?>
	<?php $this->Func->footer();?>
</body>
</html>