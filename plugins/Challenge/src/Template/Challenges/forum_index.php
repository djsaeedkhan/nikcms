<div class="alert alert-primary">
دیدگاه های ارسال شده توسط شما، پس از تایید توسط دبیرخانه منتشر خواهد شد
<br>
تنها پیام هایی که حاوی محتوای نامناسب هستند منتشر نخواهد شد
</div>
<div class="forum-sections-container ">
	<div class="row">
		<div class="col-6 text-capitalize text-left">
			عناوین  تبادل نظر
		</div>
		<div class="col-6 text-capitalize text-right">
			تعداد نظرات
		</div>
	</div>
	<hr>

	<?php foreach($challenge->challengeforumtitles as $title):?>
	<div class="forum-sections" dir="rtl">
		<div class="row">
			<div class="title col-12 col-sm-10 col-md-9 text-left">
				<?= $this->html->link('<span class="forum-section-title" data-section-id="38">'.$title['title'].'</span>',
					'/challenge/'.$challenge->slug.'/'.$page.'?section='.$title['id'],
					//[$challenge['id'],'forum','?'=>['section'=>$title['id']] ],
					['class'=>'forum-thread-link','escape'=>false]);?>

				<div class="description" style="font-size:14px;">
					<?=$title['descr']?>
				</div>
			</div>
			<div class="col-12 col-sm-2 col-md-3 text-center">
				<div class="text-muted total pt-1">
					<span class="badge badge-info si-rounded" style="width:20px;height:20px;font-weight: normal;padding-top:5px;"><?php
					$value = 0;
					foreach($challenge->challengeforums as $frm){
						if($frm['challengeforumtitle_id'] == $title['id'])
						$value = $frm['count'];
					}
					echo $value;
					?></span>
				</div>
			</div>
			
		</div>
		<hr>
	</div>
	<?php endforeach;?>
</div>