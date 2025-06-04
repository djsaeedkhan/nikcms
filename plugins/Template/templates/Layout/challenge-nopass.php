<?php
use Cake\ORM\TableRegistry;
echo $this->element('Template.header');

$solution = ($this->request->getParam('method') == "solution")?true:false;
?>
<main id="main-content">
	<header class="page-header">
	<div class="img-wrapper" style="background-image: url('<?= siteurl?>/temp/page-header.png')"></div>
	<div class="content">
		<h1 class="title"><?= $this->html->link($challenge->title,'/challenge/'.$challenge->slug,['class'=>'text-white']);?></h1>
		<div class="nav-tabs-wrapper">
		<ul class="underline-nav-tabs" id="underline-tab" role="tablist">
			
			<li class="nav-item <?= $solution == false?'active':''?>" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-content" role="tab" data-aos="fade-up" data-aos-duration="700"><img class="ms-2" src="<?= siteurl?>/css/icons/document-text-white.svg" alt="">شرح موضوع</li>

			<li class="nav-item" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents-tab-content" role="tab" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100"><img class="ms-2" src="<?= siteurl?>/css/icons/document-copy-white.svg" alt="">اسناد پشتیبان</li>

			<li class="nav-item" id="timing-tab" data-bs-toggle="tab" data-bs-target="#timing-tab-content" role="tab" data-aos="fade-up" data-aos-duration="700" data-aos-delay="150"><img class="ms-2" src="<?= siteurl?>/css/icons/timer-white.svg" alt="">زمانبندی</li>

			<li class="nav-item" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles-tab-content" role="tab" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200"><img class="ms-2" src="<?= siteurl?>/css/icons/megaphone-white.svg" alt="">اخبارو اطلاعیه ها</li>

			<li class="nav-item" id="map-tab" data-bs-toggle="tab" data-bs-target="#map-tab-content" role="tab" data-aos="fade-up" data-aos-duration="700" data-aos-delay="250"><img class="ms-2" src="<?= siteurl?>/css/icons/map-white.svg" alt="">نقشه مشارکت</li>

			<?php if($solution == true):?>
				<li class="nav-item active" id="solution-tab" data-bs-toggle="tab" data-bs-target="#solution-tab-content" role="tab" data-aos="fade-up" data-aos-duration="700" data-aos-delay="250"><img class="ms-2" src="<?= siteurl?>/css/icons/document-text-white.svg" alt="">ثبت مشارکت</li>
			<?php endif;?>
		</ul>
		</div>
	</div>
	</header>
	<section class="container">
	<div class="row align-items-start g-lg-5 g-4">
		<div class="col-12 col-lg-9">

		<?= $this->Flash->render();?>
		
		<div class="tab-content">

			<?php if($solution == true):?>
			<section class="tab-pane fade show active" id="solution-tab-content" data-aos="fade-up" data-aos-duration="700">
			<div class="white-box page-content-wrapper">
				<header class="white-box-header">
					<h4 class="title">مشارکت</h4>
				</header>

				<?php echo $this->fetch('content');?>
			</div>
			</section>
			<!-- end of description-tab-->
			<?php endif?>

			<section class="tab-pane fade <?= $solution == false?'active':''?>" id="description-tab-content" data-aos="fade-up" data-aos-duration="700">
			<div class="white-box page-content-wrapper">
				<header class="white-box-header">
					<h4 class="title">شرح موضوع</h4>
				</header>

				<div style="text-align: justify;line-height: 33px;">
					<?php if($challenge->challengetexts):foreach($challenge->challengetexts as $text):?>
						<p><?=nl2br($text['title'])?></p>
					<?php endforeach;endif;?>
				</div>
			</div>
			</section>
			<!-- end of description-tab-->


			<section class="tab-pane fade" id="documents-tab-content">
			<div class="white-box">
				<header class="white-box-header">
				<h4 class="title">اسناد پشتیبان</h4>
				</header>
				<div class="backup-documents">

					<?php 
					$posts = \Cake\ORM\TableRegistry::get('Admin.Posts')->find('all')
						->where(['post_type'=>'chresource'])
						->order(['created'=>'desc'])
						->contain(['PostMetas'])
						->join([
							'table' => 'post_metas','alias' => "pm1",'type' => 'LEFT',
							'conditions' => ["pm1.post_id = Posts.id"] ])
						->where([
							"pm1.meta_key"=>'challenge_id', 
							"pm1.meta_value"=> $challenge['id'] ])
						->toarray();
					foreach($posts as $post):$metalist = $this->Func->MetaList($post);?>
					<article class="document">
						<div class="d-flex align-items-center">
							<?php
							if($img = $this->Query->postimage('thumbnail',$post)){
								echo '<figure class="img-wrapper img-hover-effect">'.
									$this->html->image($img, ['alt'=>$post['title'], 'title'=>$post['title'],'class'=>'img-fluid']).
									'</figure>'; 
							}
							?>
							<header>
								<h4 class="title"><?=$post['title']?></h4>
								<div>
									<?=$this->Query->the_mexcerpt($post['content'],100)?>
								</div>
								
								<?php if(isset($metalist['download_link']) and $metalist['download_link']!=''):?>
									<a class="download d-inline-block d-lg-none" href="<?= $metalist['download_link']?>">دانلود فایل</a>
								<?php endif?>
							</header>
						</div>

						<?php if(isset($metalist['download_link']) and $metalist['download_link']!=''):?>
							<a class="download d-none d-lg-inline-block" href="<?= $metalist['download_link']?>">دانلود فایل</a>
						<?php endif?>
					</article>
					<?php endforeach?>
				
				</div>
				<!-- .backup-documents-->
			</div>
			</section>
			<!-- end of documents-tab-->


			<section class="tab-pane fade" id="timing-tab-content">
			<div class="white-box">
				<header class="white-box-header">
				<h4 class="title">زمان بندی</h4>
				</header>
				<div class="timing" style="justify-content: space-evenly;">

					<?php
					$timeline = \Cake\ORM\TableRegistry::get('Challenge.Challenges')->find('all')
					->where(['Challenges.id'=> $challenge['id'] ])
					->contain([
						'Challengetimelines' => function ($q) {
							return $q->order(['dates'=>'asc']);
						},
					])->first();

					if(isset($timeline->challengetimelines) and is_array($timeline->challengetimelines)):
						$temp = array_reverse($timeline->challengetimelines);
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
						
						foreach($timeline->challengetimelines as $tline):
							if($tline->dates != null)
							$time = $this->Func->DiffDate($tline->dates->format('Y-m-d'),'now');
							// + گذشته
							// - نرسیده
						?>
							<div class="item <?=$current == $tline->id?'active':''?>">
								<figure class="img-wrapper"><img src="<?= siteurl?>/css/icons/form-white.svg" alt="icon"></figure>
								<header class="title"><?=$tline['title']?></header>
								<p class="description">
									<?= ($tline->dates != null)?jdate('Y/m/d', strtotime($tline->dates->format('Y-m-d')) ):''?>
								</p>
							</div>
						<?php endforeach;
					
					else:
						echo "متاسفانه اطلاعاتی ثبت نشده است";
					endif;?>
					
				</div>
				<style>
				.timing .item.active .img-wrapper {
					background: #B11F77;
				}
				.timing .item.active .img-wrapper:after {
					background-image: url("<?=siteurl?>/css/images/timing-primary.png");
				}
				</style>
			</div>
			</section>
			<!-- end of timing-tab-->


			<section class="tab-pane fade" id="articles-tab-content">
			<div class="white-box">
				<header class="white-box-header">
				<h4 class="title">اخبار و اطلاعیه ها</h4>
				</header>
				<div class="articles-list">
					<?php
					$news = TableRegistry::get('Admin.Posts')->find('all')
						->where(['post_type'=>'chupdates'])
						->order(['created'=>'desc'])
						->contain(['PostMetas'])
						->join([
							'table' => 'post_metas','alias' => "pm1",'type' => 'LEFT',
							'conditions' => ["pm1.post_id = Posts.id"] ])
						->where([
							"pm1.meta_key"=>'challenge_id', 
							"pm1.meta_value"=> $challenge['id'] ])
						->toarray();
					
					if(is_array($news) and count($news) > 0 ):
						foreach($news as $post):?>
						<article class="article">
							<?php
							if($img = $this->Query->postimage('thumbnail',$post)){
								echo '<figure class="img-wrapper img-hover-effect">'.
									$this->html->image($img, ['alt'=>$post['title'], 'class'=>'img-fluid', 'title'=>$post['title']]).
									'</figure>'; 
							}?>

							<div class="d-flex flex-column justify-content-between">

								<header>
									<h4 class="title"><a href="#">
										<?= $post['title']?>
									</a></h4>
								</header>

								<div>
									<?=$post['content']?>
								</div>

								<footer class="date">
									<img src="<?= siteurl?>/css/icons/calendar.svg" alt="calendar">
									<span><?=$this->Query->the_time($post)?></span>
								</footer>
							</div>
						</article>
					<?php endforeach;
					
					else:
						echo "متاسفانه اطلاعاتی ثبت نشده است";
					endif;?>

				</div>
				<!-- .articles-list-->
			</div>
			</section>
			<!-- end of articles-tab-->
			
			<section class="tab-pane fade" id="map-tab-content">
				<?php echo $this->element('Template.challenge-community')?>
			</section>
			<!-- end of map-tab-->

		</div>
		</div>
		<div class="col-12 col-lg-3 single-details-wrapper">
		<aside class="single-details" data-aos="fade-up" data-aos-duration="700">

			<?php if($challenge->img1 != ''):?>
			<figure class="img-wrapper img-hover-effect">
				<img class="img-fluid" src="<?= $challenge->img1?>" alt="<?= $challenge->title?>">
			</figure>
			<?php endif?>

			<header class="mt-3">
				<h2 class="fw-700 text-16"><?= $challenge->title?></h2>
			</header>

			<div class="items">
			<div class="item"><span class="key">
				<img class="icon" src="<?= siteurl?>/css/icons/calendar.svg" alt="">تاریخ شروع</span>
				<span class="value"><?= $challenge['start_date']?></span></div>

			<div class="item"><span class="key">
				<img class="icon" src="<?= siteurl?>/css/icons/calendar-tick.svg" alt="">تاریخ پایان</span>
				<span class="value"><?=$challenge['end_date']?></span>
			</div>
			
			<?php if($challenge['price'] != ''):?>
			<div class="item"><span class="key">
				<img class="icon" src="<?= siteurl?>/css/icons/gift.svg" alt="">جایزه</span>
				<span class="value"><?=$challenge['price']?></span>
			</div>
			<?php endif?>

			<div class="item"><span class="key">
				<img class="icon" src="<?= siteurl?>/css/icons/text-bordered.svg" alt="">موضوع</span>
				<span class="value">
					<?php 
					if(is_array($challenge->challengetopics) and count($challenge->challengetopics) > 0):
						foreach($challenge->challengetopics as $temp):
							echo '<div>'.$temp->title.'</div>';
						endforeach;
					endif;?>
				</span></div>
			</div>

			<!-- <button class="btn btn-lg btn-primary w-100 mt-4" data-bs-toggle="modal" data-bs-target="#contributeModal">شروع  مشارکت</button>-->
			<?= $this->html->link(
					'<span>مشارکت در '.__d('Template', 'همیاری').'</span><span class="icon icon-arrow-circle-left"></span>',
					'/challenge/'.$challenge->slug.'/solution/',
					['escape'=>false,'class'=>'btn btn-lg btn-primary w-100 mt-4']
				);?>
		</aside>
		</div>
	</div>
	</section>

	<div class="modal fade" id="contributeModal" tabindex="-1">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= $challenge->title?></h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="contribute-modal">
				<h6 class="title">بخش اول سوالات جمع سپاری(اقدامات و راهکارها</h6>
				<div class="help">
					<p class="text">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون</p>
				</div>
				<div class="form-item">
					<label class="form-label">لطفا حداکثر در ده آیتم نظرات خود را در این باره بنویسید</label>
					<textarea class="form-control" name="" rows="4" placeholder="متن خود را تایپ کنید" required></textarea>
				</div>
				<div class="form-item">
					<label class="form-label">لطفا حداکثر در ده آیتم نظرات خود را در این باره بنویسید</label>
					<textarea class="form-control" name="" rows="4" placeholder="متن خود را تایپ کنید" required></textarea>
				</div>
				<div class="help">
					<p class="text">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</p>
				</div>
				<div class="form-item">
					<div class="form-check">
					<input class="form-check-input" id="option1" type="radio" name="options" checked>
					<label class="form-check-label" for="option1">توسعه بازار مباله  با تخصیص به هر کد ملی</label>
					</div>
					<div class="form-check">
					<input class="form-check-input" id="option2" type="radio" name="options">
					<label class="form-check-label" for="option2">افزاش سهم ذخیره سازی گاز طبیعی</label>
					</div>
				</div>
				<div class="help">
					<p class="text">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیستری را برای طراحان رایانه ای و فرهنگ پیشرو در زبان فارسی ایجاد کرد.</p>
				</div>
				<div class="file-input-wrapper">
					<input class="file-input" type="file" multiple>
					<div class="file-input-handler">
					<div class="text"><img src="<?= siteurl?>/css/icons/upload-circle.svg" alt="upload icon"><span>برای انتخاب فایل کلیک کنید</span><span class="pr-text">آپلود فایل</span></div>
					</div>
					<div id="files-preview"></div>
				</div>
				<div class="d-none d-lg-flex justify-content-end">
					<button class="btn btn-lg btn-primary" type="submit">ثبت مشارکت</button>
				</div>
				<div class="d-block d-lg-none">
					<button class="btn btn-lg btn-primary w-100" type="submit">ثبت مشارکت</button>
				</div>
				</form>
				<!-- end of form-->
			</div>
			</div>
		</div>
	</div>
</main>


<?= $this->element('Template.footer')?>