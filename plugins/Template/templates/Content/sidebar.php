<div class="col-12 col-lg-3 single-details-wrapper">
  <div class="white-box small">
    <header class="white-box-header">
      <h4 class="title"><?= setting['side_title']?></h4>
    </header>
    <aside class="related-articles">

      <?php for($i=0;$i<maxrow;$i++):if(isset(setting['side_title'.$i]) and setting['side_title'.$i] != ""):?>
      <article class="article">
        <figure class="img-wrapper img-hover-effect">
          <a href="<?= setting['side_link'.$i] ?>">
            <?= $this->html->image(setting['side_img'.$i],
              ['class'=>'img-fluid','alt'=> setting['side_title'.$i] ]);?>
          </a>
        </figure>
        <div class="d-flex flex-column justify-content-between">

          <header>
            <h4 class="title"><a href="<?= setting['side_link'.$i]?>">
              <?= setting['side_title'.$i]?>
            </a></h4>
          </header>

          <?php if(setting['side_date'.$i] != ""):?>
          <footer class="date">
            <img src="<?= siteurl?>/css/icons/calendar.svg" alt="calendar">
            <span><?= setting['side_date'.$i]?></span>
          </footer>
          <?php endif?>
          
        </div>
      </article>
      <?php endif;endfor;?>

    </aside>
    <!-- .related-articles-->
  </div>
</div>