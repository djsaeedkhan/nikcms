<?= $this->element('Template.header')?>
<style>
@media (max-width: 500px){
	.postcontent h3{
		text-align: center;
	}
	.postcontent .button-small i{
		display:none;
	}
	.postcontent .button.button-small {
		padding: 7px 10px;
		margin: 0 1px;
		margin-bottom: 5px;
	}
	.postcontent .justify-content-between{
		width:inherit !important;
	}
	.chlng .comment-avatar img{
		width: inherit !important;
		height: inherit !important;
		min-height: inherit;
		max-height: 115px;
	}
	.chlng .comment-avatar {
		right: 15px;
		left: 15px;
		top: 10px;
	}
	.chlng .comment-avatar{
		max-height: 115px;
		background: transparent;
    	border: 0 solid #FFF;
	}
}
.ch_title a{
    max-width: 410px;
    display: inline-block;
    font-size: 17px;
}
</style>
<section id="content">
	<div class="content-wrap pt-4">
		<div class="container clearfix">
			<div class="row gutter-40 col-mb-80" style="font-size:14px;">
				<div class=" postcontent col-lg-8">
					<?= $this->Flash->render() ?>
					<h3 class="ch_title mb-2">
						<?= $this->html->link($challenge->title,'/challenge/'.$challenge->slug);?>
						<?php 
						if($users != null and isset($users['challengefollowers'][0])){
							echo $this->Form->postlink(
								'<i class="icon-bookmark2"></i><span>دنبال نکردن '.
								'('.(isset($challenge->challengefollowers[0]['count'])?$challenge->challengefollowers[0]['count']:0).') </span>' ,
								'/challenge/follow/'.$challenge->id,
								['escape'=>false,
								'style'=>'background-color: #cac8c8;',
								'class'=>'button button-rounded button-reveal button-small button-green text-right float-right ml-2','dir'=>'rtl']
							);
						}else{
							echo $this->Form->postlink(
								'<i class="icon-bookmark2"></i><span>دنبال کردن '.
								'('.(isset($challenge->challengefollowers[0]['count'])?$challenge->challengefollowers[0]['count']:0).') </span>' ,
								'/challenge/follow/'.$challenge->id,
								['escape'=>false,
								'style'=>'background-color: #cac8c8;',
								'class'=>'button button-rounded button-reveal button-small button-green text-right float-right ml-2','dir'=>'rtl']
							);
						}
						?>
					</h3>
					<div class="clearfix"></div>
					<ol class="chlng commentlist p-0 m-0 clearfix">
						<li>
							<div class="comment-wrap clearfix">
								<!-- <span class="comment-avatar clearfix">
									<a href="<?php //$challenge->img1?>" data-lightbox="image">
									<?php /* $this->html->image($challenge->img1,[
										'class'=>'avatar avatar-60 photo avatar-default',
										'width'=>'150','height1'=>'150',
										'alt' => $challenge->title]) */?>
									</a>
								</span>	 -->									
								<div class="comment-content clearfix">

									<!-- Slider
									============================================= -->
									<section id="slider" 
									class="slider-element dark parallax1 include-header1 include-topbar" style="background-image: url('<?=$challenge->img2?>'); background-size: cover; height: 300px;border-radius:5px;background-position: center;" data-bottom-top="background-position:0 -150px;" data-top-bottom="background-position:center" dir="ltr">
									<div class="container clearfix" style="z-index: 2;">
										
										<div class="real-estate-info-wrap" style="position: absolute;right: 0;left:inherit;bottom: 10px;width: 100%;padding: 0 45px;font-size: 13px;">
											<div class="heading-block mb-0 border-bottom-0 d-md-flex d-block align-items-center justify-content-between" dir="rtl" style="width: 90%;">
												<div class="d-flex">
													<i class="icon-folder-open"style="font-size: 33px;float: right;margin-left: 10px;    margin-top: -5px;"></i>
													وضعیت <br>
													<?=isset($challenge->challengestatus->title)?$challenge->challengestatus->title:'-'?>
												</div>
												<div class="d-flex">
													<i class="icon-group"style="font-size: 33px;float: right;margin-left: 10px;    margin-top: -5px;"></i>
													دنبال کنندگان<br>
													<?=isset($challenge->challengefollowers[0]['count'])?$challenge->challengefollowers[0]['count']:0;?>
												</div>
												<div class="d-flex">
													<i class="icon-gift"style="font-size: 33px;float: right;margin-left: 10px;    margin-top: -5px;"></i>
													میزان جایزه <br>
													<?= $challenge->price!=''?$challenge->price:'-'?>
												</div>
												<!-- <div class="d-flex">
													<i class="icon-picture"style="font-size: 33px;float: right;margin-left: 10px;    margin-top: -5px;"></i>
													بازدید<br>
													250
												</div> -->
												
												
											</div>
										</div>
									</div>
									<div class="video-wrap" style="position: absolute; top: 0; left: 0; height: 100%;z-index: 1">
										<div class="video-overlay" style="background:linear-gradient(180deg,rgba(0,0,0,.5) 0,transparent 40%,transparent 60%,rgba(0,0,0,.8));"></div>
									</div>
									</section><!-- #slider end --><br>
								</div>
							</div>
						</li>
					</ol>

					<!---------------------------------------------------------------------->
					<div class="row gutter-10 no-1gutters">
						<div class="sidebar sticky-sidebar-wrap col-lg-3">
							<div class="sidebar-widgets-wrap">
								<div class="sticky-sidebar">
									<div class="widget clearfix text-center ml-3 mt-0">
                                            <?php $lists = [
												'overview'=>'شرح موضوع',
												'resources'=>'اسناد پشتیبان',
                                                'timeline'=>'زمان بندی',
                                                'forum'=>'تبادل نظر <span class="badge badge-info float-right mt-2">'.(isset($forum_count)?$forum_count:0).'</span>',
												'updates'=>'اخبار و اطلاعیه ها',
												'community'=>'نقشه مشارکت ',
												//'partners'=>'همکاران',
                                                //'press'=>'مطبوعات',
                                                'solution'=>'مشارکت در '.__d('Template', 'همیاری').'',
                                            ];?>
                                        <?php
                                        foreach($lists as $k=>$v):
                                            echo '<div class="cal text-left '.($page == $k?'active ':'').'">';
                                            echo $this->html->link($v,'/challenge/'.$challenge->slug.'/'.$k,
                                            ['escape'=>false]);
                                            echo  '</div>';
                                        endforeach;?>
									</div>
								</div>
							</div>
                        </div>
						<style>
						
                        .button{
                            margin:0;
							max-width: 100% !important;
							letter-spacing: 0;
                        }
						.widget_links li{
							font-size:14px;
							letter-spacing: -0.5px;
						}
                        </style>

						<div class="postcontent col-lg-9 ">
							<?= $this->html->link(
								'<i class="icon-angle-right"></i><span>شروع '.__d('Template', 'همیاری').'</span>',
								'/challenge/'.$challenge->slug.'/solution/',
								['escape'=>false,
								'style'=>'background-color: #dc3545;',
								'class'=>'button button-rounded button-reveal button-small button-dirtygreen text-right float-right mr-2','dir'=>'rtl']
							);?>
							<div class="clearfix"></div>
							<div class="boxbg p-3 pt-4 mt-3">
                            	<?= $this->fetch('content');?>
							</div>
						</div>
					</div>
					<!---------------------------------------------------------------------->
				</div>

				<div class="sidebar sticky-sidebar-wrap col-lg-4"><br><br>
					<div class="sidebar-widgets-wrap">
						<div class="sticky-sidebar">

							<div class="widget widget_links clearfix boxbg">
								<div class="card">
									<div class="card-header">اطلاعات <?=__d('Template', 'همیاری')?></div>
									<div class="card-body" style="font-size: 14px;letter-spacing: -0.5px;">
										<div class="row p-p-table">
											<div class="col col-lg-4 col-5 pl-0 mb-3" style="color: #00a7d1;">
												<i class="icon-hourglass-start"></i>
												شروع و پایان</div>
											<div class="col col-lg-8 col-7 text-left">
												<?= $challenge['start_date']?> - <?=$challenge['end_date']?>
											</div>
										</div>
										<div class="row p-p-table">
											<div class="col col-lg-4 col-5 pl-0 mb-3" style="color: #00a7d1;">
												<i class="icon-indent-left"></i>
												موضوعات</div>
											<div class="col col-lg-8 col-7 text-left">
												<?php foreach($challenge->challengetopics as $temp):
													echo $temp->title;endforeach;?>
											</div>
										</div>
										<div class="row p-p-table">
											<div class="col col-lg-4 col-5 pl-0 mb-3" style="color: #00a7d1;">
												<i class="icon-paste1"></i>
												سطوح <?=__d('Template', 'همیاری')?></div>
											<div class="col col-lg-8 col-7 text-left">
												<?php foreach($challenge->challengecats as $cat):
													echo $cat->title;endforeach;?>
											</div>
										</div>
										<div class="row p-p-table">
											<div class="col col-lg-4 col-5 pl-0 mb-3" style="color: #00a7d1;">
												<i class="icon-tags1"></i>
												کلیدواژه ها</div>
											<div class="col col-lg-8 col-7 text-left">
												<div class="tagcloud rtl text-left" dir="rtl">
													<?php foreach($challenge->challengetags as $tag):
														echo $this->html->link('#'.$tag->title,'#',['class'=>'button button-border button-rounded button-aqua']);
													endforeach;?>
												</div>
											</div>
										</div>
										<div class="row p-p-table">
											<div class="col col-lg-4 col-5 pl-0 mb-3" style="color: #00a7d1;">
												<i class="icon-line-share"></i>	
												اشتراک گذاری</div>
											<div class="col col-lg-8 col-7 text-left">
												<a href="#" class="social-icon si-colored si-small si-rounded si-twitter">
													<i class="icon-twitter"></i>
													<i class="icon-twitter"></i>
												</a>
												<a href="#" class="social-icon si-colored si-small si-rounded si-rss">
													<i class="icon-rss"></i>
													<i class="icon-rss"></i>
												</a>
												<a href="#" class="social-icon si-colored si-small si-rounded si-instagram">
													<i class="icon-instagram"></i>
													<i class="icon-instagram"></i>
												</a>
											</div>
										</div>
										<!-- <div class="row p-p-table">
											<div class="col col-lg-4 col-5 mb-3">بازدید <?=__d('Template', 'همیاری')?></div>
											<div class="col col-lg-8 col-7 text-left">
												<?= isset($challenge['challengeviews'][0])?$challenge['challengeviews'][0]['views']:'0'?>
											</div>
										</div> -->
										
									</div>
								</div>
							</div>

							<?php
							$setting = setting;
							if(isset($setting['sidebar_chtitle'])):?>
							<div class="widget widget_links clearfix boxbg">
								<div class="card">
									<div class="card-header">
										<?= setting['sidebar_chtitle']?>
									</div>
									<div class="card-body pt-2">
										<?= $this->Query->Navmenu(setting['sidebar_chmenu'],[
											'div'=>false,
											'ul'=> true,'ul_class'=>'',
											'li_class'=>'',
											'a_class'=>''
										]);?>
									</div>
								</div>
							</div>
							<?php endif?>

							<div class="widget widget_links clearfix boxbg">
								<div class="card">
									<div class="card-header"><?=__d('Template', 'همیاری')?> های مرتبط</div>
									<div class="card-body">
										<div class="posts-sm row col-mb-30" id="popular-post-list-sidebar">
											<?php foreach($challenge->challengerelateds as $relatd):?>
											<div class="entry col-12">
												<div class="grid-inner row no-gutters">
													<div class="col-auto">
														<div class="entry-image">
															<?= $this->html->image($relatd->challenge->img,
																['class'=>'rounded-rounded','style'=>'width:50px;height:50px'])?>
														</div>
													</div>
													<div class="col pl-3">
														<div class="entry-title">
															<h4 class="text-justify" style="font-weight:normal">
																<?=$this->html->link($relatd->challenge->title,
																'/challenge/'.$relatd->challenge->slug
																)?>
															</h4>
														</div>
													</div>
												</div>
											</div>
											<?php endforeach?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .content-wrap end -->
</section><!-- #content end -->

<?= $this->element('Template.footer')?>