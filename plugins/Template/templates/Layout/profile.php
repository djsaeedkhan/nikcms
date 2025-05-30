<?= $this->element('Template.header');
	$page = isset($page)?$page:'null'?>
<main id="main-content">
	<div class="container profile-page-wrapper">
	<div class="row align-items-start">
		<div class="col-lg-3 d-none d-lg-block profile-sidebar-wrapper">
		<aside class="profile-sidebar">
			<div class="white-box small">
				<ul>
				<?php $lists = [
					'profile/index'=>'<img class="user-icon" src="'.siteurl.'/css/icons/user-octagon.svg" alt="user icon">مشخصات پروفایل',
					'profile/edit'=>'<img class="user-icon" src="'.siteurl.'/css/icons/user-octagon.svg" alt="user icon">ویرایش کاربری',
					'profile/challenge'=>'<img class="user-icon" src="'.siteurl.'/css/icons/like-tag.svg" alt="like icon">سوابق مشارکت',
					'profile/password'=>'<img class="user-icon" src="'.siteurl.'/css/icons/message-text.svg" alt="message icon">تغییر رمز عبور',
					'../tickets/index' => '<img class="user-icon" src="'.siteurl.'/css/icons/message-text.svg" alt="message icon">'.__d('Template', 'درخواست های پشتیبانی'),
					'../users/logout'=>'<img class="user-icon" src="'.siteurl.'/css/icons/logout.svg" alt="logout icon">خروج',
				];
				foreach($lists as $k=>$v):
					echo '<li class="'.($page == $k?'active ':'').'">';
					echo $this->html->link($v,'/challenge/'.$k,
						['escape'=>false]);
					echo  '</li>';
				endforeach;?>
				</ul>
			</div>
		</aside>
		</div>
		<div class="col-lg-9 col-12">
			<div class="white-box small mb-4">
				<header class="profile-section-header">
					<div class="icon-text-wrapper">
						<span class="icon-wrapper">
							<img src="<?=siteurl?>/css/icons/profile-secondary.svg" alt="">
						</span>
						<span class="text">
							<?php
							if(isset($page)):
								switch ($page) {
									case 'profile/index':echo 'مشخصات پروفایل';break;
									case 'profile/edit':echo 'ویرایش کاربری';break;
									case 'profile/challenge':echo 'سوابق مشارکت';break;
									case 'profile/password':echo 'تغییر رمز عبور';break;
									default:break;
								}
							endif;

							if(isset($current)):
								switch ($current) {
									case 'new':echo 'درخواست جدید';break;
									case 'submit':echo 'مشاهده جزئیات درخواست';break;
									default:echo 'درخواست های پشتیبانی';break;
								}
							endif;
							
							?>
						</span></div>
				</header>
				<?= $this->Flash->render() ?>
				<?= $this->fetch('content');?>

				<!-- <form class="row">
				<div class="col-lg-4 col-12">
					<div class="form-item select has-bg">
					<label class="form-label">نهاد برگزار کننده</label>
					<select class="form-control" name="">
						<option value="">انتخاب کنید</option>
						<option value="0">نهاد اول</option>
						<option value="1">نهاد دوم</option>
						<option value="2">نهاد سوم</option>
					</select>
					</div>
				</div>
				<div class="col-lg-4 col-12">
					<div class="form-item select has-bg">
					<label class="form-label">وضعیت جمع سپاری</label>
					<select class="form-control" name="">
						<option value="">انتخاب کنید</option>
						<option value="0">وضعیت اول</option>
						<option value="1">وضعیت دوم</option>
						<option value="2">وضعیت سوم</option>
					</select>
					</div>
				</div>
				<div class="col-lg-4 col-12 d-flex justify-content-lg-end justify-content-center mt-4">
					<button class="btn btn-lg btn-primary btn-mobile-full" type="submit">جستجو</button>
				</div>
				</form> -->
			</div>

		</div>
	</div>
	<!-- .row-->
	</div>
	<!-- .container-->
</main>
<script>
$('.white-box .input.text').addClass("form-item has-bg");
$('.white-box .input.select').addClass("form-item has-bg");
$('.white-box .input.textarea').addClass("form-item has-bg");
$('.white-box .input.email').addClass("form-item has-bg");
</script>
<?= $this->element('Template.footer')?>