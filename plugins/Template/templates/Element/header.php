<?php
use \Shop\View\Helper\CartHelper;
$this->Func->getSiteSetting();
if (!function_exists('get_api_price')){
  function get_api_price(){
  $ch = curl_init('https://studio.persianapi.com/index.php/web-service/gold'); // Initialise cURL
  $post = json_encode([
      'format' => 'json',
      'limit' => '30',
      'page' => '1',
  ]);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer mv4hft8it1ge1vfoikgq')); // Inject the token into the header
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Specify the request method as POST
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
  $result = curl_exec($ch); // Execute the cURL statement
  $status_code = curl_getinfo( $ch )['http_code'] ?? 0;
  curl_close($ch); // Close the cURL connection
  if ( $status_code == 200 ) {
      $response = json_decode( $result,true );
      if(isset($response['result']['data'][0]['قیمت'])){
        return $response['result']['data'][0]['قیمت']; 
      }
  } else {
    return 0;
  }
}
}?>
<!DOCTYPE html>
<html dir="rtl" lang="fa-IR" class="drtl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Mehregan-system.com" />
	<?= $this->html->css([
		'/template/css/bootstrap-rtl.css',
		'/template/css/style.css',
		'/template/css/style-rtl.css',
		'/template/css/swiper.css',
		'/template/css/font-icons.css',
		'/template/css/animate.css',
		'/template/css/magnific-popup.css',
		'/template/custom.css?'.date('dh'),
	]);?>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?= $this->Query->info('name');?><?= $this->fetch('title')!=''?' - '.$this->fetch('title'):'' ?></title>
	<?php $this->Func->header();?>
	<?= $this->html->script(['/template/js/jquery.js']);?>
  <style>
    @-moz-document url-prefix() {
      .flexslider {
        direction: rtl !important;
      }
    }
    .two-columns {
      display: grid !important;
      grid-template-columns: repeat(2, 1fr);
      gap: 5px 20px;
      width: max-content;
    }
  </style>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("ul.menu-container > li > .sub-menu-container").forEach(function (submenu) {
      const items = submenu.querySelectorAll(":scope > li");
      if (items.length > 6) {
        submenu.classList.add("two-columns");
      }
    });
  });
</script>
</head>

<body class="stretched rtls home" data-loader="14">
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class="header-size-sm" data-mobile-sticky="true">
			<div class="container">
				<div class="header-row flex-column flex-lg-row justify-content-center justify-content-lg-start pb-2onte">

					<!-- Logo
					============================================= -->
					<div id="logo" class="me-0 me-lg-auto">
						<a href="<?= $this->Query->info('siteurl');?>" class="standard-logo" data-dark-logo="<?=isset(setting['header_logo'])?setting['header_logo']:''?>">
							<img src="<?=isset(setting['header_logo'])?setting['header_logo']:''?>" alt="<?= $this->Query->info('name');?>" style="max-width: 200px;">
						</a>

						<!-- <a href="<?= $this->Query->info('siteurl');?>" class="retina-logo" data-dark-logo="<?=isset(setting['header_rlogo'])?setting['header_rlogo']:''?>">
							<img src="<?=isset(setting['header_rlogo'])?setting['header_rlogo']:''?>" alt="<?= $this->Query->info('name');?>" style="max-width: 170px;">
						</a> -->
					</div><!-- #logo end -->

					<div class="me-lg-auto d-none d-md-inline">
						<?= $this->form->create(null,['url'=>'/shop/search','type'=>'get',
              'id'=>'top-subscribe-form', 'class'=>'mb-0']);?>
						<input type="hidden" name="post_type" value="product">
							<div class="input-group mx-auto rounded-10">
								<div class="input-group-text rounded-10 fs-11 bg-white">
									<i class="icon-line-content-left fs-16"></i>
									دسته بندی
								</div>
								<input type="text" name="s" class="form-control required" 
                  placeholder="محصول خود را در فروشگاه ما جستجو کنید">
								
								<button class="btn"  type="submit">
									<i class="icon-line-search fs-20"></i>
								</button>
							</div>
						</form>
					</div>

					<div class="header-misc mb-4 mb-lg-0 order-lg-last d-none d-sm-flex">
						<a href="<?= CartHelper::Link('favorite');?>" title="لیست علاقه مندی ها">
              <i class="icon-heart1 fs-20"></i>
            </a>
						<span class="mx-3 lineer"> | </span>
						<ul class="header-extras me-0 me-sm-0">
							
							<li class="li1 rounded-20 text-white">
								<a href="<?= CartHelper::Link('cart');?>" class="text-white">
									<div class="hee-text fs-13 fw-normal" title="سبد خرید محصولات">
										سبد خرید
										<span class="rounded-6 fw-bold"><?= CartHelper::Cartcount();?></span>
									</div>
								</a>
							</li>

							<?php
							if ($this->request->getSession()->read('Auth.User')):
								echo '<li class="rounded-20 li2 fs-13">';
									echo $this->html->link('<div class="hee-text ">'.
                  $this->request->getSession()->read('Auth.User.family'),
										CartHelper::Link('profile'),
										['escape'=>false,'title'=>'مشاهده صفحه پروفایل','class'=>'text-dark text-black']);
									/* echo $this->html->link('<i class="icon-line2-login text-dark mr-2"></i>',
									'/users/logout',['escape'=>false,'title'=>'خروج از سایت']); */

								echo '<i class="icon-line-arrow-left"></i></div></li>';

							else:?>
								<li class="rounded-20 li2 fs-13">
									<a href="#modal-login-form" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">
										<div class="hee-text text-dark">
											ورود و ثبت نام
											<i class="icon-line-arrow-left"></i>
										</div>
									</a>
								</li>
							<?php endif?>
							
						</ul>
					</div>
				</div>
			</div>

			<div id="header-wrap">
				<div class="container border-top border-bottom border-3 border-f5 pt-2 pb-1">
					<div class="header-row justify-content-between flex-row-reverse flex-lg-row">
              
            <?php //if(setting['header_call_t1'] !="0"):?>
            
						<div class="header-misc">
              
              
							<div class="header-misc-icons">
								<a href="<?=setting['header_call_link']?>" class="d-flex align-items-end">
									<div class="hd1 fs-16">
										<?= setting['header_call_t1'] !=""?setting['header_call_t1']:number_format(get_api_price()).' ریال';?> 
										<div class="fs-11"><?= setting['header_call_t2']?></div>
									</div>
									<i class="icon-shopping-basket fs-20"></i>
								</a>
							</div><!-- #top-search end -->
						</div>
            <?php //endif?>

						<div class="d-flex d-sm-none align-items-center">
              <div class="col-sm-none">
                <a href="<?= $this->Query->info('siteurl');?>" class="retina-logo" data-dark-logo="<?=isset(setting['header_rlogo'])?setting['header_rlogo']:''?>">
                  <img src="<?=isset(setting['header_rlogo'])?setting['header_rlogo']:''?>" 
                  alt="<?= $this->Query->info('name');?>" style="max-width: 80px;">
                </a>
              </div>
              
							<div id="top-search" class="header-misc-icon">
								<a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
							</div><!-- #top-search end -->

							<div id="primary-menu-trigger">
								<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
							</div>
						</div>
            
            <?php if(isset(setting['topmenu']) and setting['topmenu'] != ""):?>
						<nav class="primary-menu">
							<?= $this->Query->Navmenu(setting['topmenu'],[
								'nav'=>false, 'nav_class'=>'',
								'div'=>false,
								'ul'=> true,
                'ul_class'=>'menu-container',
                'ul2_class'=> 'sub-menu-container',

								'li_class'=>'menu-item',
                'li2_class'=>'menu-item  mega-menu',

								'a_class'=>'menu-link',
                'a2_class'=>'menu-link',
               ]);?>
						</nav><!-- #primary-menu end -->
            <?php endif?>

						<?= $this->form->create(null,['url'=>'/shop/search','type'=>'get', 'class'=>'top-search-form',]);?>
							<input type="text" name="s" class="form-control" value="" placeholder="لطفا نام محصول را وارد نمایید" autocomplete="off">
							<input type="hidden" name="post_type" value="product">
						</form>

					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header><!-- #header end -->


		<div class="modal fade" id="loginRegisterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> -->
          
        <div class="modal-body tab-content p-lg-5 p-4 pt-lg-3">

          <div class="d-flexx justify-content-center mb-4 tabs">
          
            <ul class="nav nav-tabs boot-tabs" id="login-reg-tab" role="tablist">
              <li class="active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-content" role="tab">
                <a class="nav-link active" href="#login-tab-content" data-bs-toggle="tab">ورود</a></li>
                
              <li class="inline-block nav-item" id="reg-tab" data-bs-toggle="tab" onclick="return Captcha();" href="#reg-tab-content" data-bs-target="#reg-tab-content" role="tab">
                <a class="nav-link" href="#reg-tab-content" data-bs-toggle="tab">ثبت نام</a></li>
            </ul>
          </div>

          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade show active" id="login-tab-content">
              <?= $this->form->create(null,['class'=>'loginFormModal','id'=>'loginFormModal','url'=>false]);?>
                <div class="show_alert"></div>              
                <div class="form-item has-bg">
                  <label class="form-label">شماره همراه</label>
                  <?=$this->form->control('username',[
                  'class'=>'form-control','label'=>false,'required','dir'=>'ltr','data-error'=>"شماره موبایل اشتباه است"])?>
                </div>
                <div class="form-item has-bg has-icon">
                  <label class="form-label">رمز عبور</label>
                  <?= $this->form->control('password',['type'=>'password',
                    'class'=>'form-control','label'=>false,'autocomplete'=>'off','dir'=>'ltr','required'])?>

                  <?php // $this->html->image('/template/css/icons/eye.svg',['class'=>'icon cursor-pointer show-pass']);?>
                  <?php // $this->html->image('/template/css/icons/eye.svg',['style'=>'display: none', 'class'=>'icon cursor-pointer hide-pass']);?>
                  
                  <div class="form-group captcha">
                    <div class="d-none">
                      <?= $this->html->image(null,['class'=>'captcha_img'])?>
                      <?= $this->form->control('securitycode',['type'=>'text','class'=>'form-control captcha_field','dir'=>'ltr','label'=>false,'autocomplete'=>'off'])?>
                    </div>
                  </div>
                  
                </div>
                <button class="btn btn-primary w-100 mt-4 btnlogin" onclick="return onLogin()" type="submit">ورود به سایت</button>
              <?= $this->form->end()?>
            </div>


          <!-- login-tab-content-->
            <div class="tab-pane fade" id="reg-tab-content">
                <?= $this->form->create(null,['class'=>'loginFormModal registerForm','id'=>'registerForm','url'=>false]);?>
                <div class="show_alerts"></div>

                <div class="form-item has-bg">
                  <label class="form-label">نام و نام خانوادگی</label>
                  <?= $this->form->control('family',[
                    'placeholder'=>'', 'class'=>'form-control', 'label'=>false, 'required'])?>
                </div>

                <div class="form-item has-bg">
                  <label class="form-label">شماره همراه</label>
                  <?= $this->form->control('username',[
                  'placeholder'=>'09..',
                  'class'=>'form-control','label'=>false,'required','dir'=>'ltr','data-error'=>"شماره موبایل اشتباه است"])?>
                </div>


                <div class="form-item has-bg">
                  <label class="form-label">رمز عبور</label>
                  <?=  $this->form->control('password',['type'=>'password',
                    'class'=>'form-control','label'=>false,'autocomplete'=>'off','dir'=>'ltr','required'])?>
                </div>

                <div class="">
                  <?= $this->html->image(null,['class'=>'captcha_img'])?>
                  <?= $this->form->control('securitycode',['disabled1','class'=>'form-control captcha_field','dir'=>'ltr','label'=>false,'autocomplete'=>'off'])?>
                </div>
                
                <!-- <div class="form-item select has-bg">
                  <label class="form-label">استان</label>
                  <select class="form-control" name="">
                    <option value="">استان را انتخاب کنید</option>
                    <option value="0">اصفهان</option>
                    <option value="1">تهران</option>
                    <option value="2">خراسان شمالبی</option>
                  </select>
                </div>
                <div class="form-item has-bg has-icon">
                  <label class="form-label">رمز عبور</label>
                  <input class="form-control" type="password" name="password" required>
                  <?php // $this->html->image('/template/css/icons/eye.svg',['class'=>'icon cursor-pointer show-pass']);?>
                  <?php /*  $this->html->image('/template/css/icons/eye.svg',[
                    'style'=>'display: none',
                    'class'=>'icon cursor-pointer hide-pass']); */?>
                  
                </div> -->
                <a class="btn btn-lg btn-primary w-100 mt-4 btnreg" onclick="return onRegister()" type="submit">
                  ثبت نام در سایت
                </a>
              <?= $this->form->end()?>
            </div>
            <!-- reg-tab-content-->
          </div>


          <!-- active-tab-content-->
          <div class="tab-pane fade" id="activeModal">
            <form class="loginFormModalWithCode" id="loginFormModalWithCode" method="post" data-toggle="validator" role="form">
              <div class="activebox"></div>
              <p>کد پیامک شده را وارد نمایید</p>
              <div class="form-group">
                <div class="">
                  <?=$this->form->control('mobile',[
                    'class'=>'form-control','label'=>false,'required','dir'=>'ltr'])?>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <a class="btn btn-lg btn-primary w-100 mt-4 btnActive" onclick="return onActive()">ثبت کد </a>
            </form>
          </div>
          <!-- active-tab-content-->


        </div>
      </div>
    </div>
  </div>


  <div class="container text-left">
    <?= $this->Flash->render() ?>

    <?php 
    if(($this->getRequest()->getSession()->read('Flash'))){
      $msg = $this->getRequest()->getSession()->read('Flash');
      if(isset($msg['flash'][0]['message']) and $msg['flash'][0]['message'] != ''):?>
        <script type="text/javascript">  
        $(document).ready(function () {$('#myModal').modal('show');});
        </script>
        <div id="myModal" class="modal fade"><div class="modal-dialog"><br><br><br><br><br><div class="modal-content">
          <div class="modal-body col-xs-12 text-center alert alert-warning pt-3 mb-0">
            <p class="pt-3">
              <?= str_replace('X',' ',strip_tags($this->Flash->render(),'<a><br>'))?>
            </p>
          </div>
        </div></div></div>
      <?php endif;
    }?>

  </div>