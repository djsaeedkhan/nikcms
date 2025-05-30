<?= $this->element('header');?>

<?php if($post_type == "topics"):?>
<style>
.img-hover-effect{
  background:url('<?= setting['index_topic_img']?>')  rgb(42 162 203 / 50%);
  background-size:cover;
}
.img-hover-effect a{
  display: flex !important;
  align-items: center;
  justify-content: center;
  flex-flow: column;
  height: 215px !important;
  font-size: 21px;
  font-weight: bold;
}
</style>
<?php endif?>

<main id="main-content">
  <header class="page-header">
    <div class="img-wrapper" style="background-image: url('<?=siteurl?>/temp/page-header.png')"></div>
    <div class="content">
      <h1 class="title"><?= $this->Query->the_category2()?></h1>
    </div>
  </header>

  <section class="container">
    <div class="mobile-filters-toggler-wrapper"><span class="fw-700 text-16 d-flex align-items-center toggler">
      <?= $this->html->image('/template/css/icons/filter-outline.svg',['class'=>'ms-2']);?>
      فیلترها</span></div>
    <div class="row align-items-start g-lg-5">
      <div class="col-12 col-lg-8">
        <div class="posts-list">

          <?php
          global $result;
          foreach($data as $result):
            $metalist = $this->Func->MetaList($result);
            $cat_metalist = [];
            if(isset($result['categories'][0])){
              $cat_metalist = $this->Func->MetaList($result['categories'][0]);
            }
            $img = $this->Query->the_image(['size'=>'large']);
            ?>
            <article class="post-list-item" data--aos="fade-up" data-aos--duration="700">
              <figure class="img-wrapper img-hover-effect">
                <a class="d-block" href="<?= $this->Query->the_permalink()?>">
                  <?php
                  if($post_type == "topics"){
                    echo '<div>'.(isset($metalist['en_title'])?$metalist['en_title']:"").'</div>';
                  }
                  else{
                    $img = $this->Query->the_image(['size'=>'large']);
                    if($img != ""):
                      echo $this->html->image($img,['class'=>'img-fluid', 'alt'=> $this->Query->the_title() ]);
                    endif;
                  }
                  ?>
                </a>
                <!-- <span class="post-status">فعال</span> -->
              </figure>

              <div class="post-content">
                <header>
                  <h3 class="title"><a href="<?= $this->Query->the_permalink()?>">
                    <?= $this->Query->the_title()?>
                  </a></h3>
                </header>

                <p class="category">
                  <?= $this->Query->the_excerpt()?>
                  <div>
                    <?= $this->html->image(
                      (isset($cat_metalist['image']) and $cat_metalist['image'] !="")?
                      $cat_metalist['image']:
                      '/template/css/icons/badge-primary.svg'
                      ,['alt'=> $this->Query->the_title()]);?>
                    <span><?= $this->Query->the_category()?></span>
                  </div>
                </p>

                
                <?php if($this->Query->is_tags($result)):?>
                  <div class="time-wrapper">
                    <div class="time" style="width: 100%;">
                      <p class="remaining">
                        <?= $this->Query->tags('',$result,['split'=>','])?>
                      </p>
                      <!-- <span class="status"><?= $this->Func->date2($result,'Y/m/d')?></span> -->
                    </div>
                    <!-- <span class="start">مشاهده</span> -->
                  </div>
                <?php endif?>
                    

              </div>
            </article>
            <!-- .post-content-->

          <?php endforeach;?>
          
          </article>
          <!-- .post-list-item-->
        </div>
        <!-- .posts-list-->
        <nav class="pagination-wrapper" data--aos="fade-up" data-aos--duration="700">
          <ul class="pagination">
          <?php
            if(!$this->request->getQuery('page')):
              $this->Paginator->options([
                  'url' => [
                  'plugin'=>'Website',
                  'controller' => (isset($post_type) and !is_array($post_type))?$post_type:false   ,
                  'action' =>'index' ,
                  $this->request->getParam('catid'),
                  $this->request->getParam('catslug'),
                  ]
              ]);
            else:
              $this->Paginator->options([
                'url' => [
                'plugin'=>'Website',
                'controller' => (isset($post_type) and !is_array($post_type))?$post_type:false   ,
                'action' =>'index' ,
                $this->request->getParam('catid'),
                $this->request->getParam('catslug'),
                ]
            ]);
            endif;
            
            $this->Paginator->setTemplates([
                'prevDisabled' => '<li class="page-item"><a href="{{url}}" class="page-link previous disabled" aria-label="Previous"><span class="fas fa-angle-right"></span></a></li>',
                'prevActive' => '<li class="page-item"><a href="{{url}}" class="page-link previous active" aria-label="Previous"><span class="fas fa-angle-right"></span></a></li>',
                'nextDisabled' => '<li class="page-item"><a href="{{url}}" class="page-link next disabled" aria-label="Next"><span class="fas fa-angle-left"></span></a></li>',
                'nextActive' => '<li class="page-item"><a href="{{url}}" class="page-link next active" aria-label="Next"><span class="fas fa-angle-left"></span></a></li>',
                'first' => '',
                'last' => '',
                'number' => '<li class="page-item page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>' ]);
            ?>
            <?= $this->Paginator->first('<< ' . __('first'),['class'=>'']) ?>
            <?= $this->Paginator->prev('< ' . __('previous'),['class'=>'']) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >',['class'=>'']) ?>
            <?= $this->Paginator->last(__('last') . ' >>',['class'=>'']) ?>
            
          </ul>
        </nav>
      </div>
      <!-- end of right section-->
      <div class="col-12 col-lg-4 post-sidebar-wrapper">
        <aside class="post-filters">
          <header class="header"><span class="title">فیلترها</span><span class="del-filters">حذف فیلترها</span></header>
          <?= $this->Form->create(null,['type'=>'get','id'=>'form1']);@$this->request->data = $param;?>

          <div class="filter-item active" data--aos="fade-up" data-aos--duration="700">
            <header class="filter-title">
              <p class="text">
                <?= $this->html->image('/template/css/icons/filter-icon.png',['class'=>'icon']);?>
                نوع <?= $this->Query->the_category2()?>
              </p>
              <?= $this->html->image('/template/css/icons/arrow-down.svg',['class'=>'arrow']);?>
            </header>
            <div class="filter-options">
            <?php $this->Form->setTemplates([
                  'checkbox' => '<input type="checkbox" name="{{name}}" class="form-check-input" value="{{value}}"{{attrs}}>',
                  'nestingLabel' => '<div class="filter-option">
                    <div class="form-check">
                      {{hidden}}{{input}}<label{{attrs}} class="form-check-label"> <span>{{text}}</span></label>
                    </div></div>' ]);
              echo $this->Form->select('cattype', 
                  $this->Query->category($post_type,['contain'=>[],'field'=>['id','title'],'limit'=>0, 'find_type'=>'treeList']), 
                  ['multiple' => 'checkbox']);
              ?>
            </div>
          </div>

          <div class="filter-item" data--aos="fade-up" data-aos--duration="700">
            <header class="filter-title">
              <p class="text">
                <?= $this->html->image('/template/css/icons/filter-icon.png',['class'=>'icon']);?>
                کشورها
              </p>
              <?= $this->html->image('/template/css/icons/arrow-down.svg',['class'=>'arrow']);?>
            </header>
            <div class="filter-options">
            <?php $this->Form->setTemplates([
                  'checkbox' => '<input type="checkbox" name="{{name}}" class="form-check-input" value="{{value}}"{{attrs}}>',
                  'nestingLabel' => '<div class="filter-option">
                    <div class="form-check">
                      {{hidden}}{{input}}<label{{attrs}} class="form-check-label"> <span>{{text}}</span></label>
                    </div></div>' ]);
              echo $this->Form->select('country', 
                  ['Iran'=>'ایران',], 
                  ['multiple' => 'checkbox']);
              ?>
            </div>
          </div>

          <?php if(in_array($post_type,['multimedia','knowledge'])):?>
          <div class="filter-item" data--aos="fade-up" data-aos--duration="700">
            <header class="filter-title">
              <p class="text">
                <?= $this->html->image('/template/css/icons/filter-icon.png',['class'=>'icon']);?>
                انتخاب موضوع
              </p>
              <?= $this->html->image('/template/css/icons/arrow-down.svg',['class'=>'arrow']);?>
            </header>
            <div class="filter-options">
            <?php $this->Form->setTemplates([
                  'checkbox' => '<input type="checkbox" name="{{name}}" class="form-check-input" value="{{value}}"{{attrs}}>',
                  'nestingLabel' => '<div class="filter-option">
                    <div class="form-check">
                      {{hidden}}{{input}}<label{{attrs}} class="form-check-label"> <span>{{text}}</span></label>
                    </div></div>' ]);
              echo $this->Form->select('topics', 
                  $this->Query->category("topics",['contain'=>[],'field'=>['id','title'],'limit'=>0, 'find_type'=>'treeList']), 
                  ['multiple' => 'checkbox']);
              ?>
            </div>
          </div>
          <?php endif?>

          <div class="row mt-1">
              <div class="col-sm-6">
                  <button id="submitf" class="btn btn-primary m-t-10 m-1" style="width:100%;">
                      <?=__d( 'template', 'اعمال فیلتر')?>
                  </button>
              </div>
              <div class="col-sm-6">
                  <?= $this->Html->link(
                      __d( 'template', 'حذف فیلتر'),
                      $this->request->getPath(),
                      ['style'=>'width: 100%;','class'=>'btn btn-secondary m-t-10 m-1', 'escape'=>false]);?>
              </div>
          </div>

          <?=$this->Form->end();?>




        </aside>
        <!-- .post-filters-->
      </div>
    </div>
    <!-- .row-->
  </section>
</main>
<?= $this->element('footer');?>
