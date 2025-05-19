<?php
namespace Challenge;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Mpdfs\CreatePdf;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class Export {
	//--------------------------------------------------------------------------------
	public function getpdf($id = null,$auth = null, $download = 1){
		$form = TableRegistry::get('Challenge.Challengeuserforms')->get($id);
		
		$answ = TableRegistry::get('Challenge.Challengeqanswers')->find('all')
			->where(['Challengeqanswers.user_id'=>$auth['id'],'Challengeqanswers.challenge_id'=>$form->challenge_id])
			->contain(['Challengequests'])
			->order(['Challengeqanswers.id'=>'asc'])
			->toarray();
		
			
		$challenge = TableRegistry::get('Challenge.Challenges')->get($form->challenge_id);
		$token = $form->token1 != ''?explode('.',$form->token1):[];
		$rep = [
			'{t1}' => isset($token[0])?$token[0]:'-',
			'{t2}' => isset($token[1])?$token[1]:'-',
			'{t3}' => isset($token[2])?$token[2]:'-',
			'{t4}' => isset($token[3])?$token[3]:'-',

			'{famil}' => isset($auth['family'])?$auth['family']:'-',
			'{username}' => isset($auth['username'])?$auth['username']:'-',
			'{created}' => $form->created,
			'{challenge_name}' => $challenge->title,

			'{descr}' => $this->compileform($answ),
			'{filesrc1}'=>$form->filesrc,
			'{filesrc2}'=>$form->filesrc2,
			'{filesrc3}'=>$form->filesrc3,
		];

		$page = new Chpdf();
		$page1 = $page->get(1);
		$page2 = $page->get(2);
		$page4 = $page->get(4);
		$code = '{t1}.{t2}.{t3}.{t4}';
		foreach($rep as $k=>$v){
			$page1 = str_replace($k,nl2br($v),$page1);
			$page2 = str_replace($k,nl2br($v),$page2);
			/* $page3 = str_replace($k,nl2br($v),$page3); */
			$page4 = str_replace($k,nl2br($v),$page4);
			$code = str_replace($k,nl2br($v),$code);
		}

		foreach(['{t1}','{t2}','{t3}','{t4}',
			'{famil}','{username}','{created}','{challenge_name}',
			'{descr}',
			'{filesrc1}','{filesrc2}','{filesrc3}',
		] as $v){
			$page1 = str_replace($v,'',$page1 );
			$page2 = str_replace($v,'',$page2 );
			/* $page3 = str_replace($v,'',$page3 ); */
			$page4 = str_replace($v,'',$page4 );
		}
		// Save as a new file
		if (!file_exists('challenge/export/pdf/')) {
			mkdir('challenge/export/pdf/', 0777, true);
		}
		
		$url = 'ch'.$challenge->id.'_'.(isset($auth['id'])?$auth['id']:'-'.rand(0,999999999).'-').'_'.'file.pdf';
		
		$pdf = new CreatePdf;

		if($download == 1){
			$pdf->show([$page1,$page2,$page4 ],
			[
				'filename'=> 'challenge/export/pdf/'. $url ,
				'filedest'=>'D',
				'SetTitle' =>'گزارش '.__d('Template', 'همیاری').' شما در سامانه',
				'SetFooter'=>'صفحه {PAGENO}',
				'SetHeader'=>['text'=>'کدپیگیری : '.$code ],
			]);
		}

		$pdf->show([$page1,$page2,$page4],
		[
			'filename'=>  'challenge/export/pdf/'. $url ,
			'filedest'=>'F',
			'SetTitle' =>'گزارش '.__d('Template', 'همیاری').' شما در سامانه',
			'SetFooter'=>'صفحه {PAGENO}',
			'SetHeader'=>['text'=>'کدپیگیری : '.$code ],
		]);
		return 1;
	}
	//--------------------------------------------------------------------------------
	public function getword($id = null,$auth = null){
		$form = TableRegistry::get('Challenge.Challengeuserforms')->get($id);
		$challenge = TableRegistry::get('Challenge.Challenges')->get($form->challenge_id);

		$zip = new clsTbsZip();

		$zip->Open('mydoc.docx');
		$content = $zip->FileRead('word/document.xml');
		$p = strpos($content, '</w:body>');
		if ($p === false) exit("Tag </w:body> not found in document.");
		$token = $form->token1 != ''?explode('.',$form->token1):[];
		$rep = [
			'{t1}' => isset($token[0])?$token[0]:'-',
			'{t2}' => isset($token[1])?$token[1]:'-',
			'{t3}' => isset($token[2])?$token[2]:'-',
			'{t4}' => isset($token[3])?$token[3]:'-',

			'{famil}' => isset($auth['family'])?$auth['family']:'-',
			'{username}' => isset($auth['username'])?$auth['username']:'-',
			'{created}' => $form->created,
			'{challenge_name}' => $challenge->title,

			'{descr1}'=> $this->clean($form->descr1),
			'{descr2}'=> $this->clean($form->descr2),
			'{descr3}'=> $this->clean($form->descr3),
			'{descr4}'=> $this->clean($form->descr4),
			'{descr5}'=> $this->clean($form->descr5),
			'{descr6}'=> $this->clean($form->descr6),

			'{filesrc1}'=>$form->filesrc,
			'{filesrc2}'=>$form->filesrc2,
			'{filesrc3}'=>$form->filesrc3,
		];

		foreach($rep as $k=>$v)
			$content = str_replace($k,$v,$content);

		foreach([
			'{t1}','{t2}','{t3}','{t4}',
			'{famil}','{username}','{created}','{challenge_name}',
			'{descr1}','{descr2}','{descr3}','{descr4}','{descr5}','{descr6}',
			'{filesrc1}','{filesrc2}','{filesrc3}',
		] as $v)
			$content = str_replace($v,'',$content);

		$zip->FileReplace('word/document.xml', $content, TBSZIP_STRING);
		if (!file_exists('challenge/export/word/')) {
			mkdir('challenge/export/word/', 0777, true);
		}
		$url = 'ch'.$challenge->id.'_'.(isset($auth['id'])?$auth['id']:'-'.rand(0,999999999).'-').'_'.'file.docx';
		$zip->Flush(TBSZIP_FILE, 'challenge/export/word/'.$url);
		return Router::url('/',true).$url;
	}
	//--------------------------------------------------------------------------------
	public function clean($str = null){
		$str = str_replace( array( '\'' , '&', ), ' ', $str);
		return strip_tags($str);
	}
	//--------------------------------------------------------------------------------
	public function getAllword($id = null,$auth = null){
		$form = TableRegistry::get('Challenge.Challengeuserforms')->get($id);
		$challenge = TableRegistry::get('Challenge.Challenges')->get($form->challenge_id);

		$zip = new clsTbsZip();

		$zip->Open('mydoc.docx');
		$content = $zip->FileRead('word/document.xml');
		$p = strpos($content, '</w:body>');
		if ($p === false) exit("Tag </w:body> not found in document.");
		$token = $form->token1 != ''?explode('.',$form->token1):[];
		$rep = [
			'{t1}' => isset($token[0])?$token[0]:'-',
			'{t2}' => isset($token[1])?$token[1]:'-',
			'{t3}' => isset($token[2])?$token[2]:'-',
			'{t4}' => isset($token[3])?$token[3]:'-',

			'{famil}' => isset($auth['family'])?$auth['family']:'-',
			'{username}' => isset($auth['username'])?$auth['username']:'-',
			'{created}' => $this->clean($form->created),
			'{challenge_name}' => $this->clean($challenge->title),

			'{descr1}'=> $this->clean($form->descr1),
			'{descr2}'=> $this->clean($form->descr2),
			'{descr3}'=> $this->clean($form->descr3),
			'{descr4}'=> $this->clean($form->descr4),
			'{descr5}'=> $this->clean($form->descr5),
			'{descr6}'=> $this->clean($form->descr6),

			'{filesrc1}'=>$this->clean($form->filesrc),
			'{filesrc2}'=>$this->clean($form->filesrc2),
			'{filesrc3}'=>$this->clean($form->filesrc3),
		];

		foreach($rep as $k=>$v)
			$content = str_replace($k,$v,$content);

		foreach([
			'{t1}','{t2}','{t3}','{t4}',
			'{famil}','{username}','{created}','{challenge_name}',
			'{descr1}','{descr2}','{descr3}','{descr4}','{descr5}','{descr6}',
			'{filesrc1}','{filesrc2}','{filesrc3}',
		] as $v)
			$content = str_replace($v,'',$content);

		$zip->FileReplace('word/document.xml', $content, TBSZIP_STRING);
		if (!file_exists('challenge/export/word/')) {
			mkdir('challenge/export/word/', 0777, true);
		}
		$url = 'ch'.$challenge->id.'_'.(isset($auth['id'])?$auth['id']:'-'.rand(0,999999999).'-').'_'.'file.docx';
		$zip->Flush(TBSZIP_FILE, 'challenge/export/word/'.$url);
		return Router::url('/',true).$url;
	}
	//--------------------------------------------------------------------------------
	public function getzip($ext = false){
		// Get real path for our folder
		$rootPath = realpath('challenge/export/');

		// Initialize archive object
		$zip = new ZipArchive();
		$filename =date('ymdh-his-'). rand(0,999999999999999);
		$zip->open('challenge/export/dff'.$filename.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file){
			if (!$file->isDir() and strpos($file->getFilename(), '.zip') === false)
			{
				if($ext != null and isset($ext['ext'])){
					if(strpos($file->getFilename(), '.'.$ext['ext']) !== false){
						$filePath = $file->getRealPath();
						$relativePath = substr($filePath, strlen($rootPath) + 1);
						$zip->addFile($filePath, $relativePath);
					}
				}
				else
				{
					$filePath = $file->getRealPath();
					$relativePath = substr($filePath, strlen($rootPath) + 1);
					$zip->addFile($filePath, $relativePath);
				}
			}
			if(strpos($file->getFilename(), '.zip') !== false){
				unlink($file->getRealPath());
			}
		}
		// Zip archive will be created only after closing object
		$zip->close();
		return  Router::url('/',true).'challenge/export/dff'.$filename.'.zip';
	}
	//--------------------------------------------------------------------------------
	public function compileform($datas = null){
		$str = null;
		foreach($datas as $data){
			$str .= '<p>';
			if(isset($data['challengequest'])){
				$str .= '<b>'.$data['challengequest']['title'].'</b>'.'<br>';
			}
			$str .= $data['value'];
			$str .= '</p>';
		}
		//echo $str;
		return $str;
	}
}