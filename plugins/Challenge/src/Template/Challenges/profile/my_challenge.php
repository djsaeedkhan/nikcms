<?php
try{
	echo $this->element('Template.challenge-my_challenge');
}
catch (\Exception $e){?>
	<section id="content">
		<div class="content-wrap pt-1">
			<div class="container clearfix">
				<!-- Posts
				============================================= -->
				<div id="posts" class="tourlist post-grid row grid-container gutter-50 clearfix" data-layout="fitRows">
					<?php foreach($results as $result):?>
					<div class="entry col-12 mb-0 pb-0">
						<div class="grid-inner row no-gutters">
							
							<div class="col-md-12 pl-md-4">
								<div class="entry-title title-sm">
									<h2>
										<?= $result['title'] !=''?'عنوان راهکار: '.$result['title']:''?>
									</h2>
								</div>
								
								<!-- <div class="entry-content mt-2">
									کد رهگیری مشارکت: 
									<span style="font-family:sans-serif">
										<?= (isset($result->token1) and $result->token1)!=''?str_replace('.','&nbsp',$result->token1):'-'?>
									</span>
								</div> -->
								
								<div class="entry-content mt-2 mb-2">
									عنوان <?=__d('Template', 'همیاری')?>: <?= $this->html->link($result->challenge->title,
										'/challenge/'.$result->challenge->slug)?>

									<?= $result->challenge->challengestatus_id != 1?'<span class="badge badge-warning">'.(isset($result->challenge->challengestatus->title)?$result->challenge->challengestatus->title:'-').'</span>':null;?>
								</div>
								
								
								<?php /* $this->Form->postlink('حذف','/challenge/'.$result->challenge->slug.'/solution/delete',[
									'class'=>'btn btn-sm btn-danger float-right ml-1 mr-1',
									'confirm'=>'فقط در صورتی که مهلت شرکت پایان نیافته باشد امکان حذف مشارکت وجود خواهد داشت']) */?>

								<!-- <?php $this->Form->postlink('خروجی Word','/challenge/profile/challenge/'.$result->id.'?getword=true',[
									'class'=>'btn btn-sm btn-success float-right ml-1 mr-1',])?> -->

								<!-- <?= $this->Form->postlink('گواهی مشارکت','/challenge/profile/challenge/'.$result->id.'?getpdf=true',[
									'class'=>'btn btn-sm btn-success float-right ml-1 mr-1',])?> -->

								<?= $this->html->link('ویرایش محتوا ارسالی','/challenge/'.$result->challenge->slug.'/solution/?edit='.rand(1,100),[
									'class'=>'btn btn-sm btn-primary float-right',
									//'confirm'=>'فقط در صورتی که مهلت شرکت پایان نیافته باشد امکان ویرایش مشارکت وجود خواهد داشت'
									])?>
							</div>
						</div>
					</div>
					<?php endforeach;?>
				</div><!-- #posts end -->
			</div>
		</div>
	</section><!-- #content end -->

	<style>
		#posts .entry .btn-sm {
			opacity: 0.4;
		}
		#posts .entry:hover .btn-sm {
			opacity: 1;
		}
	</style>
<?php }?>
