<h4>
	<?= isset($challenge->challengeforumtitles[0]['title'])?
	$challenge->title.' » تبادل نظر » '.$challenge->challengeforumtitles[0]['title']:
	''?>
</h4>
<ol class="commentlist border-0 m-0 p-0 clearfix" dir="ltr">
	<?php foreach($challenge->challengeforums as $post):?>
	<li class="comment even thread-even depth-1" id="li-comment-1">
		<div id="comment-1" class="comment-wrap clearfix">
			<div class="comment-meta">
				<div class="comment-author vcard">
					<span class="comment-avatar clearfix">
						<?= $this->html->image('/challenge/image/profile-c.png',['height'=>'60','width'=>'60','alt'=>'']);?>
					</span>
				</div>
			</div>
			<div class="comment-content clearfix">
				<div class="comment-author" style="padding-right: 25px;">
					<!-- <?= $post['user']['family']?> -->
					<span><?= $this->Func->mil_to_shm(date("Y-m-d", strtotime($post['created']->format('Y-m-d'))));?></span>
				</div>
				<p style="font-size:14px;"><?= $post['text']?></p>
				<a class="comment-reply-link"><i class="icon-reply"></i></a>
			</div>
			<div class="clear"></div>
		</div>
	</li>
	<?php endforeach;?><br><br>
</ol>

<div id="respond">
	<h4 class="mb-2">یک <span>پاسخ</span> ارسال کنید </h4>
	<?php
	if( $this->request->getAttribute('identity')->get('id') ):

		if(isset($users['challengeuserprofile']) and $users['challengeuserprofile']['user_id']!= '' ):
			echo '<div class="text-center">';
			echo '<div class="alert alert-warning">
				پروفایل کاربری شما هنوز تکمیل نشده است.<br>
				لطفا ابتدا پروفایلتان را تکمیل کرده و سپس اقدام نمایید</div>';	
			echo $this->html->link('<button class="btn btn-primary btn-sm m-0">تکمیل پروفایل کاربری</button>',
				'/challenge/profile/',['escape'=>false]);
			echo '</div>';
		else:
			echo $this->Form->create($challengeforum);
			?>
			<form class="row" action="#" method="post" id="commentform">
				<div class="form-group">
					<label for="comment">متن پیام</label>
					<textarea name="text" cols="58" rows="7" tabindex="1" class="sm-form-control form-control" required></textarea>
				</div>
				<div class="form-group">
					<button name="submit" type="submit" id="submit-button" tabindex="2" value="ارسال" class="btn btn-primary btn-sm m-0">ارسال</button>
				</div>
			<?= $this->Form->end() ;
		endif;
	else:
		echo '<div class="alert alert-warning text-center">';
		echo $this->html->link('ورود',['plugin'=>false, 'controller'=>'Users','action'=>'login']);
		echo ' / ';
		echo $this->html->link('ثبت نام',['plugin'=>false, 'controller'=>'Users','action'=>'register']);
		echo '</div>';
	endif;
?>
</div>
<style>
	.comment-meta{
		float: right;
		margin-left: 15px;
		margin-bottom: 15px;
	}
</style>