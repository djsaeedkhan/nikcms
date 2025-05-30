<?php foreach($posts as $post)://$metalist = $this->Func->MetaList($post);?>
<div class="entry col-12 mb-3">
	<div class="grid-inner row align-items-center no-gutters">
		<div class="entry-title title-sm">
			<h3><?=$post['title']?></h3>
			<div class="clearfix"></div>
		</div>
		<?php
		$col = 12;
		if($img = $this->Query->postimage('thumbnail',$post)){
			echo '<div class="entry-image col-md-3 pl-3">'.
				$this->html->image($img, ['alt'=>$post['title'], 'title'=>$post['title']]).
				'</div>'; 
			$col = 9;
		}?>
		<div class="col-md-<?=$col?>">
			<div class="entry-content mt-3 text-justify" style="font-size:14px;">
				<p><?=$post['content']?></p>
				<!-- <a href="#" class="more-link">Read More</a> -->
			</div>
			<div class="entry-meta d-none">
				<ul>
					<li class="m-0"><i class="icon-calendar3"></i> <?=$this->Query->the_time($post)?></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php endforeach?>