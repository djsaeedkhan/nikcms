<?php
namespace Challenge;
use Cake\Routing\Router;
class Chpdf {
	public function get($id=1){
		$page[1] = '<br><br><br>
			<p class="text-center">
				<img src="'.Router::url('/challenge/logo/msrt_vezarat.png').'">
			</p>
			<h1 class="text-center">
				گزارش '.__d('Template', 'همیاری').' شما در سامانه
			</h1>
			<h1 class="text-center">
			'.__d('Template', 'همیاری').' دانشگاهیان در فرهنگ
			</h1><br><br>
			<div style="border:1px solid #000;border-radius:10px;padding:10px;margin:0 100px">
				<img src="'.Router::url('/challenge/image/image002.png').'" style="float:left;height:90px">
				<span style="font-size:16px">کد رهگیری</span>
				<div class="code" style="font-size:20px;">
					<span>{t4}</span> 
					<span>{t3}</span> 
					<span>{t2}</span> 
					<span>{t1}</span>
				</div> 
			</div>
			<br><br>
			<p>
				نام و نام خانوادگی مشارکت‌کننده: {famil}<br>
				نام کاربری در سامانه: {username}<br>
				تاریخ ثبت نظرات: {created}<br>
				عنوان '.__d('Template', 'همیاری').': {challenge_name}<br>
			</p>
			<br><br>
			<p class="text-center">
				<img src="'.Router::url('/challenge/logo/logo2.jpg').'">
			</p>
			<style>
			h1,h2,div,p,table{font-family:iransans !important;font-size:23px;direction:rtl}
			p{font-size:14px;}
			h2{font-size:17px;font-weight:800;}
			div{font-family:iransans;}
			div.code span{border:1px solid #000;padding:10px;border-radius:10px;}
			.text-center{text-align:center;}
			.text-justify{text-align:justify;}
			.text-right{text-align:right;}
			</style>';

		$page[2] ='<div class="text-center" style="font-size:20px">
				باسمه تعالی
			</div>
			
			<p class="text-justify">
			اندیشمند گرامی<br>
			با سلام<br>
			ضمن تشکر از مشارکت جنابعالی در '.__d('Template', 'همیاری').' - و انعکاس نظرات و پیشنهادات ارزشمندتان پیرامون موضوعات مدنظر، خلاصه نظرات دریافت شده از جنابعالی در این مرحله از '.__d('Template', 'همیاری').' در ادامه آورده شده است و پس از مراحل بررسی و ارزیابی آن‌ها توسط متولیان ذی‌ربط مورد بهره‌برداری قرار خواهد گرفت.
			</p>
			
			<br>
			<div class="text-center" style="font-size:20px;font-weight:bold">
				دیدگاه‌های ثبت‌شده
			</div>
			
			<h2>عنوان '.__d('Template', 'همیاری').':</h2>
			
			<p class="text-justify">{challenge_name}</p><br>
			
			{descr}
			';

		/* $page[3] ='<h1>مشارکت در فاز دوم</h1>
			<h2 class="text-justify">
			با در نظر گرفتن سیاست‌های کلان ابلاغ‌شده در بیانیه گام دوم، سایر اسناد مربوطه و همچنین ایده‌های تحولی مطرح‌شده توسط خودتان؛ بندهای سیاستی پیشنهادیتان - در محدوده سیاست‌های کلی برنامه هفتم- را در عرصه عنوان‌شده در این '.__d('Template', 'همیاری').' در این بخش بیان دارید:
			</h2>
			<p class="text-justify">{descr4}</p>
			'; */
		$page[4] ='<br><h2>پیوست ها</h2>
			<table style="border:1px solid #CCC;width:100%;font-size:15px;text-align:center" border="1">
				<tr>
					<td style="width:20px;">ردیف</td>
					<td>نام فایل</td>
					<td>آدرس فایل</td>
				</tr>
				<tr>
					<td>1</td>
					<td>{filesrc1}</td>
					<td></td>
				</tr>
				<tr>
					<td>2</td>
					<td>{filesrc2}</td>
					<td></td>
				</tr>
				<tr>
					<td>3</td>
					<td>{filesrc3}</td>
					<td></td>
				</tr>
			</table>';
		return $page[$id];
	}
}