<?php
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
echo $this->element('Template.header');
?>

<main id="main-content">
  <header class="page-header">
    <div class="img-wrapper" style="background-image: url('<?= siteurl?>/temp/page-header.png')"></div>
    <div class="content">
      <h1 class="title">لیست جمع سپاری ها</h1>
    </div>
  </header>

  <?= $this->Flash->render() ?>

  <section class="container">
    <div class="mobile-filters-toggler-wrapper"><span class="fw-700 text-16 d-flex align-items-center toggler" style="cursor:pointer"><img class="ms-2" src="<?=siteurl?>/css/icons/filter-outline.svg" alt="">مشاهده فیلترها</span></div>
    <div class="row align-items-start g-lg-5">
      <div class="col-12 col-lg-8">
        <div class="posts-list">

        <?php $i=1; 
        foreach($challenges as $ch):
        $time = $this->Func->DiffDateFa("now", $ch['end_date']);
        $ch['content'] = $ch['descr'];?>

          <article class="post-list-item" data-aos="fade-up" data-aos-duration="700">
            <figure class="img-wrapper img-hover-effect">
              <a class="d-block" href="<?= Router::url('/challenge/'.$ch['slug']);?>">
                <img class="img-fluid" src="<?= $ch['img']?>" alt="<?= $ch['title']?>">
              </a>
              <span class="post-status" style="<?php
              switch($ch->challengestatus->id){
                case '1': echo 'background:#2AA2CB';break; //فعال
                case '2': echo 'background:#a1356c';break; //غیر فعال
                case '3': echo 'background:#8167b1';break; //درحال ارزیابی 
                case '4': echo 'background:#a1356c';break; //خاتمه یافته  
              }
              ?>"><?= isset($ch->challengestatus->title)?$ch->challengestatus->title:'' ; ?></span>
            </figure>
            <div class="post-content"><a href="<?= Router::url('/challenge/'.$ch['slug']);?>">
              <header>
                <h3 class="title">
                  <?= $ch['title']?>
                </h3>
              </header>
              <p class="category">
                <?php 
                if(isset($ch['challengetopics']) and is_array($ch['challengetopics'])):
                foreach($ch['challengetopics'] as $tmp):?>
                  <img src="<?= $tmp['img'] !=""?$tmp['img']:siteurl.'/css/icons/badge-primary.svg';?>" alt="<?= $tmp['title']?>">
                  <span>
                    <?= $tmp['title']?>
                  </span>
                <?php endforeach;endif;?>
              </p>

              <?= $this->Query->the_excerpt($ch,65)?>

              <div class="time-wrapper">
                <div class="time">
                  <p class="remaining">
                    <?=$time > 0?intval($time).' روز باقی مانده است':'پایان یافته'?>
                  </p>
                  <span class="status">
                    <?= isset($ch['challengestatus']['title'])?$ch['challengestatus']['title']:'-'?>
                  </span>
                </div><span class="start">شروع</span>
              </div></a>
            </div>
            <!-- .post-content-->
          </article>
          <!-- .post-list-item-->
          <?php endforeach?>
          
          
        </div>
        <!-- .posts-list-->

      </div>
      <!-- end of right section-->
      <div class="col-12 col-lg-4 post-sidebar-wrapper">
        <?php 
        echo $this->Form->create(null,['type'=>'get','id'=>'form1']);
        $param = $this->request->getQuery();
        //@$this->request->data = $param;
        $this->request = $this->request->withParsedBody($param);
        ?>
        
        <aside class="post-filters">
          <header class="header"><span class="title">فیلترها</span><span class="del-filters">حذف فیلترها</span></header>
          <div class="filter-item active" data-aos="fade-up" data-aos-duration="700">
            <header class="filter-title">
              <p class="text">
                <img class="icon" src="<?=siteurl?>/css/icons/filter-icon.png" alt="">
                لیست موضوعات
              </p>
              <img class="arrow" src="<?=siteurl?>/css/icons/arrow-down.svg" alt="">
            </header>
            <div class="filter-options">
              <?php /* $this->form->control('topics',[
                'empty'=>'-- موضوعات --',
                'label'=>false,
                'type'=>'select',
                'options'=>$topics,
                'default'=>$this->request->getQuery('topics'),
                'class'=>'form-control mb-3',
              ]); */?>
              
              <?php foreach($topics as $tp=>$tv):?>
              <div class="filter-option2 p-1">
                <div class="form-check">
                  <input class="form-check-input" name="topics" id="filter-<?= $tp?>" type="checkbox" value="<?= $tp?>">
                  <label class="form-check-label" for="filter-<?= $tp?>"><?= $tv?></label>
                </div><!-- <span class="count">3</span> -->
              </div>
              <?php endforeach;?>

            </div>
          </div>

          
          <!-- end of one .filter-item-->
          <div class="filter-item active" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
            <header class="filter-title">
              <p class="text">
                <img class="icon" src="<?=siteurl?>/css/icons/filter-icon.png" alt="">
                وضعیت جمع سپاری
              </p>
              <img class="arrow" src="<?=siteurl?>/css/icons/arrow-down.svg" alt="">
            </header>
            <div class="filter-options" style="display: block;">
              <?php /* $this->form->control('status',[
                'empty'=>'-- وضعیت جمع سپاری --',
                'label'=>false,
                'type'=>'select',
                'options'=>$status,
                'default'=>$this->request->getQuery('status'),
                'class'=>'form-control mb-3',
              ]); */?>

              <?php foreach($status as $tp=>$tv):?>
              <div class="filter-option3 p-1">
                <div class="form-check">
                  <input class="form-check-input" name="status" id="filterr-<?= $tp?>" type="checkbox" value="<?= $tp?>">
                  <label class="form-check-label" for="filterr-<?= $tp?>"><?= $tv?></label>
                </div><!-- <span class="count">3</span> -->
              </div>
              <?php endforeach;?>

            </div>
          </div>
          <!-- end of one .filter-item-->

          <?= $this->form->button(
                '<span>جستجو</span><span class="icon icon-arrow-circle-left"></span>',
                ['escape'=>false,'class'=>'btn btn-lg btn-primary w-100 mt-4']
              );?>

        </aside>
        <?= $this->Form->end();?>
        <!-- .post-filters-->
      </div>
    </div>
    <!-- .row-->
  </section>
</main>

<style>
  .filter-options{
    /* display:block; */
  }
</style>
<?= $this->element('Template.footer')?>

<script>
$('.filter-option2 .form-check').change(function () {
  updateURL2();
});
$('.del-filters').click(function () {
  $('.filter-option2 .form-check .form-check-input').prop('checked', false)
  updateURL2();
})
function updateURL2() {
  let url = new URL(window.location);
  let checkedValues = $('.filter-option2 .form-check .form-check-input:checked').map(function () {
      return this.value;
  }).get();
  if (checkedValues.length) {
    url.searchParams.set('topics', checkedValues.join(','));
  } else {
    url.searchParams.delete('topics');
  }
  window.history.replaceState({}, '', url);
}
let urlParams = new URLSearchParams(window.location.search);
let items = urlParams.get('topics');
if (items) {
  let itemsArray = items.split(',');
  $('.filter-option2 .form-check .form-check-input').each(function () {
      let isFilterItemOpen = false;
      if (itemsArray.includes(this.value)) {
        isFilterItemOpen = true;
        this.checked = true;
      }
      if (isFilterItemOpen) {
        $(this).closest('.filter-item').addClass('active').find('.filter-options').slideDown('fast');
      }
  });
}
//-------------------------------------
$('.filter-option3 .form-check').change(function () {
  updateURL3();
});
$('.del-filters').click(function () {
  $('.filter-option3 .form-check .form-check-input').prop('checked', false)
  updateURL3();
})
function updateURL3() {
  let url = new URL(window.location);
  let checkedValues = $('.filter-option3 .form-check .form-check-input:checked').map(function () {
      return this.value;
  }).get();
  if (checkedValues.length) {
    url.searchParams.set('status', checkedValues.join(','));
  } else {
    url.searchParams.delete('status');
  }
  window.history.replaceState({}, '', url);
}
let urlParams3 = new URLSearchParams(window.location.search);
let items3 = urlParams3.get('status');
if (items3) {
  let itemsArray3 = items3.split(',');
  $('.filter-option3 .form-check .form-check-input').each(function () {
      let isFilterItemOpen = false;
      if (itemsArray3.includes(this.value)) {
        isFilterItemOpen = true;
        this.checked = true;
      }
      if (isFilterItemOpen) {
        $(this).closest('.filter-item').addClass('active').find('.filter-options').slideDown('fast');
      }
  });
}
</script>
