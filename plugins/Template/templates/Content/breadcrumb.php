<section id="page-title" class="page-title-mini mb-3">
    <div class="container clearfix">
        <h1><?= $this->Query->the_category2();?></h1>
        <ol class="breadcrumb" style="left: auto !important;right: 15px !important;font-size: 13px;">
        <?php use Cake\View\Cell;
            /* echo $this->cell('Breadcrumb.View',['split'=> ' ','div'=>'li',[
                'div_class'=>'breadcrumb-item',
                'current'=>'0']]); */?>
        </ol>
    </div>
</section>