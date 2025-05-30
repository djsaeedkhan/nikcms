<style>
@media (min-width: 768px){
	.grid-filter {
		border: 0;
	}
	.grid-filter li a {
		border-left: 0;
		border-radius: 0;
	}
}
.grid-filter li.activeFilter a {
    color: #FFF;
	background-color: #343a40;
	border-radius: 3px;
}
.portfolio-item:hover{
	z-index: 9;
}
.portfolio1 .ui-state-active img{
	filter: brightness(0) invert(1);
}
.portfolio1 tab-nav.tab-nav2 li a {
    border-radius: 4px !important;
}
.portfolio1s .tab-nav.tab-nav2 li{
	width: 24%;
	margin-bottom: 10px;
    margin-left: 10px;
}
.header-misc{color:#FFF;}
</style>

<div class="section portfolio1s m-0" style="background: linear-gradient(#00a7d1, #00a7d1) center center no-repeat; background-size: cover; padding: 40px 0 0px">
	<div class="container">
		<div class="tabs clearfix" id="tab-3">
			<ul class="tab-nav tab-nav2 clearfix">
				<?php for($i=1;$i<10;$i++):if(setting['box2__title'.$i] != ''): ?>
					<li>
						<a href="#tabs-<?=$i?>">
							<?= $this->html->image(setting['box2__img'.$i],[
								'style'=>'width: 20px;height: 20px;'])?>
							<?=setting['box2__title'.$i]?>
						</a>
					</li>
				<?php endif;endfor?>
			</ul>

			<div class="tab-container boxbg2" style="margin-top: 30px;">
				<?php for($i=1; $i<10; $i++):if(setting['box2__title'.$i] != ''):?>
				<div class="tab-content clearfix " id="tabs-<?=$i?>">
					
					<div class="portfolio1 row grid-container1 gutter-201">
					<?php foreach(explode(';',setting['box2__ids'.$i]) as $ids):?>
					
						<?php foreach($chlist as $ch):if($ch['id'] == $ids):$ch['content'] = $ch['descr'];?>
						<article class="portfolio-item1 col-lg-4 col-md-4 col-sm-6 col-12">
							<div class="grid-inner">
								<div class="">
									<div class="i-products">
										<div class="products-image">
											<?= $this->html->link(
													$this->html->image($ch['img'],[
														'style'=>($ch['enable'] == 0?'filter: grayscale(100%);':''),
														'alt'=> $ch['title'],'escape'=>false 
													]).
													'<span class="badge">'.(isset($ch->challengetopics[0]['title'])?$ch->challengetopics[0]['title']:'').'</span>'.
													($ch['enable'] == 0?'<span style="left: inherit;right: 5px;"class="badge badge-danger">آرشیو شده</span>':'').
													($ch['challengestatus_id'] == 1?'<span style="left: inherit;right: 5px;"class="badge badge-success">'.$ch['challengestatus']['title'].'</span>':'').
													($ch['challengestatus_id'] != 1?'<span style="left: inherit;right: 5px;"class="badge badge-warning">'.$ch['challengestatus']['title'].'</span>':'')
													,
												'/challenge/'.$ch['slug'],
												['escape'=>false]);?>
										</div>
										<div class="products-desc text-left" dir="rtl">
											<h3>
												<?= $this->html->link($ch['title'],'/challenge/'.$ch['slug'])?>
											</h3>
											<p style="font-size:13px;" class="text-justify m-0 p-0">
												<?=$this->Query->the_excerpt($ch,65)?>
											</p>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
							</div>
						</article>
						<?php endif;endforeach?>
					<?php endforeach?>
					</div>
				</div>
				<?php endif;endfor;?>
				<br><br><br>
			</div>

			<a href="<?=setting['box2__morelink']?>" class="button center text-right bottommargin-lg float-right" style="margin-top: -50px;">
				<i class="icon-caret-left" style="top:4px;"></i> <?= setting['box2__moretext']?>
			</a>
		</div>
	</div>
</div>


<!-- 
<div class="negetive-margin ltr" dir="ltr" style="direction: ltr;">
	<div class="container ltr boxbg2" dir="ltr"></div>
</div> -->
<style>
.i-products:hover .products-desc {
    margin-top: -10px !important;
    min-height: inherit !important;
}
.badge-success{
	background-color: #28a745 !important;
    color: #FFF !important;
}
.badge-warning {
    color: #FFF !important;
    background-color: #ffc107 !important;
}
</style>