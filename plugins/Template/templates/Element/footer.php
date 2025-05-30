<?php use Cake\Routing\Router;?>
<footer id="main-footer">
      <div class="container">
        <div class="row">
          <section class="col-12 col-lg-4">
            <header>
              <h4 class="footer-title"><?= setting['footer_title1']?></h4>
              <h5 class="footer-subtitle"><?= setting['footer_title2']?></h5>
            </header>

            <p class="footer-description">
              <?= setting['footer_desc']?>
            </p>

            <div class="d-none d-lg-block">
              <div class="social-networks-wrapper">
                <p class="title">ما را در شبکه های اجتماعی دنبال کنید</p>
                <ul class="social-networks">

                  <?php if(setting['footer_soc_insta'] != ""):?>
                    <li><a href="<?= setting['footer_soc_insta']?>" target="_blank" title="اینستاگرام">
                      <img src="<?=siteurl?>/css/icons/instagram.svg" alt="instagram"></a></li>
                  <?php endif?>

                  <?php if(setting['footer_soc_linked'] != ""):?>
                    <li><a href="<?= setting['footer_soc_linked']?>" target="_blank" title="لینکدین">
                      <img src="<?=siteurl?>/css/icons/linkedin.svg" alt="linkedin"></a></li>
                  <?php endif?>

                  <?php if(setting['footer_soc_faceb'] != ""):?>
                  <li><a href="<?= setting['footer_soc_faceb']?>" target="_blank" title="فیسبوک">
                    <img src="<?=siteurl?>/css/icons/facebook.svg" alt="facebook"></a></li>
                  <?php endif?>

                  <?php if(setting['footer_soc_twitt'] != ""):?>
                  <li><a href="<?= setting['footer_soc_twitt']?>" target="_blank" title="توییتر">
                    <img src="<?=siteurl?>/css/icons/twitter.svg" alt="twitter"></a></li>
                  <?php endif?>

                  <?php if(setting['footer_soc_teleg'] != ""):?>
                  <li><a href="<?= setting['footer_soc_teleg']?>" target="_blank" title="تلگرام">
                    <img src="<?=siteurl?>/css/icons/telegram.svg" alt="telegram"></a></li>
                  <?php endif?>

                  <?php if(setting['footer_soc_aprt'] != ""):?>
                  <li><a href="<?= setting['footer_soc_aprt']?>" target="_blank" title="آپارات">
                    <img src="<?=siteurl?>/css/icons/aparat.svg" alt="aparat"></a></li>
                  <?php endif?>

                </ul>
              </div>
            </div>
          </section>
          <!-- end of right section-->
          <section class="col-12 col-lg-8 left-section">
            <div class="row px-lg-4">
              <div class="col-6">
                <div class="footer-links">
                  <header>
                    <h6 class="title"><?= setting['footer_menut1']?></h6>
                  </header>
                  <nav>
                    <?= $this->Query->Navmenu(setting['footer_menu1'],[
                      'div'=>false,
                      'nav'=>false,
                      'ul'=> true,
                      'ul_class'=>'',
                      'li_class'=>'',
                    ]);?>
                  </nav>
                </div>
              </div>
              <div class="col-6">
                <div class="footer-links">
                  <header>
                    <h6 class="title"><?= setting['footer_menut2']?></h6>
                  </header>
                  <nav>
                    <?= $this->Query->Navmenu(setting['footer_menu2'],[
                      'div'=>false,
                      'nav'=>false,
                      'ul'=> true,
                      'ul_class'=>'',
                      'li_class'=>'',
                    ]);?>
                  </nav>
                </div>
              </div>
            </div>
            <div class="d-none d-lg-block">
              <div class="footer-slider-wrapper">
                <div class="footer-sliders">
                  <div class="image-slider swiper-container">
                    <div class="swiper-wrapper">

                      <?php for($i=0;$i<maxrow;$i++):if(isset(setting['footer_slide_title'.$i]) and setting['footer_slide_title'.$i] != ""):?>
                      <div class="swiper-slide">
                        <figure>
                          <img src="<?= setting['footer_slide_image'.$i]?>" alt="<?= setting['footer_slide_title'.$i]?>">
                        </figure>
                      </div>
                      <?php endif;endfor?>
                    </div>
                  </div>
                  <!-- .image-slider-->
                  <div class="content-slider swiper-container">
                    <div class="swiper-wrapper">

                      <?php for($i=0;$i<maxrow;$i++):if(isset(setting['footer_slide_title'.$i]) and setting['footer_slide_title'.$i] != ""):?>
                      <div class="swiper-slide">
                        <div class="slider-content">
                          <p class="title">
                            <?= setting['footer_slide_title'.$i]?>
                          </p>
                        </div>
                      </div>
                      <?php endif;endfor?>

                    </div>
                    <div class="slider-details">
                      <div class="footer-swiper-pagination"></div>
                      <div class="swiper-navigation-wrapper"><span class="swiper-navigation swiper-button-prev"></span><span class="swiper-navigation swiper-button-next"></span></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- end of left section-->
          <div class="d-block d-lg-none">
            <div class="social-networks-wrapper">
              <p class="title">ما را در شبکه های اجتماعی دنبال کنید</p>
              <ul class="social-networks">
                <?php if(setting['footer_soc_insta'] != ""):?>
                  <li><a href="<?= setting['footer_soc_insta']?>" target="_blank" title="اینستاگرام">
                    <img src="<?=siteurl?>/css/icons/instagram.svg" alt="instagram"></a></li>
                <?php endif?>

                <?php if(setting['footer_soc_linked'] != ""):?>
                  <li><a href="<?= setting['footer_soc_linked']?>" target="_blank" title="لینکدین">
                    <img src="<?=siteurl?>/css/icons/linkedin.svg" alt="linkedin"></a></li>
                <?php endif?>

                <?php if(setting['footer_soc_faceb'] != ""):?>
                <li><a href="<?= setting['footer_soc_faceb']?>" target="_blank" title="فیسبوک">
                  <img src="<?=siteurl?>/css/icons/facebook.svg" alt="facebook"></a></li>
                <?php endif?>

                <?php if(setting['footer_soc_twitt'] != ""):?>
                <li><a href="<?= setting['footer_soc_twitt']?>" target="_blank" title="توییتر">
                  <img src="<?=siteurl?>/css/icons/twitter.svg" alt="twitter"></a></li>
                <?php endif?>

                <?php if(setting['footer_soc_teleg'] != ""):?>
                <li><a href="<?= setting['footer_soc_teleg']?>" target="_blank" title="تلگرام">
                  <img src="<?=siteurl?>/css/icons/telegram.svg" alt="telegram"></a></li>
                <?php endif?>

                <?php if(setting['footer_soc_aprt'] != ""):?>
                <li><a href="<?= setting['footer_soc_aprt']?>" target="_blank" title="آپارات">
                  <img src="<?=siteurl?>/css/icons/aparat.svg" alt="aparat"></a></li>
                <?php endif?>
              </ul>
            </div>

            <div class="footer-slider-wrapper">
              <div class="footer-sliders">
                <div class="image-slider swiper-container">
                  <div class="swiper-wrapper">

                    <?php for($i=0;$i<maxrow;$i++):if(isset(setting['footer_slide_title'.$i]) and setting['footer_slide_title'.$i] != ""):?>
                    <div class="swiper-slide">
                      <figure><img src="<?= setting['footer_slide_image'.$i]?>" alt="<?= setting['footer_slide_title'.$i]?>"></figure>
                    </div>
                    <?php endif;endfor?>

                  </div>
                </div>
                <!-- .image-slider-->
                <div class="content-slider swiper-container">
                  <div class="swiper-wrapper">

                    <?php for($i=0;$i<maxrow;$i++):if(isset(setting['footer_slide_title'.$i]) and setting['footer_slide_title'.$i] != ""):?>
                    <div class="swiper-slide">
                      <div class="slider-content">
                        <p class="title"><?= setting['footer_slide_title'.$i]?></p>
                      </div>
                    </div>
                    <?php endif;endfor?>

                  </div>
                  <div class="slider-details">
                    <div class="footer-swiper-pagination"></div>
                    <div class="swiper-navigation-wrapper"><span class="swiper-navigation swiper-button-prev"></span><span class="swiper-navigation swiper-button-next"></span></div>
                  </div>
                  
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </footer>

    <?= $this->html->script([
        '/template/js/packages/bootstrap.bundle.min.js',
        '/template/js/packages/jquery-3.7.1.min.js',
        '/template/js/packages/aos.js',
        '/template/js/packages/swiper-bundle.min.js',
        '/template/js/app.js',
    ]);?>
    <?= $this->Func->footer();?>


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
  </body>
</html>



