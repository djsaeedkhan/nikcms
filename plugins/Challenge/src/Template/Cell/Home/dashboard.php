<div class="container"><div class="card ">
	<div class="card-header">
		<h3><i class="icon-flag"></i> آمار <?=__d('Template', 'همیاری')?> ها</h3>
	</div>
			
    <div class="card-body">
        <div class="row">
			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$challenge_all?></h4>
					<p><?=__d('Template', 'همیاری')?> ثبت شده</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$userform_today?></h4>
					<p> فرم مشارکت ثبت شده امروز</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$userforms_all?></h4>
					<p>فرم مشارکت ثبت شده کل</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$user_userforms_all?></h4>
					<p>تعداد مشارکت کنندکان</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$follower_all?></h4>
					<p> دنبال کنندگان <?=__d('Template', 'همیاری')?> ها </p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$views_all?></h4>
					<p>تعداد بازدید <?=__d('Template', 'همیاری')?> ها</p>
				</div>
			</div></div>

			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$user_all?></h4>
					<p>تعداد کل کاربران ثبت نام شده</p>
				</div>
			</div></div>


			<div class="col-sm-6 col-lg-3"><div class="card text-white bg-primary">
				<div class="card-body pb-0">
					<h4 class="mb-0 text-white"><?=$userprofile_all?></h4>
					<p>پروفایل های تکمیل شده</p>
				</div>
			</div></div>

        </div>

		<div class="text-center">
			<?= $this->html->link('نمایش لیست آمارها','/admin/challenge/admin/report',['class'=>''])?>
		</div>

    </div>
</div></div>