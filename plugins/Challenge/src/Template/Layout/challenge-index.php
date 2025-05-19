<?= $this->element('Template.header')?>

<div class="container clearfix">
	<?= $this->Flash->render() ?>
</div>
<!-- Content
============================================= -->
<section id="content">
	<div class="content-wrap pt-4">
		<div class="container clearfix">
			<div class="row gutter-40 col-mb-80">

				<div class="postcontent col-lg-9">
					<div id="page-menu" class="row no-sticky mb-2 d-none">
						<div id="page-menu-wrap">
							<div class="container"><div class="row">
								<div class="page-menu-row" style="width: 100%;">
									<nav class="page-menu-nav">
										<ul class="page-menu-container">
											<li class="page-menu-item"><a href="#"><div>بر اساس تاریخ <?=__d('Template', 'همیاری')?></div></a></li>
											<li class="page-menu-item"><a href="#"><div>بر اساس میزان مشارکت کنندگان</div></a></li>
										</ul>
									</nav>
									<div id="page-menu-trigger"><i class="icon-reorder"></i></div>
								</div>
							</div></div>
						</div><div class="page-menu-wrap-clone"></div>
					</div>
					<!-- ---------------------------------------------->
					<div class="row boxbg pt-3">
						<?php $i=1; foreach($challenges as $ch):$ch['content'] = $ch['descr'];?>
						<!-- Item <?=$i++?> -->
						<div class="col-lg-4 col-sm-6 mb-4">
							<div class="i-products">
								<div class="products-image">
										<?= $this->html->link(
												$this->html->image($ch['img'],[
													'style'=>($ch['enable'] == 0?'filter: grayscale(100%);':''),
													'alt'=> $ch['title'],'escape'=>false 
												]).
												'<span class="badge">'.(isset($ch->challengetopics[0]['title'])?$ch->challengetopics[0]['title']:'').'</span>'.
												($ch['enable'] == 0?'<span style="left: inherit;right: 5px;"class="badge badge-danger">آرشیو شده</span>':'').
												($ch['challengestatus_id'] == 1?'<span style="left: inherit;right: 5px;"class="badge badge-success">'.$ch['challengestatus']['title'].'</span>':'').
												($ch['challengestatus_id'] != 1?'<span style="left: inherit;right: 5px;"class="badge badge-warning">'.$ch['challengestatus']['title'].'</span>':'')
												,
											'/challenge/'.$ch['slug'],
											['escape'=>false]);?>
								</div>
								<div class="products-desc text-left" dir="rtl">
									<h3 title="نمایش <?=__d('Template', 'همیاری')?>">
										<?= $this->html->link($ch['title'],'/challenge/'.$ch['slug'])?>
									</h3>
									<p style="font-size:13px;" class="text-justify m-0 p-0">
										<?=$this->Query->the_excerpt($ch,65)?>
									</p>
									<!-- <div class="clear"></div> -->
									<?php /*
									if($ch['end_date'] != ''):
										$p = $this->Func->DiffDate($this->Func->shm_to_mil($ch['end_date']),'now');
										if($p < 0):// + گذشته
										// - نرسیده
										?>
										<ul class="skills">
											<li data-percent="<?= (abs($p) / 365 ) *100?>">
												<span class="d-flex justify-content-between w-100">
													<span class="counter">
														<span data-from="0" data-to="<?=abs($p)?>" data-refresh-interval="10" data-speed="1200">
														0</span> روز مانده</span>
												</span>
												<div class="progress"></div>
											</li>
										</ul>
										<?php endif;
									endif;*/?>
									<?php /*<div class="products-hoverlays1">
										<ul class="list-group-flush my-3 mb-0 ltr">
											<!-- <li class="list-group-item pr-0">
												
											</li> -->
											<li class="list-group-item pr-0">
												<div class="float-right">
													<strong> وضعیت </strong>
													<?=isset($ch->challengestatus->title)?$ch->challengestatus->title:'-'?>
												</div>
												<strong>دنبال کنندگان</strong>
												<?=isset($ch->challengefollowers[0]['count'])?$ch->challengefollowers[0]['count']:0;?>
											</li>
										</ul>
									</div> */?>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<?php endforeach?>

					</div>
					<!-- ---------------------------------------------->
				</div>

				<div class="sidebar sticky-sidebar-wrap col-lg-3">
					<div class="sidebar-widgets-wrap">
						<div class="sticky-sidebar">
							<?php 
							echo $this->Form->create(null,['type'=>'get','id'=>'form1']);
							$param = $this->request->getQuery();
							@$this->request->data = $param;
							?>
							<div class="widget widget_links clearfix ">

								<?php
								$this->Form->setTemplates([
									'checkbox' => '<input type="checkbox" class="form-check-input" style="margin-top: 2px;" name="{{name}}" value="{{value}}"{{attrs}}>',
									'nestingLabel' => '{{hidden}}<label{{attrs}} class="form-check-label">{{input}} <span>{{text}}</span></label>',
								]);?>

								<style>
									.toggle-content{
										display: block !important;
									}
									.button.button-3d.button-light:hover, .button.button-reveal.button-light:hover {
										color: #FFF;
									}
								</style>

								

								<!-- <div class="toggle1 boxbg mb-3">
									<div class="toggle-header">
										<div class="toggle-title">حوزه های ماموریتی</div>
									</div>
									<div class="toggle-content pr-3">
										<?= $this->Form->select('fields',$fields, [
											'multiple' => 'checkbox',
											'class' =>'form-control mb-3',
										]);?>
									</div>
								</div> -->
								
								<!-- <div class="toggle1 boxbg mb-3">
									<div class="toggle-header">
										<div class="toggle-title">سطوح <?=__d('Template', 'همیاری')?></div>
									</div>
									<div class="toggle-content pr-3">
										<?= $this->Form->select('cats',$cats, [
											'multiple' => 'checkbox',
											'class' =>'form-control mb-3',
										]);?>
									</div>
								</div> -->

								<div class="toggle1 tglact1 boxbg mb-3">
									<div class="toggle-header">
										<div class="toggle-title1">جستجو در <?=__d('Template', 'همیاری')?></div>
									</div>
									<div class="toggle-content pr-3 pl-3">
										<?= $this->Form->control('title', [
											'label'=>false, 
											'class' =>'form-control mb-3 ml-2',
										]);?>
									</div>
								</div>

								<div class="toggle1 boxbg mb-3">
									<div class="toggle-header">
										<div class="toggle-title">وضعیت <?=__d('Template', 'همیاری')?></div>
									</div>
									<div class="toggle-content pr-3">
										<?= $this->Form->select('status',$status, [
											'multiple' => 'checkbox',
											'class' =>'form-control mb-3',
										]);?>
									</div>
								</div>
											
								<!-- <div class="toggle1 tglact1 boxbg mb-3">
									<div class="toggle-header">
										<div class="toggle-title1">موضوعات</div>
									</div>
									<div class="toggle-content pr-3" style="">
										<?= $this->Form->select('topics',$topics, [
											'multiple' => 'checkbox',
											'class' =>'form-control mb-3',
										]);?>
									</div>
								</div> -->

								

								<!-- <div class="toggle1 boxbg mb-3">
									<div class="toggle-header">
										<div class="toggle-title">
											<?=setting['alltag_title']?>
										</div>
									</div>
									<div class="toggle-content pr-3">
										<div class="tagcloud rtl text-right" dir="rtl">
											<?php 
											if(setting['all_tag'] != ''):
												foreach(array_filter(array_unique(explode(';',setting['all_tag'])))  as $tag)
												echo $this->html->link($tag , '/challenge/?tag='.$tag,['class'=>'button button-border button-rounded button-aqua']);
											endif;
											?>
										</div>
										<div class="clearfix"></div>
									</div>
								</div> -->

								<div class="form-group">
									<button type="submit" class="button button-rounded button-reveal button-small button-green button- float-right text-right ">
										<i class="icon-circle-arrow-right"></i><span>اعمال فیلتر</span>
									</button>
								</div>
								<div class="clearfix"></div>
							</div>
							<?= $this->Form->end();?>
						</div>
					</div>
				</div>
	
				
			</div>
		</div>
	</div><!-- .content-wrap end -->
</section><!-- #content end -->

<style>
.widget_links:not(.widget-li-noicon) li::before {
	content: none;
	padding-left: 5px;
}
.list-group-item {
	padding: 9px 0;
}
.i-products:hover .products-desc {
    margin-top: -10px !important;
    min-height: inherit !important;
}
.badge-success{
	background-color: #28a745 !important;
    color: #FFF !important;
}
.badge-warning {
    color: #FFF !important;
    background-color: #ffc107 !important;
}
</style>
<?= $this->element('Template.footer')?>