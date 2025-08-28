<div class="container"><div class="card">
	<div class="card-header">
		<h3><i class="icon-flag"></i> دسترسی سریع</h3>
	</div>
			
    <div class="card-body"><div class="row">
		<div class="col-sm-6 col-lg-3">
			<?= $this->html->link(
				'لیست '.__d('Template', 'همیاری'),
				['plugin'=>'Challenge','controller'=>'Admin','action'=>'index'],
				['class'=>'btn bg-white btn-outline-primary py-2 btn-lg d-block']
			)?>
		</div>

		<div class="col-sm-6 col-lg-3">
			<?= $this->html->link(
				__d('Template', 'همیاری') . ' جدید',
				['plugin'=>'Challenge','controller'=>'Admin','action'=>'add'],
				['class'=>'btn bg-white btn-outline-secondary py-2 btn-lg d-block']
			)?>
		</div>

		<div class="col-sm-6 col-lg-3">
			<?= $this->html->link(
				'تنظیمات صفحه نخست',
				['plugin'=>'Challenge','controller'=>'themes','action'=>'template'],
				['class'=>'btn bg-white btn-outline-warning py-2 btn-lg d-block']
			)?>
		</div>

		<div class="col-sm-6 col-lg-3">
			<?= $this->html->link(
				'لیست منابع',
				'/admin/posts?post_type=knowledge',
				['class'=>'btn bg-white btn-outline-info py-2 btn-lg d-block']
			)?>
		</div>
	</div></div>
</div></div><br>

<div class="container"><div class="card">
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
</div></div><br>

<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
				آخرین <?=__d('Template', 'همیاری')?> ها
            </h4>
        </div>
        <div class="card-body p-0">
            <ul class="list-group">
            <?php 
			$challenge = \Cake\ORM\tableregistry::getTableLocator()->get('Challenge.Challenges')
    			->find('list',['keyField'=>'id','valueField'=>'title'])
				->order(['id'=>'desc'])
				->limit(6)
				->toarray();
			foreach($challenge as $k => $title):?>
                <li class="list-group-item list-group-item-action justify-content-between align-items-center">
                    <span class="text-muted"><?php //h($this->Query->the_time($temp));?></span> &nbsp;&nbsp;
                    <?= $this->html->link($title,['plugin'=>'Challenge','controller'=>'admin','action'=>'view',$k]);?>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
				آخرین منابع
            </h4>
        </div>
        <div class="card-body p-0">
            <ul class="list-group">
            <?php
			$post = $this->Query->post('knowledge', [
				'order'=>['Posts.id'=>'desc'],
				'limit'=>5, 'find_type'=>'all']);
			foreach($post as $k => $temp):?>
                <li class="list-group-item list-group-item-action justify-content-between align-items-center">
                    <span class="text-muted"><?= h($this->Query->the_time($temp));?></span> &nbsp;&nbsp;
                    <?= $this->Auths->link($temp['title'],['controller'=>'Posts','action'=>'edit',$temp['id'] ]);?>
                    <?= $temp['published'] == 0?'<small class="float-left">'.  __d('Admin', 'پیش نویس').'</small>':'';?>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>