<div class="row">
	<div class="col-6">
	<?php
		echo $this->Form->control('gender',[
			'type'=>'select',
			'options' =>$gender,
			'label'=>'جنسیت'.' <span class="badge badge-danger pb-0">*</span>',
			'escape'=>false,
			'empty' =>'-- انتخاب کنید --',
			'class'=>'form-control']);
		
		echo $this->Form->control('codemeli',[
			'type'=>'text',
			'dir'=>'ltr',
			'label'=>'کدملی',
			'class'=>'form-control ltr']);
		
		echo $this->Form->control('provice',[
			'type'=>'select',
			'options' => $this->Func->province_list(),
			'label'=>'استان محل زندگی '.' <span class="badge badge-danger pb-0">*</span>',
			'escape'=>false,
			'required',
			'empty' =>'-- انتخاب کنید --',
			'class'=>'form-control']);
			
		echo $this->Form->control('birth_date',[
			'label'=>'سال تولد',
			'type'=>isset($list)?'select':'text',
			'empty' =>'-- انتخاب کنید --',
			'dir'=>'ltr',
			'options'=>isset($list)?$list:false ,
			'class'=>'form-control ltr']);

		echo $this->Form->control('eductions',[
			'type'=>'select',
			'required',
			'options'=>$eductions,
			'empty' =>'-- انتخاب کنید --',
			'label'=>'آخرین مقطع تحصیلی'.' <span class="badge badge-danger pb-0">*</span>',
			'escape'=>false,
			'class'=>'form-control']);
		
		echo $this->Form->control('field',[
			'label'=>'رشته تحصیلی',
			'class'=>'form-control']);
		
		echo $this->Form->control('univercity',[
			'label'=>'دانشگاه محل تحصیل',
			'class'=>'form-control']);

		echo $this->Form->control('descr',[
			'label'=>'توصیف کلی پیرامون موقعیت شغلی خود',
			'type'=>'textarea',
			'class'=>'form-control']);
		?>
	</div>
	<div class="col-6">
		<?php
		/* echo $this->Form->control('single',[
			'type'=>'select','id'=>'type',
			'options'=> $group,
			'label'=>'نوع مشارکت',
			'class'=>'form-control']); */
		
		echo '<div id="row_dim">';
			echo $this->Form->control('center',[
				'type'=>'select',
				'options'=> $center,
				'label'=>'نوع مرکز',
				'class'=>'form-control']);
		
			echo $this->Form->control('center_name',[
				'type'=>'text',
				'label'=>'نام مرکز',
				'class'=>'form-control']);
		
			echo $this->Form->control('semat',[
				'type'=>'text',
				'label'=>'سمت ',
				'class'=>'form-control']);
		echo '</div>';

		echo '<hr>';

		echo $this->Form->control('email',[
			'type'=>'email',
			'aria-invalid'=>true,
			'id'=>'template-contactform-email',
			'dir'=>'ltr',
			'escape'=>false,
			'placeholder'=>'...@...',
			'label'=>'پست الکترونیکی (دریافت آخرین اطلاعات بصورت ایمیل)'.' <span class="badge badge-danger pb-0">*</span>',
			'class'=>'form-control ltr']);
		
		echo $this->Form->control('mobile',[
			'type'=>'text',
			'required',
			'dir'=>'ltr',
			'placeholder'=>'09...',
			'label'=>'شماره موبایل (دریافت آخرین اطلاعات بصورت پیامکی)'.' <span class="badge badge-danger pb-0">*</span>',
			'escape'=>false,
			'class'=>'form-control ltr']);
		
		echo '<hr>';
		
		if(isset($challengetopics)):
		echo $this->Form->control('challengetopics._ids', [
			'options' => $challengetopics,
			'label'=>'حوزه تخصصی ',
			'id'=>'template-contactform-tags-select',
			'style'=>'width: 100%;',
			'class'=>'select-tags input-select2 form-control', ]);
		endif;

		echo '<hr>';
		echo $this->Form->control('file', [
			'type'=>'file',
			"id"=>'FilUploader',
			'label'=>'تصویر پروفایل کاربری',
			'class'=>'form-control mb-2 ltr']);
		?>
	</div>
</div>