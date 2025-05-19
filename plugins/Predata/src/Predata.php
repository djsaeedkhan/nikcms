<?php
namespace Predata;

use Cake\ORM\TableRegistry;

class Predata {

	public $data = [
		'register_type'=>[
			'default' =>'نام کاربری ', 
			'codemeli' =>'کدملی',
			'mobile'=>'شماره موبایل'
		],
	];
	/* public $datas = [
		'register_type'=>[
			'default' =>__d('Predata', 'نام کاربری'), 
			'codemeli' =>__d('Predata', 'کدملی'),
			'mobile'=>__d('Predata', 'نام کاربری (شماره موبایل)')
		],
	]; */
	function gettype($type = null ) {
		if(isset($this->data[$type])){
			return $this->data[$type];
		}
	}
	function getvalue($type = null , $value = '') {
		if ($value != null) {
			if (isset($this->data[$type][$value])) {
				return $this->data[$type][$value];
			}
		}
	}
	
	function province_list($id = null){
        $tag = $id;
        if(! is_numeric ($id))
            $id = null;

		$arr = TableRegistry::get('Template.TmpProvinces')
			->find('list',['keyField'=>'province','valueField'=>'pid'])
			//->group('TmpProvinces.province')
			->order(['pid'=>'asc'])
			->toarray();

		if($id == null){
			if($tag == 'by_name'){
				$prov = [];
				foreach($arr as $prof)
					$prov[$prof] = $prof;
				return $prov;
			}
			else
				return $arr;
		}
		else
			return isset($arr[$id])?$arr[$id]:'-';
	}
}