
<div id="posts" class="post-timeline" dir="ltr">
	<?php 
	$temp = array_reverse($challenge->challengetimelines);
	$current = 0;
	$en = 1;
	foreach($temp as $tline):
		if($tline->dates != null):
			$time = $this->Func->DiffDate($tline->dates->format('Y-m-d'),'now');
			if($en == 1 and $time >= 0 ){
				$en = 0;
				$current = $tline->id;
			}
		endif;
	endforeach;
	
	foreach($challenge->challengetimelines as $tline):
		if($tline->dates != null)
		$time = $this->Func->DiffDate($tline->dates->format('Y-m-d'),'now');
		// + گذشته
		// - نرسیده
	?>
	<div class="entry <?=$current == $tline->id?'active':''?>" style="padding:10px !important;margin-bottom:20px;">
		<div class="entry-timeline">
			<?php //$tline['dates']?>
			<div class="timeline-divider"></div>
		</div>
		<div class="entry-title">
			<h3 class="text-left"><?=$tline['title']?></h3>
		</div>
		<div class="entry-meta text-left" style="direction: rtl;">
			<ul>
				<li><i class="icon-calendar3"></i> 
					<?php
					if($tline->dates != null)
						echo jdate('Y/m/d', strtotime($tline->dates->format('Y-m-d')) )?>
				</a></li>
			</ul>
		</div>
	</div>
	<?php endforeach?>
</div>
								
<style>
@media (min-width: 992px){
	.postcontent .post-timeline::before {
		right: -68px;
		margin-right: 0;
		left: inherit;
		border-right: 1px dashed #CCC;
	}
	.postcontent .post-timeline {
		padding-right: 0;
		margin-right: 100px !important;
		margin-left: 0 !important;
		overflow: visible;
	}
	.postcontent .post-timeline .entry-timeline {
		right: -100px;
		left: auto;
	}
}
.post-timeline .entry-meta:not(.no-separator) li::after {
    content: '\205E';
    width: 5px;
    text-align: center;
    display: inline-block;
    margin-right: 15px;
    opacity: 0.5;
}
.post-timeline .entry-meta li {
    margin: 0 0 10px 15px;
}
.post-timeline .entry-meta:not(.no-separator) li::before {
    content: none; 
}
.post-timeline .entry{
	border: 1px dashed #cfcfcf;
	border-radius: 10px;
}
.post-timeline .entry.active{
	border: 1px dashed #4186f7 !important;
	border-radius: 10px;
	background-color:#4186f7;
}
.entry.active h3, .entry.active .entry-meta li{
	color:#FFF;
}
.entry.active .entry-timeline .timeline-divider{
	border-top: 1px dashed #4186f7 !important;
}
.post-timeline .entry-title h2, 
.post-timeline .entry-title h3, 
.post-timeline .entry-title h4{
	font-size:16px;
}
@media (min-width: 992px){
	.post-timeline .entry:hover , 
	.post-timeline .entry:hover .entry-timeline, 
	.post-timeline .entry:hover .timeline-divider {
		border-color: #4186f7;
		color: #4186f7;
	}
	.postcontent .post-timeline .entry-timeline {
		border: 0;
		background-color: transparent;
	}
	.postcontent .post-timeline .entry-timeline div.timeline-divider {
		top: 29px;
		right: 30px;
		width: 70px;
		left: inherit;
	}
}
</style>