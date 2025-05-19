<?php
namespace Challenge;

use Cake\Routing\Router;

class Predata {
	public $data;
	function __construct(){
		$this->data = [
			'eductions'=>[
				3 => 'هئیت علمی',
				2 => 'دکتری',
				5 => 'دانشجوی دکترا',
				4 => 'حوزوی',
				1 => 'کارشناسی ارشد ',
				6 => 'کارشناسی و پایین تر'
			],
			'group'=>defined('challenge_group')?challenge_group:[
				1 => 'دانشجو',//'حقیقی',
				2 => 'حقوقی',
				3 => 'استاد',
				4 => 'کارشناس معاونت فرهنگی و اجتماعی'
			],
			'gender'=>[
				'm' => 'آقا',
				'f' => 'خانم'
			],
			'center'=>[
				1 => 'اندیشکده',
				2 => 'پژوهشکده',
				3 => 'مرکز مطالعاتی',
				4 => 'دانشگاه موسسه',
				5 => 'شرکت',
				6 => 'سایر',
			],
			'chtype'=>[
				1 => 'حقیقی / دانشجو',//'حقیقی',
				2 => 'حقوقی',
				3 => 'استاد'
			],
		];
	}
	function gettype($type = null ) {
		if(isset($this->data[$type])){
			return $this->data[$type];
		}
	}
	function getvalue($type = null , $value = '') {
		if($value != null ){
			if(isset($this->data[$type][$value])){
				return $this->data[$type][$value];
			}
		}
	}
	function createform($value = null, $qlist = null){
		$string = null;
		$text = isset($value['challengequest']['title'])?$value['challengequest']['title']:'-';
		if($value['types'] == 'radio'){
			$string .= '<br><b>'.$text.'</b><br>';
			$string .= isset($qlist[$value['value']])?$qlist[$value['value']] : '-';
			$string .= '</div><br>';
		}
		
		else if($value['types'] == 'textarea'){
			$string .= '<br><b>'.$text.'</b><br>'.
				''.$value['value'].'</div><br>';
		}
		
		else if($value['types'] == 'file'){
			$string .= '<br><b>'. $text .'</b><br>';
			if($value['value'] != '')
				$string .= 'فایل: <a target="_blank" href="'.Router::url('/challenge/'.$value['value']).'">دانلود فایل ضمیمه</a>';
			else
				$string .= 'فایل: <a>آپلود نشده</a>';
			$string .= '</label></div><br>';
		}
	
		elseif($value['types'] == 'check'){
			$string .= '<br><b>'.$text.'</b><br>';
			$temp = explode(',',$value['value']);
			if(is_array($temp)){
				foreach($temp as $tmp)
				$string .= '<span class="badge badge-success">'.(isset($qlist[$tmp])?$qlist[$tmp]:'').'</span> ' ;
			}
			$string .= '</div><br>';
		}
		return $string;
	}
	public function createjsform($challenge_id = null , $data = null){?>
		<script nonce="<?=get_nonce?>">
		function get_data(parent,mclass,predata){ 
			var all_data;
			$.ajax({
				type : 'GET',
				async: false,
				data: 'type=challengequests&ajax=1&parent='+parent+'&challenge_id=<?=$challenge_id?>',
				url : '<?= Router::url()?>' ,
				beforeSend: function(){ $('.'+mclass).html('درحال دریافت اطلاعات');},
				complete: function(){ $('.'+mclass).html('');},
				success : function(data){ all_data = data;},
				error:function (XMLHttpRequest, textStatus, errorThrown){ all_data = false;}
			});
			createform(all_data,mclass,predata);
		}
		function createform(data,cclass,predata){
			if (data === false){
				$('.'+cclass).html('<span class="badge badge-danger">در دریافت اطلاعات خطایی رخ داده است</span>');
				return false;
			}

			var string = '';
			var array = $.map(data, function(value, index) {
				if(value['types'] == 1){
					string += '<div class="input radio"><label><b>'+(value['title'])+'</b></label><br><div class="mquests">';

					var array = $.map(value['children'], function(value1, index1) {
						string += '<label for="fields-'+value1['id']+'" style="margin-left: 15px;">'+
							'<input type="radio" name="radio_'+value['id']+'" value="'+value1['id']+'" id="fields-'+value1['id']+'" nonce="<?=get_nonce?>" onclick="onclicker('+"'"+value1['id']+"'"+','+"'"+'mlist'+value['id']+"'"+')" class="putt form-control1"> '+value1['title']+'</label> ';
					});
					string += '</div></div><div style1="padding-right:20px;" class="mlist'+(value['id'])+'"></div>';
				}
				
				else if(value['types'] == 2){
					/* string += '<br><div class="input textareaa radio"><label><b>'+value['title']+'</b></label><br>'+
						'<textarea name="textarea_'+value['id']+'" class="form-control"></textarea></div>'; */
					string += '<div class="input textareaa radio"><label><b>'+value['title']+'</b></label><br>'+
						'<textarea name="textarea_'+value['id']+'" class="form-control">';
					if(predata != ''){
						if(predata !== undefined){
							if(value['id'] in predata){
								string += predata[value['id']];
							}
						}
					}
					string +='</textarea></div><br>';
				}
				
				else if(value['types'] == 3){
					string += '<br><div class="input filee radio"><label><b>'+(value['title'])+'</b></label><br>'+
					'<label><input type="file" name="file_'+value['id']+'" value="'+value['id']+'" class="form-control"></label></div>';
				}

				else if(value['types'] == 4){
					string += '<br><div class="input select selectt radio">'+
								'<label for="eeee"><b>'+value['title']+'</b></label><br>';
					var array = $.map(value['children'], function(value1, index1) {
						string +=
						'<div class="checkbox">'+
							'<label for="eeee-'+value1['id']+'">'+
								'<input type="checkbox" name="check_'+value['id']+'[]" value="'+value1['id']+'" id="eeee-'+value1['id']+'"> '+value1['title']+
							'</label>'+
						'</div>';
					});
					string += '</div>';
				}
				
				else if(value['types'] == 5){
					string += '<br><h1>'+(value['title'])+'</h1>';
				}
				else if(value['types'] == 6){
					string += '<br><h2>'+(value['title'])+'</h2>';
				}
				else if(value['types'] == 7){
					string += '<br><h3>'+(value['title'])+'</h3>';
				}
				else if(value['types'] == 8){
					string += '<br><p>'+(value['title'])+'</p>';
				}

			});
			$('.'+cclass).html(string);
		}

		function createform1(data,cclass, predata){
			
			if (data === false){
				$('.'+cclass).html('<span class="badge badge-danger">در دریافت اطلاعات خطایی رخ داده است</span>');
				return false;
			}

			var string = '';
			var array = $.map(data, function(value, index) {
				if(value['types'] == 1){
					string += '<div class="input radio"><label><b>'+(value['title'])+'</b></label><br><div class="mquests">';

					var array = $.map(value['children'], function(value1, index1) {
						string += '<label for="fields-'+value1['id']+'" style="margin-left: 15px;">'+
							'<input type="radio" name="radio_'+value['id']+'" value="'+value1['id']+'" id="fields-'+value1['id']+'" nonce="<?=get_nonce?>" onclick="onclicker('+"'"+value1['id']+"'"+','+"'"+'mlist'+value['id']+"'"+')" class="putt form-control1"> '+value1['title']+'</label> ';
					});
					string += '</div></div><div style1="padding-right:20px;" class="mlist'+(value['id'])+'"></div><br>';
				}
				
				else if(value['types'] == 2){
					string += '<div class="input textareaa radio"><label><b>'+value['title']+'</b></label><br>'+
						'<textarea name="textarea_'+value['id']+'" class="form-control">';
					if(predata != ''){
    					if(value['id'] in predata){
    						string += predata[value['id']];
    					}
					}
					string +='</textarea></div><br>';
				}
				
				else if(value['types'] == 3){
					string += '<div class="input filee radio"><label><b>'+(value['title'])+'</b></label><br>'+
					'<label><input type="file" name="file_'+value['id']+'" value="'+value['id']+'" class="form-control"></label></div><br>';
				}

				else if(value['types'] == 4){
					string += '<div class="input select selectt radio">'+
								'<label for="eeee"><b>'+value['title']+'</b></label><br>';
					var array = $.map(value['children'], function(value1, index1) {
						string +=
						'<div class="checkbox">'+
							'<label for="eeee-'+value1['id']+'">'+
								'<input type="checkbox" name="check_'+value['id']+'[]" value="'+value1['id']+'" id="eeee-'+value1['id']+'"> '+value1['title']+
							'</label>'+
						'</div>';
					});
					string += '</div><br>';
				}
				
				else if(value['types'] == 5){
					string += '<h1 class="clh1">'+(value['title'])+'</h1><br>';
				}
				else if(value['types'] == 6){
					string += '<h2 class="clh2">'+(value['title'])+'</h2><br>';
				}
				else if(value['types'] == 7){
					string += '<h3 class="clh3">'+(value['title'])+'</h3><br>';
				}
				else if(value['types'] == 8){
					string += '<p class="clh3">'+(value['title'])+'</p><br>';
				}
			});
			$('.'+cclass).html(string);
		}
		function onclicker(a,b){
        	createform(get_data(a , b));
		}
		get_data("no",'mlist',<?= $data != null ?json_encode($data):'""'?>);
		</script>
		<?php
	}
}