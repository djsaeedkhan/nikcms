<?= $this->element('Template.header');?>
<style>
#header{background: #FFF !important;}
</style>
<section id="content">
	<div class="content-wrap pt-4 pb-4" style="overflow: visible;">
        <div class="container clearfix">
            <div class="row">
                <div class="postcontent col-lg-12 order-lg-last">
                    <?php //include('breadcrumb.php')?>
                    <div class="bk1 p-4 text-justify fs-14">
                        <div class="fancy-title title-border">
                            <h4><?= $result['title']?></h4>
                        </div>
                        <?= $this->Query->the_content();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->element('Template.footer');?>