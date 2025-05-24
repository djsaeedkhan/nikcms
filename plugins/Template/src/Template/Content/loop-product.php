<?php use Shop\View\Helper\ShopHelper;?>
<div class="real-product-item rounded-10">
	<div class="real-product-item-image">
		<!-- <div class="badge bg-color2">35%</div> -->
		<a href="<?= $this->Query->the_permalink($result)?>">
			<?php if($img = $this->Query->postimage('medium',$result)){
				echo $this->html->image($img, ['alt'=>$result['title'], 'title'=>$result['title']]);
			}?>
		</a>
	</div>

	<div class="real-product-item-desc">
		<a href="<?= $this->Query->the_permalink($result)?>">
			<h3 class="mb-0 fs-15 text-center">
				<?= $result['title']?>
			</h3>
		</a>

		<div class="fs-12 py-1 text-center" style="min-height: 30px;">
			<?= (ShopHelper::Meta('en_title') != "")?ShopHelper::Meta('en_title'):''?>
		</div>

		<div class="line"></div>

		<div class="real-product-item-features fw-medium font-primary clearfix">

			<?php if(!isset($position)):?>
			<div class="row g-0 fs-12 fw-normal">

				<?php if(ShopHelper::Meta('short_descr') != ''):?>
					<?php foreach($this->Func->newline(ShopHelper::Meta('short_descr')) as $text):if(strlen($text) > 0):?>
						<div class="col-lg-12 p-0 d-flex">
							<p class="mb-0"><i class="icon-caret-left"></i> <?=$text?></p>
						</div>
					<?php endif;endforeach;?>
				<?php endif;?>

				<?php /* for($i=0;$i<5;$i++):?>
				<div class="col-lg-12 p-0 d-flex">
					برند محصول :<span class="color">ایران خودرو</span>
				</div>
				<?php endfor */?>
			</div>
			<br>
			<?php endif?>

			<div class="prices d-flex g-0 pb-3">
				<div class="fs-16 fw-bold">
					<?= ShopHelper::PriceShow(ShopHelper::PriceGet($result['id']))?>
				</div>
				<a href="<?= $this->Query->the_permalink($result)?>" class="button m-0 fs-20">
					<i class="icon-line-shopping-cart"></i>
				</a>

			</div>
		</div>
	</div>
</div>