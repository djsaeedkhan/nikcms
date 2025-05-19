<div class="col-12 d-none">
	<div class="card card-statistics">
		<div class="card-header">
			<h4 class="card-title">سامانه آموزش مجازی</h4>
		</div>
		<div class="card-body statistics-body">
			<div class="row">
				<div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
					<div class="media">
						<div class="avatar bg-light-primary mr-2">
							<div class="avatar-content">
								<i data-feather="trending-up" class="avatar-icon"></i>
							</div>
						</div>
						<div class="media-body my-auto">
							<h4 class="font-weight-bolder mb-0"><?=count($lmsCourses)?></h4>
							<p class="card-text font-small-4 mb-0">دوره های من</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-12">
	<h2 class="content-header-title float-right mb-0">
		لیست دوره های من
	</h2><br><br>
</div>

<div class="">
	<div class="row">
	<?php foreach ($lmsCourses as $lmsCourse):$lmsCourse = $lmsCourse['LmsCourses'];?>
		<div class="col-sm-12"><div class="card">
			<div class="card-body" style="min-height: 140px;">
				<div class="row">
					
					<div class="col-sm-4 p-md-0">
						<?php
						if($lmsCourse['image'] !=''){
							try {
								$img = explode('/',$lmsCourse['image']);
								$img = $img[count($img) - 1];
								echo $this->html->image(
									'/users/thumbnail/'.$img.'/400/400',
									['class'=>'','style'=>'width:100%;']);
							} catch (\Throwable $th) {
								echo $this->html->image($lmsCourse['image'],
								['class'=>'','style'=>'width:100%;']);
							}
						}?>
					</div>
					<div class="col-sm-8">
						<h5 class="text-justify" style="font-size: 15px;letter-spacing: -0.5px;line-height:23px;">
							دوره: <?= h($lmsCourse['title']) ?></h5>
						
						<p class="text-justify d-none">
							<?= $lmsCourse['text']?>
						</p>
						<?= $this->Html->link(__('مشاهده'), '/lms//client/course/'.$lmsCourse['id'],
							['class'=>'float-left btn btn-sm btn-success'] ) ?>
						<!-- <?= $this->Html->link(__('مشاهده'), '/lms/client/courses/'.$lmsCourse['id'],
							['class'=>'float-left btn btn-sm btn-success'] ) ?> -->
					
					</div>
				</div>
				
			</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>