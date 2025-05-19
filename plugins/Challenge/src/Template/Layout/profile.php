<?= $this->element('Template.header');?>
<section id="content">
	<div class="content-wrap pt-4">
		<div class="container clearfix">
			<div class="row gutter-40 col-mb-80">
				<div class="postcontent col-lg-12">
					<ol class="chlng commentlist p-0 m-0 clearfix">
						<li>
							<div class="comment-wrap clearfix">
								<div class="comment-meta">
									<div class="comment-author vcard">
										<span class="comment-avatar clearfix text-center">
                                            <?= $this->html->image(
												((isset($user_profiles->image) and $user_profiles->image!= '')?
												'/profile/'.$user_profiles['image']:
												'/userdefault.png')
												,[
                                                'class'=>'avatar avatar-60 photo avatar-default',
												'width'=>'150','height'=>'150',
												'style'=>'min-height:inherit;'])?>
												<?=$this->html->link('<i class="icon-camera"></i> تغییر تصویر',
												'/challenge/profile/edit',
												['escape'=>false,'title'=>'تغییر تصویر ']);?>
										</span>										
									</div>
								</div>

								<div class="comment-content clearfix">
									<section id="slider" class="slider-element dark parallax1 include-header1 include-topbar" style="background-image: url(''); background-size: cover; height: 250px;border-radius:5px;" data-bottom-top="background-position:0 -150px;" data-top-bottom="background-position:center" dir="ltr">
									<div class="container clearfix" style="z-index: 2;">
									</div>
									</section><!-- #slider end --><br>
								</div>
							</div>
						</li>
					</ol>

					<!---------------------------------------------------------------------->
					<div class="row gutter-40 ">
						<div class="sidebar sticky-sidebar-wrap col-lg-3">
							<div class="sidebar-widgets-wrap">
								<div class="sticky-sidebar">
									<div class="widget clearfix text-center">
										<?php $lists = [
											'profile/index'=>'مشخصات',
											'profile/edit'=>'تنظیمات کاربری',
											'profile/challenge'=>'سوابق مشارکت',
											'profile/password'=>'تغییر رمز عبور',
											'../users/logout'=>'خروج',
										];
                                        foreach($lists as $k=>$v):
                                            echo '<div class="cal text-left '.($page == $k?'active ':'').'">';
                                            echo $this->html->link($v,'/challenge/'.$k,
                                            	['escape'=>false]);
                                            echo  '</div>';
                                        endforeach;?>
									</div>
								</div>
							</div>
                        </div>
						<div class="postcontent col-lg-9">
                            <?= $this->Flash->render() ?>
                            <?= $this->fetch('content');?>
						</div>
					</div>
					<!---------------------------------------------------------------------->
				</div>
			</div>
		</div>
	</div><!-- .content-wrap end -->
</section><!-- #content end -->
<style>
.button{
	margin:0;
	max-width: 100% !important;
}
</style>
<?= $this->element('Template.footer')?>