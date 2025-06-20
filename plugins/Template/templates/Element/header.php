<?php
$this->Func->getSiteSetting();
include_once("functions.php");

!defined('siteurl')?define('siteurl', \Cake\Routing\Router::url('/').'template/'):false;
!defined('maxrow')?define('maxrow', 10):false;
!defined('lang')?define('lang', "fa"):false;
global $is_status;
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $this->Query->info('site_favicon');?>">
    <title><?= $this->Query->Title()?></title>
    <?= $this->html->css([
      '/template/css/style.css',
      '/template/css/packages/aos.css',
      '/template/css/packages/swiper-bundle.min.css',
    ]);?>
    <?= $this->html->script([
      '/template/js/packages/jquery-3.7.1.min.js',
    ]);?>
    <style>
      #securitycode{
        direction: ltr;
        text-align: left;
        font-family: sans-serif;
      }
      .captcha_img {
        margin-bottom: -77px;
        margin-right: 5px;
        border-radius: 5px;
      }
    </style>
    
    <?php $this->Func->header()?>
    <?php if(isset(setting['morecss']) and setting['morecss'] != ''):?>
      <style><?=setting['morecss']?></style>
    <?php endif?>
  </head>
  <body>

  <header id="main-header">
    <div class="container">
      <div class="top-header">
        <?= $this->html->image('/template/css/images/amoozesh-logo-white.png',
          ['alt'=> $this->Query->Title() ]);?>
      </div>
      <div class="logo-navbar-wrapper"><a class="logo" href="/">
        <?= setting['header_logow'] != ""?$this->html->image(setting['header_logow'],[
          'style'=>'height:100%;',
          'alt' => $this->Query->Title()
          ]):'';?>
        </a>
        <div class="navbar-wrapper">
          <nav class="main-navbar">
            <?= $this->Query->Navmenu(setting['topmenu'],[
              'div'=>false,
              'nav'=>false,
              'ul'=> true,
              'ul_class'=>'',
              'ul2_class'=>'second-lvl-menu',
              'li_class'=>'',
              'drop_class'=>'has-submenu',
            ]);?>
          </nav>

          <?php if ($this->request->getAttribute('identity')):
            $Fullname = ($this->request->getAttribute('identity')->get('family') != ""?
              $this->request->getAttribute('identity')->get("family"):
              $this->request->getAttribute('identity')->get('username'));
            ?>
            <div class="user-dropdown-toggler">
              <?= $this->html->image('/template/css/icons/user-square.svg',['class'=>'user-icon']);?>

              <span class="name">
                <?= $Fullname ?>
              </span>
              <?= $this->html->image('/template/css/icons/arrow-down.svg',['class'=>'arrow-down']);?>

              <ul class="user-dropdown">

                <li class="active">
                  <?= $this->html->link(
                    $this->html->image('/template/css/icons/user-octagon.svg',['alt'=>'صفحه پروفایل']). $Fullname ,
                    '/challenge/profile',
                    ['escape'=>false,'title'=>'صفحه پروفایل']);?>
                  
                </li>

                <li>
                  <?= $this->html->link(
                    $this->html->image('/template/css/icons/like-tag.svg',['alt'=>'سوابق مشارکت']). ' سوابق مشارکت',
                    '/challenge/profile/challenge',
                    ['escape'=>false,'title'=>'سوابق مشارکت']);?>
                </li>

                <li>
                  <?= $this->html->link(
                    $this->html->image('/template/css/icons/message-text.svg',['alt'=>'پشتیبانی']). ' پشتیبانی',
                    '/tickets/index',
                    ['escape'=>false,'title'=>'پشتیبانی']);?>
                </li>

                <li>
                  <?= $this->html->link(
                    $this->html->image('/template/css/icons/logout.svg',['alt'=>'صفحه خروج از سایت'])." خروج",
                    '/users/logout',
                    ['escape'=>false,'title'=>'خروج از سایت'])?>
                </li>
              </ul>
            </div>

          <?php else:?>
            <button class="btn btn-md btn-white" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">ورود/ثبت نام</button>
          <?php endif;?>

        </div>
      </div>
    </div>
  </header>

  <header id="mobile-header">
    <div>
      <span class="bars">
        <?= $this->html->image('/template/css/icons/hamburger.svg',['class'=>'hamburger']);?>
        <?= $this->html->image('/template/css/icons/close-white.svg',['class'=>'close']);?>
      </span>
      <a class="logo" href="/">
        <?= setting['header_logow'] != ""?
          $this->html->image(setting['header_logow'],['alt' => $this->Query->Title() ]):'';?>
      </a>
    </div>

    <?php 
    if ( $this->request->getAttribute('identity') ):?>
      <div class="user-dropdown-toggler">
        <?= $this->html->image('/template/css/icons/user-square.svg',[
          'style'=>'filter: invert(1);',
          'class'=>'user-icon']);?>

        <span class="name">
          <?= $Fullname;?>
        </span>
        <?= $this->html->image('/template/css/icons/arrow-down.svg',[
          'style'=>'filter: invert(1);',
          'class'=>'arrow-down']);?>

        <ul class="user-dropdown">
          <li class="active">
            <?= $this->html->link(
              $this->html->image('/template/css/icons/user-octagon.svg',['alt'=>'صفحه پروفایل']). $Fullname,
              '/challenge/profile',
              ['escape'=>false,'title'=>'صفحه پروفایل']);?>
            
          </li>

          <li>
            <?= $this->html->link(
              $this->html->image('/template/css/icons/like-tag.svg',['alt'=>'سوابق مشارکت']). ' سوابق مشارکت',
              '/challenge/profile/challenge',
              ['escape'=>false,'title'=>'سوابق مشارکت']);?>
          </li>

          <?php $lists = [
              //'profile/index'=>'<img class="user-icon" src="'.siteurl.'/css/icons/user-octagon.svg" alt="user icon">مشخصات پروفایل',
              'profile/edit'=>'<img class="user-icon" src="'.siteurl.'/css/icons/user-octagon.svg" alt="user icon">ویرایش کاربری',
              //'profile/challenge'=>'<img class="user-icon" src="'.siteurl.'/css/icons/like-tag.svg" alt="like icon">سوابق مشارکت',
              'profile/password'=>'<img class="user-icon" src="'.siteurl.'/css/icons/message-text.svg" alt="message icon">تغییر رمز عبور',
              //'../tickets/index' => '<img class="user-icon" src="'.siteurl.'/css/icons/message-text.svg" alt="message icon">'.__d('Template', 'درخواست های پشتیبانی'),
              //'../users/logout'=>'<img class="user-icon" src="'.siteurl.'/css/icons/logout.svg" alt="logout icon">خروج',
            ];
            foreach($lists as $k=>$v):
              echo '<li class="'.((isset($page) and $page == $k)?'active ':'').' d-sm-block">';
              echo $this->html->link($v,'/challenge/'.$k,
                ['escape'=>false]);
              echo  '</li>';
            endforeach;?>

          <li>
            <?= $this->html->link(
              $this->html->image('/template/css/icons/message-text.svg',['alt'=>'پشتیبانی']). ' پشتیبانی',
              '/tickets/index',
              ['escape'=>false,'title'=>'پشتیبانی']);?>
          </li>

          <li>
            <?= $this->html->link(
              $this->html->image('/template/css/icons/logout.svg',['alt'=>'صفحه خروج از سایت'])." خروج",
              '/users/logout',
              ['escape'=>false,'title'=>'خروج از سایت'])?>
          </li>

        </ul>
      </div>
    <?php else:?>
      <button class="btn btn-md btn-white" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">ورود/ثبت نام</button>
    <?php endif;?>
    
    <nav class="mobile-menu">
      <?= $this->Query->Navmenu(setting['topmenu'],[
        'div'=>false,
        'nav'=>false,
        'ul'=> true,
        'ul_class'=>'',
        'ul2_class'=>'second-lvl-menu',
        'li_class'=>'',
      ]);?>
    </nav>
  </header>

  <div class="modal fade" id="loginRegisterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body tab-content p-lg-5 p-4 pt-lg-3">
          <div class="d-flex justify-content-center mb-4">
            <ul class="pill-nav-tabs" id="login-reg-tab" role="tablist">
              <li class="nav-item active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-content" role="tab">ورود</li>
              <li class="nav-item" id="reg-tab" data-bs-toggle="tab" 
              onclick="return Captcha();"
              data-bs-target="#reg-tab-content" role="tab">
                ثبت نام</li>
            </ul>
          </div>


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

                <?= $this->html->image('/template/css/icons/eye.svg',['class'=>'icon cursor-pointer show-pass']);?>
                <?= $this->html->image('/template/css/icons/eye.svg',['style'=>'display: none', 'class'=>'icon cursor-pointer hide-pass']);?>
                
                <div class="form-group captcha">
                  <div class="d-none">
                    <?= $this->html->image(null,[ 'class'=>'captcha_img'])?>
                    <?= $this->form->control('securitycode',['type'=>'text','class'=>'form-control captcha_field','dir'=>'ltr','label'=>false,'autocomplete'=>'off'])?>
                  </div>
                </div>
                
              </div>
              <button class="btn btn-lg btn-primary w-100 mt-4 btnlogin" onclick="return onLogin()" type="submit">ورود به سایت</button>
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
                <?= $this->html->image('/template/css/icons/eye.svg',['class'=>'icon cursor-pointer show-pass']);?>
                <?= $this->html->image('/template/css/icons/eye.svg',[
                  'style'=>'display: none',
                  'class'=>'icon cursor-pointer hide-pass']);?>
                
              </div> -->
              <a class="btn btn-lg btn-primary w-100 mt-4 btnreg" onclick="return onRegister()" type="submit">
                ثبت نام در سایت
              </a>
            <?= $this->form->end()?>
          </div>
          <!-- reg-tab-content-->


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
  <script>
    $( document ).ready(function() {
      $(".auth-wrapper").attr('id', 'main-content');
    });
  </script>
  <style>
    .card-title.font-weight-bold{
      font-size: 20px;
    }
  </style>