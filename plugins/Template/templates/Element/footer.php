<?php 
use Cake\Routing\Router;
use \Shop\View\Helper\CartHelper;
?>

<style>
    .mobile-footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: #ffffff;
      border-top: 1px solid #ddd;
      z-index: 999;
    }
    .mobile-footer .nav-link {
      font-size: 12px;
      color: #555;
    }
    .mobile-footer .nav-link.active {
      color: #0d6efd;
    }
    @media screen and (max-width: 600px) {
      #footer{
        padding-bottom:80px;
      }
    }
</style>

<!-- فوتر موبایل -->
  <nav class="mobile-footer d-md-none">
    <div class="d-flex justify-content-around py-2">
      <a href="/" class="nav-link text-center">
        <i class="icon-line-home fs-20"></i><br>
        <small>خانه</small>
      </a>
      <a href="<?= CartHelper::Link('cart');?>" class="nav-link text-center">
        <i class="icon-line-shopping-bag fs-20"></i><br>
        <small>سبد خرید 
          <?php $count = CartHelper::Cartcount();
          if($count > 0):?>
          <span class="rounded-6 fw-bold badge badge-success" style="background: #08B681;">
            <?= CartHelper::Cartcount();?>
          </span>
          <?php endif?>
        </small>
      </a>
      <a class="nav-link text-center" href="<?= CartHelper::Link('favorite');?>" title="لیست علاقه مندی ها">
        <i class="icon-heart1 fs-20"></i><br>
         علاقه مندی
      </a>
      <?php if ( $this->request->getAttribute('identity')->get('id') ):?>
        <?= $this->html->link('<i class="icon-user-circle1 fs-20"></i><br><small>صفحه پروفایل</small>',
              CartHelper::Link('profile'),
              ['escape'=>false,'title'=>'مشاهده صفحه پروفایل','class'=>'nav-link text-center']);?>
        
      <?php else:?>
        <a href="#modal-login-form" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" class="nav-link text-center">
          <i class="icon-user1 fs-20"></i><br>
          <small>ورود و ثبت نام</small>
        </a>
      <?php endif?>
    </div>
  </nav>

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
								<p class="mb-0 fs-13 text-justify lh-30">
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
							<p class="text-justify lh-30 fs-13">
								<?= setting['footer_about_desc']?>
							</p>
						</div>
						<div class="col-md-4 text-center">
							<a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=497643&Code=4fT3CetnS2m77trM8r2QUvVzIXUPM7tK'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=497643&Code=4fT3CetnS2m77trM8r2QUvVzIXUPM7tK' alt='' style='cursor:pointer' code='4fT3CetnS2m77trM8r2QUvVzIXUPM7tK'></a>
						</div>
					</div>
					<div>
						<div class="d-sm-flex f-d3">
							<div class="mb-3 mb-sm-0 text-justify ls-0 fs-13">
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
	
<script>
/* $(window).on('load', function() {
  $('#activeModal').modal('show');
}); */

function Captcha(){
  var mySrc = "<?= Router::url('/create-captcha?type=number&field=securitycode&width=120&height=40&theme=default&length=4&1668635190599');?>";
  var glue = '?';
  $('.captcha_img').attr('src', mySrc + glue + new Date().getTime());
}
function loginform(){
  var all_data='...';
  let myform = document.getElementById("loginFormModal");
  let fd = new FormData(myform);
  $('.show_alert').html('');
  $.ajax({
      type : 'POST',dataType: 'html',cache: false,contentType: false,processData: false,async: true,data: fd,
      url : '<?= Router::url('/users/login')?>' ,
      beforeSend: function(){
        //$('.'+mclass).html('درحال دریافت اطلاعات');
        $('.btnlogin').prop('disabled', true);
        $('.btnlogin').text('ورود ...');
      },
      complete: function(){
        /* $('.show_alert').html(''); */
        //$('.btnlogin').prop('disabled', false);
      },
      success : function(data){
        var retdata = JSON.parse(data);
        console.log(retdata);
        if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "error" ){
          $('.captcha .d-none').removeClass('d-none');
          $('.captcha_field').removeAttr('disabled');
          var mySrc = "<?= Router::url('/create-captcha?type=number&field=securitycode&width=120&height=40&theme=default&length=4&1668635190599');?>";
            //$('.captcha_img').attr('src');
          var glue = '?';
          $('.captcha_img').attr('src', mySrc + glue + new Date().getTime());
        }
        if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "success" ){
          $('.show_alert').html($('.show_alert').html() + `<div class="alert alert-success">`+retdata['alert']+`</div>`);
        }
        else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "error" ){
          $('.show_alert').html($('.show_alert').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
        }
        else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "info"){
          $('.show_alert').html($('.show_alert').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
        }
        if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null ){
          $('.show_alert').html(`<div class="alert alert-success">`+retdata['alert']+`</div>`);
          setTimeout(function(){
            if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null &&  retdata['code'] == 'R4'){
              window.location.replace(retdata['referer'] );
            }
            else if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null){
              window.location.replace(retdata['referer'] );
            }
          },2000);
        }
        $('.btnlogin').prop('disabled', false);
        $('.btnlogin').text('ورود');
      },
      error:function (XMLHttpRequest, textStatus, errorThrown) {
        $('.show_alert').html(`<div class="alert alert-danger">در دریافت اطلاعات خطایی رخ داده است</div>`);
        $('.btnlogin').prop('disabled', false);
        $('.btnlogin').text('ورود');
      }
  });
  return all_data;
}
function onLogin(){
  loginform();
}
function onActive(){
  $('.activebox').html('');
  let myform = document.getElementById("loginFormModalWithCode");
  let fd = new FormData(myform);
  $.ajax({
    type : 'POST',dataType: 'html',cache: false,contentType: false,processData: false,async: true,data: fd,
    url : '<?= Router::url('/sms/activation/activate')?>' ,
    beforeSend: function(){
      $('.activebox').html('در حال دریافت اطلاعات. لطفا منتظر بمانید');
      $('.btnActive').text('ثبت کد ...');
      $('.btnActive').prop('disabled', true);
    },
    complete: function(){
      $('.btnActive').prop('disabled', false);
    },
    success : function(data){

      
      $('.activebox').html('');
      $('.btnActive').prop('disabled', false);
      $('.btnActive').text('ثبت کد');
      var retdata = JSON.parse(data);
      console.log(retdata);
      if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "success" ){
        $('.activebox').html($('.activebox').html() + `<div class="alert alert-success">`+retdata['alert']+`</div>`);
      }
      else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "error" ){
        $('.activebox').html($('.activebox').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
      }
      else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "info"){
        $('.activebox').html($('.activebox').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
      }
      if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null ){
        $('.activebox').html(`<div class="alert alert-success">`+retdata['alert']+`</div>`);
      }
      setTimeout(function(){
        if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null &&  retdata['code'] == 'AT3'){
          $('.activebox').html(`<div class="alert alert-success">`+retdata['alert']+`</div>`);
          window.location.replace(retdata['referer'] );
        }
      if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null &&  retdata['code'] == 'AT2'){
          $('.activebox').html(`<div class="alert alert-success">`+retdata['alert']+`</div>`);
          window.location.replace(retdata['referer'] );
        }
      },2000);
      return false;
    },
    error:function (XMLHttpRequest, textStatus, errorThrown) {
      $('.activebox').html(`<div class="alert alert-success">دریافت اطلاعات با خطا انجام شد</div>`);
      /* $('.activebox').prop('disabled', false);
      $('.activebox').text(''); */
    }
  });
}
function activeform(){
  $('.activebox').html('');
  $.ajax({
    type : 'GET',dataType: 'html',cache: false,contentType: false,processData: false,async: true,data: false,
    url : '<?= Router::url('/sms/autoactivate')?>' ,
    beforeSend: function(){
      $('.activebox').html('در حال دریافت اطلاعات. لطفا منتظر بمانید');
    },
    complete: function(){
      /* $('.show_alerts').html(''); */
      //$('.btnreg').prop('disabled', false);
      //$('.btnreg').prop('disabled', false);
    },
    success : function(data){
      $('.activebox').html('');
      var retdata = JSON.parse(data);
      console.log(retdata);
      if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "success" ){
        $('.activebox').html($('.activebox').html() + `<div class="alert alert-success">`+retdata['alert']+`</div>`);
      }
      else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "error" ){
        $('.activebox').html($('.activebox').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
      }
      else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "info"){
        $('.activebox').html($('.activebox').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
      }
      if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null ){
        $('.activebox').html(`<div class="alert alert-success">`+retdata['alert']+`</div>`);
      }
      setTimeout(function(){
        if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null &&  retdata['code'] == 'AC4'){
          //alert(retdata['alert']);
          //$('#activeModal').modal('show');
          $('#activeModal .px-5').removeClass('d-none');
        }
        else if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null){
          //window.location.replace(retdata['referer'] );
        }
      },2000);
    },
    error:function (XMLHttpRequest, textStatus, errorThrown) {
      $('.activebox').html(`<div class="alert alert-success">دریافت اطلاعات با خطا انجام شد</div>`);
      /* $('.activebox').prop('disabled', false);
      $('.activebox').text(''); */
    }
  });
}
function registerform(){
  var all_data='...';
  let myform = document.getElementById("registerForm");
  let fd = new FormData(myform);
  $('.show_alerts').html('');
  $.ajax({
      type : 'POST',dataType: 'html',cache: false,contentType: false,processData: false,async: true,data: fd,
      url : '<?= Router::url('/users/register')?>' ,
      beforeSend: function(){
        //$('.'+mclass).html('درحال دریافت اطلاعات');
        //$('.btnreg').prop('disabled', true);
        $('.btnreg').text('ثبت نام ...');
      },
      complete: function(){
        /* $('.show_alerts').html(''); */
        //$('.btnreg').prop('disabled', false);
        $('.btnreg').prop('disabled', false);
      },
      success : function(data){
        var retdata = JSON.parse(data);
        console.log(retdata);
        if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "error" ){
          $('.captcha .d-none').removeClass('d-none');
          $('.captcha_field').removeAttr('disabled');
          //var mySrc = $('.captcha_img').attr('src');
          var mySrc = "<?= Router::url('/create-captcha?type=number&field=securitycode&width=120&height=40&theme=default&length=4&1668635190599');?>";

          var glue = '?';
          $('.captcha_img').attr('src', mySrc + glue + new Date().getTime());
        }
        if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "success" ){
          $('.show_alerts').html($('.show_alerts').html() + `<div class="alert alert-success">`+retdata['alert']+`</div>`);
        }
        else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "error" ){
          $('.show_alerts').html($('.show_alerts').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
        }
        else if(typeof retdata['type'] !== 'undefined' && retdata['type'] == "info"){
          $('.show_alerts').html($('.show_alerts').html() + `<div class="alert alert-danger">`+retdata['alert']+`</div>`);
        }
        if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null ){
          $('.show_alerts').html(`<div class="alert alert-success">`+retdata['alert']+`</div>`);
        }
        setTimeout(function(){
          if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null &&  retdata['code'] == 'R4'){
            //window.location.replace(retdata['referer'] );
            $('#reg-tab-content').removeClass("show");
            $('#reg-tab-content').removeClass("active");
            $('#activeModal').addClass("show");
            $('#activeModal').addClass("active");
            activeform();
          }
          else if(typeof retdata['referer'] !== 'undefined' && retdata['referer'] != null){
            window.location.replace(retdata['referer'] );
          }
        },2000);
        
        $('.btnreg').prop('disabled', false);
        $('.btnreg').text('ثبت نام');
      },
      error:function (XMLHttpRequest, textStatus, errorThrown) {
        $('.show_alerts').html(`<div class="alert alert-danger">در دریافت اطلاعات خطایی رخ داده است</div>`);
        $('.btnreg').prop('disabled', false);
        $('.btnreg').text('ثبت نام');
      }
  });
  return all_data;
}
function onRegister(){
  registerform();
}
</script>
<?= $this->html->script([
		'/template/js/plugins.min.js',
		'/template/js/functions.js',
    '/template/js/components/rangeslider.min.js',
	]);?>
  
	<?php $this->Func->footer();?>
</body>
</html>