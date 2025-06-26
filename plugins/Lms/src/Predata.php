<?php
namespace Lms;
class Predata {
	public $data = [
		'exam_result'=>[
			0 => 'درحال برگزاری آزمون',
			1 => '<span class="badge badge-danger">مردود</span>',
			2 => '<span class="badge badge-success">قبول</span>',
			3 => 'درحال بررسی',
			4 => 'رد شده',
			5 => 'آزمون دوباره'
		],
		'quest_result'=>[
			0 => 'مردود',
			1 => 'قبول',
			2 => 'در حال بررسی',
		],
		'paid'=>[
			0=>'پرداخت نشده',
			1=>'پرداخت شده'
		],
		'discount_type'=>[
			'percent'=>'درصد تخفیف',
			//'fixed_cart'=>'تخفیف ثابت سبدخرید',
			'fixed_product'=>'تخفیف ثابت',
		]
	];
	function gettype($type = null ) {
		if(isset($this->data[$type])){
			return $this->data[$type];
		}
	}
	function getvalue($type = null , $value = '') {
		if("$value" !== null ){
			if(isset($this->data[$type][$value])){
				return $this->data[$type][$value];
			}
		}
	}
}