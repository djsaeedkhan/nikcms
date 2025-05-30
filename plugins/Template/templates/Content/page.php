<?= $this->element('header');

$metalist = $this->Func->MetaList($result);
$bk_result = $result;?>
<main id="main-content">
  <header class="page-header">
    <div class="img-wrapper" style="background-image: url('<?= siteurl?>/temp/page-header.png')"></div>
    <div class="content">
      <h1 class="title"><?= $this->Query->the_title()?></h1>
      <div class="nav-tabs-wrapper">

        <?php
        if(isset($metalist['menu_id']) and $metalist['menu_id'] != ""){
          echo $this->Query->Navmenu($metalist['menu_id'],[
						'div'=>false,
						'nav'=>false,
						'ul'=> true,'ul_class'=>'underline-nav-tabs scroll-to-itemss',
						'ul2'=> false,'ul2_class'=>'',
						'li_class'=>'nav-item item',
						'a_class'=>'text-white'
					]);
        }?>

      </div>
    </div>
  </header>

  <section class="container single-book">
    <div class="row align-items-start">
      <div class="col-12 col-lg-9">
        <section class="white-box page-content-wrapper" id="introduce-section">
          <header class="white-box-header" data-aos="fade-up" data-aos-duration="700">
            <h2 class="title"><?= $this->Query->the_title()?></h2>
          </header>
          <div class="book-details">
            <div class="row justify-content-lg-between align-items-start flex-column-reverse flex-lg-row">
              
              <div class="col-12">
                <?= $this->Query->the_content()?>
              </div>

              <div class="col-12">
                <div>
                  <header class="d-block d-lg-none" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <h3 class="book-title"><?= $this->Query->the_title()?></h3>
                  </header>
                  <figure class="img-wrapper img-hover-effect over me-auto ms-auto me-lg-auto ms-lg-0" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <?php 
                    $img = $this->Query->the_image(['size'=>'large']);
                    if($img != ""):
                      echo $this->html->image($img, ['class'=>'img-fluid','alt'=>$this->Query->the_title()]);
                    endif?>
                </figure>
                </div>
              </div>
            </div>
          </div>
          
        </section>

        <?php if(isset($metalist['author_name']) and $metalist['author_name'] != ""):?>
        <section class="white-box page-content-wrapper mt-4" id="author-section" data-aos="fade-up" data-aos-duration="700">
          <header class="white-box-header">
            <h2 class="title">درباره نویسنده</h2>
          </header>
          <div class="author-details">
            <figure class="img-wrapper"><img src="<?= $metalist['author_image']?>" alt="<?= $metalist['author_name']?>"></figure>
            <div>
              <h4 class="name"><?= $metalist['author_name']?></h4>
              <span class="job"><?= $metalist['author_pos']?></span>
            </div>
          </div>
          <p><?= $metalist['author_desc']?></p>
        </section>
        <?php endif?>

        <?php if(isset($metalist['g1_title0']) and $metalist['g1_title0'] != ""):?>
        <section class="white-box page-content-wrapper mt-4" id="gallery-section" data-aos="fade-up" data-aos-duration="700">
          <header class="white-box-header">
            <h2 class="title">گالری تصاویر</h2>
          </header>
          <div id="image-gallery">
            <!-- Main slider-->
            <div class="swiper-container gallery-top">
              <div class="swiper-wrapper">

                <?php for($i=0;$i<maxrow;$i++):if(isset($metalist['g1_image'.$i]) and $metalist['g1_image'.$i] != ""):?>
                <div class="swiper-slide">
                  <img src="<?= $metalist['g1_image'.$i]?>" alt="<?= $metalist['g1_title'.$i]?>">
                  <p class="slider-title"><?= $metalist['g1_title'.$i]?></p>
                </div>
                <?php endif;endfor?>

              </div>
            </div>

            <!-- Thumbnail-->
            <div class="swiper-container gallery-thumbs">
              <div class="swiper-wrapper">

                <?php for($i=0;$i<maxrow;$i++):if(isset($metalist['g1_image'.$i]) and $metalist['g1_image'.$i] != ""):?>
                <div class="swiper-slide"><img src="<?= $metalist['g1_image'.$i]?>" alt="<?= $metalist['g1_title'.$i]?>">
                  <div class="slider-overlay">
                    <p class="title"><?= $metalist['g1_title'.$i]?></p>
                  </div>
                </div>
                <?php endif;endfor?>
                
              </div>
              <div class="swiper-navigation-wrapper"><span class="swiper-navigation swiper-button-prev"></span><span class="swiper-navigation swiper-button-next"></span></div>
            </div>
          </div>
          <!-- #image-gallery-->
        </section>
        <?php endif?>

        <?php if(isset($metalist['video_src']) and $metalist['video_src'] != ""):?>
        <section class="white-box page-content-wrapper mt-4" id="video-section" data-aos="fade-up" data-aos-duration="700">
          <header class="white-box-header">
            <h2 class="title">ویدئو</h2>
          </header>
          <div class="video-box">
            <figure class="img-wrapper">
              <img src="<?= $metalist['video_cover']?>" alt="<?= $metalist['video_title']?>">
              <header class="title-wrapper">
                <h5 class="title"><?= $metalist['video_title']?></h5>
              </header>
              <div class="play-btn" data-bs-toggle="modal" data-bs-target="#videoModal">
                <img src="<?= siteurl?>/css/images/play-circle.png" alt="play video">
              </div>
            </figure>
          </div>
        </section>
        <?php endif?>

      </div>
      <?php include_once('sidebar.php')?>
    </div>
  </section>

  <?php if(isset($metalist['video_src']) and $metalist['video_src'] != ""):?>
  <div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $metalist['video_title']?></h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <video class="w-100 h-100 rounded-2" src="<?= $metalist['video_src']?>" controls></video>
        </div>
      </div>
    </div>
  </div>
  <?php endif?>

</main>
<?= $this->element('footer');?>