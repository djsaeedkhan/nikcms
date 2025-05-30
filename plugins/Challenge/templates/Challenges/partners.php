<div class="row text-center mt-3">
	<?php foreach($challenge->challengepartners as $partner):?>
	<div class="col-lg-6 bottommargin-sm">
		<div class="feature-box fbox-border fbox-light fbox-effect">
			<div class="fbox-icon" style="margin: 0 auto;">
				<?= $this->html->link($this->html->image($partner['image']),
					$partner['link'],
					['target'=>'_blank','escape'=>false,'alt'=>$partner['title']]);?>
			</div>
		</div>
		<div class="clearfix"></div><br>
		<h5 class="mb-0"><?= $partner['title']?></h5>
	</div>
	<?php endforeach?>
</div>