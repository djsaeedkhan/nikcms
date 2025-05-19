<?php
namespace Mpdfs;
use Cake\Http\Response;
use Cake\Core\Exception\Exception;

class CreatePdf {
	function __construct(){
		require_once __DIR__ . '/../vendor/autoload.php';
	}

	public function show($params = null , $setting = []){
		try {
			$mpdf = new \Mpdf\Mpdf([
				'mode' => isset($setting['mode'])? $setting['mode'] :'utf-8',
				'format' => isset($setting['format'])?$setting['format'] :'A4',
				'orientation' => isset($setting['orientation'])?$setting['orientation'] :'', //L
				'SetFont' =>isset($setting['SetFont'])? $setting['SetFont'] :'iransans',
				'SetDirectionality' =>isset($setting['SetDirectionality'])? $setting['SetDirectionality'] :'rtl',
				
				'margin_left' => isset($setting['margin_left'])? $setting['margin_left'] :null,
				'margin_top' => isset($setting['margin_top'])? $setting['margin_top'] :null,
				'margin_right' => isset($setting['margin_right'])? $setting['margin_right'] :null,
				'margin_bottom' => isset($setting['margin_bottom'])? $setting['margin_bottom'] :null,
			]);

			$mpdf->SetTitle(isset($setting['SetTitle'])?$setting['SetTitle']:'My Title');


			if(isset($setting['SetHeader'])){
				/* $arr = array (
					 'L' => array (
					  'content' => 'Chapter 1',
					  'font-size' => 10,
					  'font-style' => 'B',
					  'font-family' => 'serif',
					  'color'=>'#000000'
					),
					'C' => array (
					  'content' => '',
					  'font-size' => 10,
					  'font-style' => 'B',
					  'font-family' => 'serif',
					  'color'=>'#000000'
					), 
					'R' => array (
					  'content' => 'کد پیگیری: 200 500 50 1500',
					  'font-size' => 13,
					  'font-style' => 'B',
					  //'font-family' => 'tahoma',
					  'color'=>'#000000'
					),
					'line' => 1,
				); */

				$odd = isset($setting['SetHeader']['odd'])?$setting['SetHeader']['odd']:'';
				if(isset($setting['SetHeader']['options'])){
					$mpdf->SetHeader($setting['SetHeader']['options'], $odd); // 'O' for Odd header
				}
				else {
					$mpdf->SetHeader($setting['SetHeader']['text'], $odd);
				}
			}
			$mpdf->SetDirectionality('rtl');

			if(isset($setting['SetFooter'])){
				$mpdf->SetFooter($setting['SetFooter']); // 'O' for Odd header
			}


			if(isset($setting['css_url'])){
				$stylesheet = file_get_contents($setting['css_url']);
				$mpdf->WriteHTML($stylesheet,1);
			}

			if(isset($setting['css_text'])){
				$mpdf->WriteHTML($setting['css_text'],1);
			}
				
			if($params != null){
				foreach($params as $param){
					$mpdf->AddPage();
					$mpdf->WriteHTML($param);
				}
			}

			echo $mpdf->Output(
				(isset($setting['filename'])?$setting['filename']:'filename.pdf'),
				(isset($setting['filedest'])?$setting['filedest']:'D')
			);
		} catch (\Exception $e) {
			echo "Pdf Cannot Build";
		}
		
	}
}


/*
	\Mpdf\Output\Destination::INLINE, or "I"
	send the file inline to the browser. The plug-in is used if available. The name given by $filename is used when one selects the “Save as” option on the link generating the PDF.

	\Mpdf\Output\Destination::DOWNLOAD, or "D"
	send to the browser and force a file download with the name given by $filename.

	\Mpdf\Output\Destination::FILE, or "F"
	save to a local file with the name given by $filename (may include a path).

	\Mpdf\Output\Destination::STRING_RETURN, or "S"
	return the document as a string. $filename is ignored.
*/