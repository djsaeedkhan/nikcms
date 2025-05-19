<?php use Shop\View\Helper\ShopHelper;?>
<div class="col-12">
	<div class="card card-statistics">
		<div class="card-header">
			<h4 class="card-title">آمار فروشگاه</h4>
			<div class="d-flex align-items-center">
				<p class="card-text mr-25 mb-0">بروز رسانی: همین لحظه</p>
			</div>
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
							<h4 class="font-weight-bolder mb-0"><?= $product_all?></h4>
							<p class="card-text font-small-4 mb-0">کل محصولات</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
					<div class="media">
						<div class="avatar bg-light-info mr-2">
							<div class="avatar-content">
								<i data-feather="shopping-cart" class="avatar-icon"></i>
							</div>
						</div>
						<div class="media-body my-auto">
							<h4 class="font-weight-bolder mb-0"><?= $order_all?></h4>
							<p class="card-text font-small-4 mb-0">کل سفارشات</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-12 mb-2 mb-sm-0">
					<div class="media">
						<div class="avatar bg-light-danger mr-2">
							<div class="avatar-content">
								<i data-feather="dollar-sign" class="avatar-icon"></i>
							</div>
						</div>
						<div class="media-body my-auto">
							<h4 class="font-weight-bolder mb-0"><?= ShopHelper::PriceShow($price_all)?></h4>
							<p class="card-text font-small-4 mb-0">کل درآمد</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-12">
					<div class="media">
						<div class="avatar bg-light-success mr-2">
							<div class="avatar-content">
								<i data-feather="trello" class="avatar-icon"></i>
							</div>
						</div>
						<div class="media-body my-auto">
							<h4 class="font-weight-bolder mb-0"><?= $view_all?></h4>
							<p class="card-text font-small-4 mb-0">بازدید محصولات</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="col-lg-5 col-md-6 col-12 d-none">
	<div class="card card-employee-task">
		<div class="card-header">
			<h4 class="card-title">سفارش های جدید</h4>
			<i data-feather="more-vertical" class="font-medium-3 cursor-pointer"></i>
		</div>
		<div class="card-body">

			<?php for($i=0;$i<5;$i++):?>
			<div class="employee-task d-flex justify-content-between align-items-center">
				<div class="media">
					<div class="avatar mr-75">
						<?= $this->html->image('/admin/app-assets/images/portrait/small/avatar-s-'.rand(1,5).'.jpg',['class'=>'rounded','width'=>"42", 'height'=>"42"])?>
					</div>
					<div class="media-body my-auto">
						<h6 class="mb-0">رضا محمدیان</h6>
						<small><?=rand(1,10)?> سفارش</small>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<small class="text-muted mr-75">9 ساعت 20 دقیقه</small>
					<div class="employee-task-chart-primary-1"></div>
				</div>
			</div>
			<?php endfor?>

		</div>
	</div>
</div>

<div class="col-lg-4 col-md-6 col-12 d-none">
	<div class="card card-employee-task">
		<div class="card-header">
			<h4 class="card-title">سفارش های تایید شده</h4>
			<i data-feather="more-vertical" class="font-medium-3 cursor-pointer"></i>
		</div>
		<div class="card-body">

			<?php for($i=0;$i<5;$i++):?>
			<div class="employee-task d-flex justify-content-between align-items-center">
				<div class="media">
					<div class="avatar mr-75">
						<?= $this->html->image('/admin/app-assets/images/portrait/small/avatar-s-'.rand(1,5).'.jpg',['class'=>'rounded','width'=>"42", 'height'=>"42"])?>
					</div>
					<div class="media-body my-auto">
						<h6 class="mb-0">علی حسینیان</h6>
						<small><?=rand(1,10)?> سفارش</small>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<small class="text-muted mr-75">9 ساعت 20 دقیقه</small>
					<div class="employee-task-chart-primary-1"></div>
				</div>
			</div>
			<?php endfor?>

		</div>
	</div>
</div>

<div class="col-lg-3 col-md-6 col-12 d-none">
	<div class="card card-employee-task">
		<div class="card-header">
			<h4 class="card-title">آخرین پرداخت ها</h4>
			<i data-feather="more-vertical" class="font-medium-3 cursor-pointer"></i>
		</div>
		<div class="card-body">

			<?php for($i=0;$i<4;$i++):?>
			<div class="employee-task d-flex1 justify-content-between align-items-center">
				<div class="media">
					<div class="avatar mr-75">
						<?= $this->html->image('/admin/app-assets/images/portrait/small/avatar-s-'.rand(1,5).'.jpg',['class'=>'rounded','width'=>"42", 'height'=>"42"])?>
					</div>
					<div class="media-body my-auto">
						<h6 class="mb-0">محمدفرهان سروش</h6>
						<small><?=rand(10,90)?>,000 تومان</small>
					</div>
				</div>
				<div class="d-flex1 align-items-center">
					<small class="text-muted mr-75 text-left">9 ساعت 20 دقیقه</small>
				</div>
			</div>
			<?php endfor?>

		</div>
	</div>
</div>
