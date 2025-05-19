<?php
namespace Shop;
class Predata {
	public $data = [
		'attribute_list'=>[
			1 => 'رنگ',
			2 => 'تصویر',
		],
		'price_type'=>[
			'gold' => 'طلا',
			//'dollar' => 'دلاری',
		],
		'paramlist_type'=>[
			1 => 'محتوا',
			2 => 'سرتیتر',
		],
		'weight_unit'=>[
			"gr" => 'گرم',
			"kg" => 'کیلو گرم',
		],
		'prd_unit'=>[
			1 => 'جعبه',
			2 => 'بسته',
			3 => 'کارتن',
			4 => 'بطری‌',
			5 => 'پاکت',
			6 => 'قوطی',
			7 => 'سایر',
		],
		'product_type' =>[
			'simple'=> 'محصول ساده',
			'wholesale'=>'عمده فروشی',
			// 'file' => 'فروش مجازی (فایل)',
		],
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