<?= $this->element('header');
global $result;?>
<main id="main-content">

  <section id="slider-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-lg-6">
          <div class="main-site-text">
            <header>
              <h1 class="title"><span class="d-inline-block" data-aos="fade-up" data-aos-duration="700"><?= setting['bx1_title']?></span>
              <?= $this->html->image('/template/css/icons/lamp.svg',['class'=>'','data-aos'=>"fade-up",'data-aos-duration'=>"700"]);?>
              <span class="d-block" data-aos="fade-up" data-aos-duration="700"><?= setting['bx1_title2']?></span></h1>
            </header>
            <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
              <?= setting['b1_desc']?>
            </p>
            
            <div class="buttons">
              <?php if(setting['b1_linkt'] != ""):?>
              <a class="btn btn-lg btn-outline-white" href="<?= setting['b1_link']?>" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                <?= setting['b1_linkt']?>
              </a>
              <?php endif?>

              <?php if(setting['b2_linkt'] != ""):?>
                <a class="btn btn-lg btn-primary" href="<?= setting['b2_link']?>" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                  <?= setting['b2_linkt']?>
                </a>
              <?php endif?>

            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div id="main-slider" data-aos="fade-up" data-aos-duration="700">
            <div class="swiper-wrapper">

              <?php for($i=0;$i<maxrow;$i++):if(isset(setting['bx1_sltitle'.$i]) and setting['bx1_sltitle'.$i] != ""):?>
              <div class="swiper-slide">
                <figure><a href="<?= setting['bx1_sllink'.$i]?>">
                  <?= $this->html->image( setting['bx1_slimg'.$i],
                    ['alt'=> setting['bx1_sltitle'.$i]]);?>
                </a></figure>
                <div class="slider-content">
                  <p class="sub-title"><?= setting['bx1_sltitle'.$i]?></p>
                  <p class="title">
                    <?= setting['bx1_sldesc'.$i]?>
                  </p>
                </div>
              </div>
              <?php endif;endfor?>
              
            </div>
            <!-- .swiper-wrapper-->
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

    <div class="primary-bg-home section">
      <section class="section position-relative"><span class="circles-pattern-transparent"></span>
        <div class="container position-relative"><span class="circles-pattern"></span>
          <div class="last-posts-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div>
                <header class="section-title green-pattern mb-1" data-aos="fade-up" data-aos-duration="700">
                  <h4 class="text"><?= setting['bx2_title']?></h4>
                </header>
                <p class="text-16 fw-500 mb-0" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                  <?= setting['bx2_desc']?>
                </p>
              </div>

              <?php if(setting['bx2_linkt'] != ""):?>
                <div class="d-none d-lg-block" data-aos="fade-up" data-aos-duration="700">
                  <a class="btn btn-primary btn-lg" href="<?= setting['bx2_link']?>"><?= setting['bx2_linkt']?></a>
                </div>
              <?php endif?>

            </div>
            <div class="row h-scroll-mobile">

              <?php 
              $challenge = \Cake\ORM\tableregistry::getTableLocator()
                ->get('Challenge.Challenges')
                ->find('all')
                ->where([
                  ((isset(setting['bx2_posts']) and setting['bx2_posts'] != "")?
                    ['Challenges.id IN '=>setting['bx2_posts']]:false),
                  'Challenges.enable'=>1
                  ])
                ->order(['Challenges.priority'=>'asc'])
                ->contain([
                  'Challengestatuses',
                  'Challengefields',
                  'Challengecats',
                  'Challengetopics',
                  'Challengetags'])
                ->toarray();
              foreach($challenge as $ch):
                $time = $this->Func->DiffDateFa("now", $ch['end_date']);
                $ch['content'] = $ch['descr'];?>
                <div class="col-12 col-lg-4 post-item-wrapper" data-aos="fade-up" data-aos-duration="700">
                  <article class="post-item">
                    <figure class="img-wrapper img-hover-effect">
                      <a class="d-block" href="<?= \Cake\Routing\Router::url('/challenge/'.$ch['slug']);?>">
                        <img class="img-fluid" src="<?= $ch['img']?>" alt="<?= $ch['title']?>" style="min-height: 140px;height: 140px;">
                      </a>
                      <span class="post-status"><?= $ch['enable'] == 1?'فعال':'غیرفعال'?></span>
                    </figure>
                    <a href="<?= \Cake\Routing\Router::url('/challenge/'.$ch['slug']);?>">
                      <header>
                        <h3 class="title">
                          <?= $ch['title']?>
                        </h3>
                      </header>

                      <p class="category">
                        <img src="<?=siteurl?>/css/icons/badge-primary.svg">
                        <?php 
                        if(isset($ch['challengecats']) and is_array($ch['challengecats'])):
                        foreach($ch['challengecats'] as $tmp):?>
                          <span>
                            <?= $tmp['title']?>
                          </span>
                        <?php endforeach;endif;?>
                      </p>

                      <?php // $this->Query->the_excerpt($ch,65)?>

                      <div class="time">
                        <div>
                          <p class="remaining">
                            <?=$time > 0?intval($time).' روز باقی مانده است':'پایان یافته'?>
                          </p>
                          <span class="status">
                            <?= isset($ch['challengestatus']['title'])?$ch['challengestatus']['title']:'-'?>
                          </span>
                        </div>
                        <span class="start">شروع</span>
                      </div>
                    </a>

                  </article>
                  <!--.post-item-->
                </div>
                <!-- .post-item-wrapper-->
              <?php endforeach?>

            </div>
            <!-- end of posts-->
            
            <?php if(setting['bx2_linkt'] != ""):?>
              <div class="d-blcok d-lg-none"><a class="btn btn-primary btn-lg w-100" href="<?= setting['bx2_link']?>">
                <?= setting['bx2_linkt']?>
              </a></div>
            <?php endif?>
          </div>
        </div>
      </section>
      <!-- end of last posts section-->

      <section class="section steps-section">
        <div class="container">
          <div class="d-flex justify-content-center justify-content-lg-between align-items-center">
            <div>
              <header class="section-title green-pattern text-white mobile-center mb-1" data-aos="fade-up" data-aos-duration="700">
                <h4 class="text"><?= setting['bx3_title']?></h4>
              </header>
              <p class="text-16 fw-500 text-white mobile-center mb-0" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                <?= setting['bx3_desc']?>
              </p>
            </div>

            <?php if(setting['bx3_linkt'] != ""):?>
              <div class="d-none d-lg-block" data-aos="fade-up" data-aos-duration="700"><a class="btn btn-white btn-lg" href="<?= setting['bx3_link']?>">
                <?= setting['bx3_linkt']?></a>
              </div>
            <?php endif?>
          </div>

          <div class="steps">
            <div class="row">

              <?php $i=0;if(isset(setting['bxx3_title'.$i]) and setting['bxx3_title'.$i] != ""):setting['bxx3_title'.$i]?>
              <div class="col-6 col-lg-3">
                <div class="step top-icon">
                  <figure class="icon" data-aos="fade-up" data-aos-duration="700">
                    <?= $this->html->image(setting['bxx3_img'.$i],['class'=>'white','alt'=>setting['bxx3_title'.$i]]);?>
                    <?= $this->html->image(setting['bxx3_img2'.$i],['class'=>'primary','alt'=>setting['bxx3_title'.$i]]);?>
                  </figure>
                  <span class="number" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <?= setting['bxx3_num'.$i]?>
                  </span>
                  <h6 class="title" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <?= setting['bxx3_title'.$i]?>
                  </h6>
                  <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= setting['bxx3_desc'.$i]?>
                  </p>
                </div>
              </div>
              <!-- end of one step-->
              <?php endif;?>
              
              <?php $i=1;if(isset(setting['bxx3_title'.$i]) and setting['bxx3_title'.$i] != ""):setting['bxx3_title'.$i]?>
              <div class="col-6 col-lg-3">
              
                <div class="step bottom-icon d-none d-lg-block">
                  <span class="number" data-aos="fade-up" data-aos-duration="700">
                    <?= setting['bxx3_num'.$i]?>
                  </span>
                  <h6 class="title" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <?= setting['bxx3_title'.$i]?>
                  </h6>
                  <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <?= setting['bxx3_desc'.$i]?>
                  </p>
                  <figure class="icon top" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= $this->html->image(setting['bxx3_img'.$i],['class'=>'white','alt'=>setting['bxx3_title'.$i]]);?>
                    <?= $this->html->image(setting['bxx3_img2'.$i],['class'=>'primary','alt'=>setting['bxx3_title'.$i]]);?>
                  </figure>
                </div>

                <div class="step top-icon d-block d-lg-none">
                  <figure class="icon top" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= $this->html->image(setting['bxx3_img'.$i],['class'=>'white','alt'=>setting['bxx3_title'.$i]]);?>
                    <?= $this->html->image(setting['bxx3_img2'.$i],['class'=>'primary','alt'=>setting['bxx3_title'.$i]]);?>
                  </figure>
                  <span class="number" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <?= setting['bxx3_num'.$i]?>
                  </span>
                  <h6 class="title" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <?= setting['bxx3_title'.$i]?>
                  </h6>
                  <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= setting['bxx3_desc'.$i]?>
                  </p>
                </div>

              </div>
              <!-- end of one step-->
              <?php endif;?>

              <?php $i=2;if(isset(setting['bxx3_title'.$i]) and setting['bxx3_title'.$i] != ""):setting['bxx3_title'.$i]?>
              <div class="col-6 col-lg-3">
                <div class="step top-icon">
                  <figure class="icon" data-aos="fade-up" data-aos-duration="700">
                    <?= $this->html->image(setting['bxx3_img'.$i],['class'=>'white','alt'=>setting['bxx3_title'.$i]]);?>
                    <?= $this->html->image(setting['bxx3_img2'.$i],['class'=>'primary','alt'=>setting['bxx3_title'.$i]]);?>
                  </figure>
                  <span class="number" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <?= setting['bxx3_num'.$i]?>
                  </span>
                  <h6 class="title" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <?= setting['bxx3_title'.$i]?>
                  </h6>
                  <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= setting['bxx3_desc'.$i]?>
                  </p>
                </div>
              </div>
              <!-- end of one step-->
              <?php endif;?>

              <?php $i=3;if(isset(setting['bxx3_title'.$i]) and setting['bxx3_title'.$i] != ""):setting['bxx3_title'.$i]?>
              <div class="col-6 col-lg-3">

                <div class="step bottom-icon d-none d-lg-block">
                  <span class="number" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <?= setting['bxx3_num'.$i]?>
                  </span>
                  <h6 class="title" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <?= setting['bxx3_title'.$i]?>
                  </h6>
                  <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= setting['bxx3_desc'.$i]?>
                  </p>
                  <figure class="icon top" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= $this->html->image(setting['bxx3_img'.$i],['class'=>'white','alt'=>setting['bxx3_title'.$i]]);?>
                    <?= $this->html->image(setting['bxx3_img2'.$i],['class'=>'primary','alt'=>setting['bxx3_title'.$i]]);?>
                  </figure>
                </div>

                <div class="step top-icon d-blcok d-lg-none">
                  <figure class="icon top" data-aos="fade-up" data-aos-duration="700">
                    <?= $this->html->image(setting['bxx3_img'.$i],['class'=>'white','alt'=>setting['bxx3_title'.$i]]);?>
                    <?= $this->html->image(setting['bxx3_img2'.$i],['class'=>'primary','alt'=>setting['bxx3_title'.$i]]);?>
                  </figure>
                  <span class="number" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <?= setting['bxx3_num'.$i]?>
                  </span>
                  <h6 class="title" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150">
                    <?= setting['bxx3_title'.$i]?>
                  </h6>
                  <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <?= setting['bxx3_desc'.$i]?>
                  </p>
                </div>
              </div>
              <!-- end of one step-->
              <?php endif;?>

            </div>
          </div>
          <!-- .steps-->
          
          <?php if(setting['bx3_linkt'] != ""):?>
            <div class="d-block d-lg-none mt-4" data-aos="fade-up" data-aos-duration="700">
              <a class="btn btn-white btn-lg w-100" href="<?= setting['bx3_link']?>"><?= setting['bx3_linkt']?></a>
            </div>
          <?php endif?>

        </div>
      </section>
      <!-- end of section steps-->


      <section class="knowledge-center-section">
        <div class="container position-relative">
          <div class="circles-pattern"></div>
          <div class="knowledge-center-wrapper">
            <header class="section-title green-pattern center mb-1" data-aos="fade-up" data-aos-duration="700">
              <h4 class="text"><?= setting['bx5_title']?></h4>
            </header>

            <p class="text-16 fw-500 text-center" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
              <?= setting['bx5_desc']?>
            </p>

            <div class="d-flex justify-content-center justify-content-lg-between align-items-center mt-4" data-aos="fade-up" data-aos-duration="700">
              <ul class="pill-nav-tabs" id="pill-tab" role="tablist">
                <?php for($i=0;$i<maxrow;$i++):if(isset(setting['bx5t_tab_title'. $i]) and setting['bx5t_tab_title'. $i] != ""):?>
                  <li class="nav-item <?=$i == 0?'active':''?>" id="pill-tab-<?=$i?>" data-bs-toggle="tab" data-bs-target="#pill-tab-<?=$i?>-content" role="tab">
                    <?= setting['bx5t_tab_title'. $i]?>
                  </li>
                <?php endif;endfor?>
              </ul>
              
              <?php if(setting['bx5_linkt'] != ""):?>
                <div class="d-none d-lg-flex" data-aos="fade-up" data-aos-duration="700">
                  <a class="btn btn-primary btn-lg" href="<?= setting['bx5_link']?>">
                    <?= setting['bx5_linkt']?>
                  </a>
                </div>
              <?php endif?>
            </div>
            <div class="tab-content knowledge-center">
              
            <?php for($i=0;$i<maxrow;$i++):if(isset(setting['bx5t_tab_title'. $i]) and setting['bx5t_tab_title'. $i] != ""):?>
              <div class="tab-pane fade <?= $i==0?'show active':''?>" id="pill-tab-<?=$i?>-content">
                <div class="row justify-content-lg-between h-scroll-mobile">
                  
                  <?php 
                  if(setting['bx5t_post1'.$i] != ""):
                    $result = $this->Query->post(null,[
                      'contain'=>['PostMetas','Categories'],
                      'get_type'=>'first',
                      'id'=> setting['bx5t_post1'.$i],
                  ]);
                  ?>
                  <div class="col-12 col-lg-5 knowledge-item-wrapper" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <article class="knowledge-item">
                      <figure class="img-wrapper img-hover-effect"><a class="d-block" href="<?= $this->Query->the_permalink()?>">
                        <?= $this->html->image(setting['bx5t_image1'.$i],
                          ['class'=>'img-fluid','alt'=>$this->Query->the_title()]);?></a>
                      </figure>
                      <header>
                        <h4 class="title">
                          <a class="line-clamp-1" href="<?= $this->Query->the_permalink()?>">
                          <?= $this->Query->the_title()?>
                        </a></h4>
                      </header>
                      <p class="description"><?= $this->Query->the_excerpt()?></p>
                    </article>
                  </div>
                  <?php endif?>

                  <?php 
                  if(setting['bx5t_posts'.$i] != ""):
                    $results = $this->Query->post(null,[
                      'contain'=>['PostMetas'],
                      'get_type'=>'all',
                      'id'=> setting['bx5t_posts'.$i],
                    ]);

                    if($results): foreach( $results as $result):
                      $img = $this->Query->postimage('large',$result);
                    ?>
                    <div class="col-12 col-lg-5 knowledge-item-wrapper d-block d-lg-none" data-aos="fade-up" data-aos-duration="700">
                      <article class="knowledge-item">

                        <?php if($img != ""):?>
                        <figure class="img-wrapper img-hover-effect">
                          <a class="d-block" href="<?= $this->Query->the_permalink()?>">
                            <?= $this->html->image($img, ['class'=>'img-fluid','alt'=>$this->Query->the_title()]);?>
                          </a>
                        </figure>
                        <?php endif?>

                        <header>
                          <h4 class="title">
                            <a class="line-clamp-1" href="<?= $this->Query->the_permalink()?>">
                              <?= $this->Query->the_title()?>
                            </a>
                          </h4>
                        </header>

                        <p class="description"><?= $this->Query->the_excerpt()?></p>
                      </article>
                    </div>
                    <?php endforeach;endif;
                  endif;

                  if(setting['bx5t_posts_topic'.$i] != ""):
                    $results = $this->Query->post(null,[
                      'contain'=>['PostMetas'],
                      'get_type'=>'all',
                      'id'=> setting['bx5t_posts_topic'.$i],
                    ]);

                    if($results): foreach( $results as $result):
                      $img = $this->Query->postimage('large',$result);
                    ?>
                    <div class="col-12 col-lg-5 knowledge-item-wrapper d-block d-lg-none" data-aos="fade-up" data-aos-duration="700">
                      <article class="knowledge-item">

                        <?php if($img != ""):?>
                        <figure class="img-wrapper img-hover-effect">
                          <a class="d-block" href="<?= $this->Query->the_permalink()?>">
                            <?= $this->html->image($img, ['class'=>'img-fluid','alt'=>$this->Query->the_title()]);?>
                          </a>
                        </figure>
                        <?php endif?>

                        <header>
                          <h4 class="title">
                            <a class="line-clamp-1" href="<?= $this->Query->the_permalink()?>">
                              <?= $this->Query->the_title()?>
                            </a>
                          </h4>
                        </header>

                        <p class="description"><?= $this->Query->the_excerpt()?></p>
                      </article>
                    </div>
                    <?php endforeach;endif;
                  endif;
                  ?>

                  <!-- end of right section-->
                  <div class="col-12 col-lg-6 d-none d-lg-block">

                  <?php 
                  if(setting['bx5t_posts'.$i] != ""):
                    $results = $this->Query->post(null,[
                      'contain'=>['PostMetas'],
                      'get_type'=>'all',
                      'id'=> setting['bx5t_posts'.$i],
                    ]);

                    if($results):$j=0; foreach( $results as $result): $j++;
                      $img = $this->Query->postimage('large',$result);
                    ?>
                    <article class="knowledge-item small" data-aos="fade-up" data-aos-duration="700" data-aos-delay="<?=$j?>00">
                      <figure class="img-wrapper img-hover-effect">
                        <a class="d-block" href="<?= $this->Query->the_permalink()?>">
                          <?= $this->html->image($img,['class'=>'img-fluid','alt'=> $this->Query->the_title() ]);?>
                        </a>
                      </figure>
                      <header>
                        <h4 class="title"><a class="line-clamp-2" href="<?= $this->Query->the_permalink()?>">
                          <?= $this->Query->the_title()?>
                        </a></h4>
                      </header>
                    </article>
                    <?php endforeach;endif;
                  endif;

                  if(setting['bx5t_posts_topic'.$i] != ""):
                    $results = $this->Query->post(null,[
                      'contain'=>['PostMetas'],
                      'get_type'=>'all',
                      'id'=> setting['bx5t_posts_topic'.$i],
                    ]);

                    if($results):$j=0; foreach( $results as $result): $j++;
                      $img = $this->Query->postimage('large',$result);
                    ?>
                    <article class="knowledge-item small" data-aos="fade-up" data-aos-duration="700" data-aos-delay="<?=$j?>00">
                      <figure class="img-wrapper img-hover-effect">
                        <a class="d-block" href="<?= $this->Query->the_permalink()?>">
                          <?= $this->html->image($img,['class'=>'img-fluid','alt'=> $this->Query->the_title() ]);?>
                        </a>
                      </figure>
                      <header>
                        <h4 class="title"><a class="line-clamp-2" href="<?= $this->Query->the_permalink()?>">
                          <?= $this->Query->the_title()?>
                        </a></h4>
                      </header>
                    </article>
                    <?php endforeach;endif;
                  endif;
                  ?>
                    
                  </div>
                  <!-- end of left section-->
                </div>
                <!-- end of .row-->

                <?php if(setting['bx5_linkt'] != ""):?>
                <div class="d-blcok d-lg-none" data-aos="fade-up" data-aos-duration="700">
                  <a class="btn btn-primary btn-lg w-100" href="<?= setting['bx5_link']?>">
                  <?= setting['bx5_linkt']?>
                </a></div>
                <?php endif?>
              </div>
              <!-- end of #pill-tab-3-content-->
              <?php endif;endfor?>

            </div>
          </div>
        </div>
      </section>
      <!-- end of section knowledge-center-->
    </div>
    <!-- end of .primary-bg-home-->


    <div class="after-primary-bg-home"></div>
    <section class="section multimedia-section">
      <div class="container">
        <div class="multimedia-wrapper">
          <div class="circles-pattern"></div>
          <div class="d-flex justify-content-center justify-content-lg-between align-items-center">
            <div>
              <header class="section-title green-pattern text-white mobile-center mb-1" data-aos="fade-up" data-aos-duration="700">
                <h4 class="text"><?= setting['bx6_title1']?></h4>
              </header>
              <p class="text-16 fw-500 text-white mobile-center mb-0" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                <?= setting['bx6_title2']?>
              </p>
            </div>

            <?php if(setting['bx6_linkt'] != ""):?>
              <div class="d-none d-lg-block" data-aos="fade-up" data-aos-duration="700">
                <a class="btn btn-primary btn-lg" href="<?= setting['bx6_link']?>"><?= setting['bx6_linkt']?></a>
              </div>
            <?php endif?>
          </div>
          <section class="multimedia-content">
            <div class="row justify-content-lg-between align-items-center flex-column-reverse flex-lg-row">
              <div class="col-12 col-lg-5">
                <header data-aos="fade-up" data-aos-duration="700">
                  <h3 class="title"><?= setting['bx6_ttitle1']?></h3>
                </header>
                <p class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                  <?= setting['bx6_ttitle2']?>
                </p>
              </div>
              <div class="col-12 col-lg-6">

                <?php if(setting['bx6_film'] != ""):?>
                <div class="video-wrapper" data-aos="fade-up" data-aos-duration="700">
                  <video src="<?= setting['bx6_film']?>" poster="<?= setting['bx6_filmc']?>" controls></video>
                </div>
                <?php endif?>

              </div>
            </div>
          </section>
          <section class="multimedia-items">
            <div class="row h-scroll-mobile">

              <?php for($i=0;$i<maxrow;$i++):if(isset(setting['bxx6_title'.$i]) and setting['bxx6_title'.$i] != ""):?>
              <div class="col-12 col-lg-3 multimedia-item-wrapper" data-aos="fade-up" data-aos-duration="700">
                <div class="multimedia-item">
                  <figure class="img-wrapper img-hover-effect">
                    <a class="d-block" href="<?= setting['bxx6_link'.$i]?>">
                      <?= $this->html->image(setting['bxx6_image'.$i],['class'=>'img-fluid','alt'=>setting['bxx6_title'.$i]]);?>
                    </a>
                  </figure>
                  <header>
                    <h5 class="title"><a href="<?= setting['bxx6_link'.$i]?>">
                      <?= setting['bxx6_title'.$i]?>
                    </a></h5>
                  </header>
                  <p class="description">
                    <?= setting['bxx6_desc'.$i]?>
                  </p>
                </div>
              </div>
              <?php endif;endfor?>

            </div>
          </section>
          <!-- .multimedia-items-->
        </div>
      </div>
    </section>
    <!-- end of multimedia section-->

    <?php if(setting['bx7_title'] != ""):?>
    <section class="section home-about-section">
      <div class="container">
        <div class="row g-2 g-lg-5">
          <div class="col-12 col-lg-6">
            <header data-aos="fade-up" data-aos-duration="700">
              <h4 class="title">
                <?= setting['bx7_title']?>
              </h4>
            </header>
            <div class="description" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
              <?= setting['bx7_desc']?>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <figure class="img-wrapper" data-aos="fade-up" data-aos-duration="700">
              <?= $this->html->image(setting['bx7_image'],['class'=>'img-fluid','alt'=> setting['bx7_title'] ]);?>
            </figure>
          </div>
        </div>
      </div>
    </section>
    <!-- end of .home-about-section-->
    <?php endif?>

  </main>
<?= $this->element('footer');?>