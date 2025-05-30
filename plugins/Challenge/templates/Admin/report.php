<?php
use Challenge\Predata;
$predata = new Predata();
$eduction = $predata->gettype('eductions');?>
<div>
    <h4>
        <span style="letter-spacing: -0.5px;">لیست گزارش ها</span>
    </h4>
    <div class="clearfix"></div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$challenge_all?></h4>
					<p><?=__d('Template', 'همیاری')?> ثبت شده</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$userform_today?></h4>
					<p> فرم مشارکت ثبت شده امروز</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$userforms_all?></h4>
					<p>فرم مشارکت ثبت شده کل</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$user_userforms_all?></h4>
					<p>تعداد مشارکت کنندکان</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$follower_all?></h4>
					<p> دنبال کنندگان <?=__d('Template', 'همیاری')?> ها </p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$views_all?></h4>
					<p>تعداد بازدید <?=__d('Template', 'همیاری')?> ها</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$user_all?></h4>
					<p>تعداد کل کاربران ثبت نام شده</p>
				</div>
			</div></div>


			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?=$userprofile_all?></h4>
					<p>پروفایل های تکمیل شده</p>
				</div>
			</div></div>
        </div>
    </div>
</div><br><br>

<h4>جنسیت پروفایل </h4>
<div class="card ">
    <div class="card-body">
        <div class="row">
			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?= isset($userprofile_malefemale['m'])?$userprofile_malefemale['m']:''?></h4>
					<p>آقا </p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?= isset($userprofile_malefemale['f'])?$userprofile_malefemale['f']:''?></h4>
					<p>خانم</p>
				</div>
			</div></div>
        </div>
    </div>
</div><br><br>

<h4>مدرک تحصیلی</h4>
<div class="card ">
    <div class="card-body">
        <div class="row">
            <?php if(count($userprofile_eduction)){foreach($userprofile_eduction as $cnt=>$value):?>
			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-light-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0"><?= $value?></h4>
					<p><?= isset($eduction[$cnt])?$eduction[$cnt] :'-';?> </p>
				</div>
			</div></div>
            <?php endforeach;}?>
			
        </div>
    </div>
</div>

