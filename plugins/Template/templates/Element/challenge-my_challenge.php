</div>
<style>.profile-section-header{margin:0}</style>
<div class="posts-list">

	<?php foreach($results as $result):if(isset($result->challenge->title)):?>
	<article class="post-list-item" data-aos="fade-up" data-aos-duration="700">

		<?php if( $result->challenge->img1 != ''):?>
			<figure class="img-wrapper img-hover-effect">
				<a class="d-block">
					<img class="img-fluid" src="<?= $result->challenge->img1?>" alt="<?=$result->challenge->title?>">
				</a>
				<span class="post-status">
					<?= isset($result['challenge']['challengestatus']['title'])?
						$result['challenge']['challengestatus']['title']:'-'?>
				</span>
			</figure>
		<?php endif?>

		<div class="post-content">
			<header>
				<h3 class="title">
					<?= $this->html->link($result->challenge->title,
						'/challenge/'.$result->challenge->slug)?>
				</h3>
			</header>
			<p class="category">
				<?= $this->html->image('/template/css/icons/badge-primary.svg')?>
				<?php 
				if(is_array($result->challenge->challengetopics) and count($result->challenge->challengetopics) > 0):
					foreach($result->challenge->challengetopics as $temp):
						echo '<span>'.$temp->title.'</span>';
					endforeach;
				endif;?>
			</p>
			<div class="time-wrapper has-btn">
				<div class="time">
					<p class="remaining">
						<span class="ms-1">زمان مشارکت شما:</span>
						<b><?= $this->Func->date2($result['created'],'Y-m-d');?></b>
					</p>
					<span class="status">
						<?= (isset($result->challenge->challengestatus->title)?$result->challenge->challengestatus->title:'-');?>

					</span>
				</div>
				<div class="d-flex gap-2">
					<!-- <button class="btn btn-outline-white btn-md btn-just-icon">
						<?= $this->html->image('/template/css/icons/edit-primary-alt.svg')?>
					</button> -->

					<?= $this->html->link('ویرایش محتوا ارسالی',
						'/challenge/'.$result->challenge->slug.'/solution/?edit='.rand(1,100),[
						'class'=>'btn btn-outline-white btn-md pe-2 ps-2',
					])?>
							
				</div>
			</div>
		</div>
		<!-- .post-content-->
	</article>
	<?php endif;endforeach;?>

</div>