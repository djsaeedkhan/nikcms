<?= $this->element('header');
$metalist = $this->Func->MetaList($result);
$bk_result = $result;?>
<main id="main-content">

  <header class="page-header">
    <div class="img-wrapper" style="background-image: url('<?=siteurl?>/temp/page-header.png')"></div>
    <div class="content">
      <h1 class="title"><?= $this->Query->the_title()?></h1>
    </div>
  </header>

  <section class="container">
    <div class="row align-items-start">
      <div class="col-12 col-lg-9">
        <section>
          <div class="white-box page-content-wrapper">
            <header class="white-box-header">
              <h4 class="title"><?= $this->Query->the_title()?></h4>
            </header>
            <?= $this->Query->the_content()?>
        </section>
        <!-- end of description-tab-->
      </div>

      <?php include_once('sidebar.php')?>
      
    </div>
  </section>

</main>
<?= $this->element('footer');?>