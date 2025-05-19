<?php $this->assign('shop_title','ثبت مشخصات پایه')?>
<section id="content" dir="rtl">
	<div class="content-wrap pt-4 clearfix">
		<div class="container">
            <?= $this->Form->create(isset($shop_profile)?$shop_profile:null); ?>
                
            <div class="row text-left rtl">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $this->Form->control('name', [
                                'label'=>'نام *','class' => 'form-control','required',
                                'oninput'=>"setCustomValidity('')",
                                'oninvalid'=>"this.setCustomValidity('اجباری')"]); ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $this->Form->control('family', [
                                'label'=>'نام خانوادگی *','class' => 'form-control','required',
                                'oninput'=>"setCustomValidity('')",
                                'oninvalid'=>"this.setCustomValidity('اجباری')"]); ?>
                        </div>
                    </div>
                    <br />
                    <?= $this->Form->control('nationalid', [
                        'label'=>'کدملی *','dir'=>'ltr','class' => 'form-control','required',
                        'oninput'=>"setCustomValidity('')",
                        'oninvalid'=>"this.setCustomValidity('اجباری')"]); ?><br />
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('phone', [
                        'label'=>'شماره تلفن همراه *','dir'=>'ltr','class' => 'form-control','required',
                        'oninput'=>"setCustomValidity('')",
                        'oninvalid'=>"this.setCustomValidity('اجباری')"]); ?><br />
                    <?= $this->Form->control('email', [
                        'label'=>'آدرس ایمیل','dir'=>'ltr','class' => 'form-control']); ?><br />
                </div>

                <!-- <div class="col-sm-4" style="font-size:14px;padding:0;">
                    <div class="alert alert-dark">
                        هنوز اطلاعات پایه شما ثبت نشده است. با ثبت این فرم برای سفارش های بعدی از همین 
                        اطلاعات استفاده خواهد شد.
                    </div>
                    <div class=" alert alert-warning">
                        - برای رفتن به مرحله بعد این اطلاعات را ثبت کنید.<br>
                        - این صفحه برای اولین بار برای شما نمایش داده شده است.<br>
                        - لطفا اطلاعات پیشفرض حسابتان را وارد کنید 
                    </div>
                </div> -->
            </div><br />

            <?= $this->Form->button('ثبت اطلاعات', ['class' => 'btn btn-success btn-sm float-right','style'=>'width: 180px;']);?>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</section>