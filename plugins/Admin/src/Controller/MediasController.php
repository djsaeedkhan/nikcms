<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Routing\Router;
use Admin\Core\Resize;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class MediasController extends AppController
{
    public $media_ptype = 'media';
    public function initialize(): void
    {
        parent::initialize();
        $parentCategory = TableRegistry::getTableLocator()->get('Admin.Categories')
            ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => '—'])
            ->where(['Categories.post_type'=>'media']);
        
        $media_ptype = $this->media_ptype;
        $this->set(compact('parentCategory','media_ptype'));
    }
    //-----------------------------------------------
    public function index()
    {
        $media = $this->Medias->find('all')
            ->contain(['PostMetas'])
            ->order(['Medias.id'=>'desc'])
            ->where([
                'Medias.post_type'=>$this->media_ptype,
                ($this->request->getQuery('text')?['Medias.title LIKE '=>'%'.$this->request->getQuery('text').'%']:null)
            ]);
        if($this->request->getQuery('parent_id')){
            $idd = $this->request->getQuery('parent_id');
            $media->matching('Categories', function ($q) use($idd) {
                return $q->where(['Categories.id' => $idd]);
            });
        }
        $medias = $this->paginate($media,['limit' => 42]);
        $this->set(compact('medias'));
    }
    //-----------------------------------------------
    public function gallery()
    {
        $this->viewBuilder()->setLayout('ajax') ;
        $result = $this->Medias->find('all')
            ->contain(['PostMetas'])
            ->order(['Medias.id'=>'desc']);
        if(isset($this->request->getParam('?')['name']) and $this->request->getParam('?')['name']!=''){
           $result->where([
               'post_type'=>$this->media_ptype,
               ($this->request->getQuery('name')?['title LIKE '=>'%'.$this->request->getQuery('name').'%']:null)
           ]);
        }
        else{
            $result->where(['post_type'=>$this->media_ptype]);
        }
        $media = $this->paginate($result,['limit' => 24,]);
        $this->set(compact('media'));
    }
    //-----------------------------------------------
    public function view($id)
    {
        $media = $this->Medias->get($id, [
            'contain' => ['PostMetas','Categories']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $media = $this->Medias->patchEntity($media, $this->request->getData());
            if ($this->Medias->save($media))
                $this->Flash->success(__d('Admin', 'File has been updated successfully.'));
            else
                $this->Flash->error(__d('Admin', 'Unable to updated file, please try again.'));
            $this->redirect($this->referer());
        }
        $categories = $this->Medias->Categories
            ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => "—",'escape'=>'false'])
            ->where(['post_type'=>$this->media_ptype]);

        $this->set(compact('media', 'categories'));
    }
    //-----------------------------------------------
    public function add2($id = null) //add_manual
    {
        if ($this->request->is('post')) {
            if(!empty($this->request->getData('file.name'))){
                $fileName = $this->request->getData('file.name');
                return $this->before_upload();
            }
            else
                $this->Flash->error(__d('Admin', 'Please choose a file to upload.'));
        }
        $this->render('add_manual');
    }
    //-----------------------------------------------
    public function add($id = null){
        switch ($this->Func->OptionGet('media_zone')) {
            case '1': //handy
                return $this->add_manual($id);
                break;
            
            case '2': //drag_drop
                return $this->add_manual($id);
                break;

            default: // multi_select //3
                return $this->add_multi();
                break;
        } ;
    }
    //-----------------------------------------------
    private function before_upload(){

        $file = $this->request->getData('file');
        $filename = $file->getClientFilename();
        $size = $file->getSize();
        $type = $file->getClientMediaType();
        $tmpName = $file->getStream()->getMetadata('uri');

        $file_uploaded = $this->uploadfile($this->request->getData('file'));
        if( $file_uploaded != 0 ){
            //$fileName = $image->getClientFilename();
            $this->request = $this->request->withData('title', $filename);
            $this->request = $this->request->withData('image', $filename);
            $this->request = $this->request->withData('published', 1);
            $this->request = $this->request->withData('post_type', $this->media_ptype);
            $this->request = $this->request->withData('user_id', $this->request->getAttribute('identity')->get('id'));

            $media = $this->Medias->patchEntity($this->Medias->newEmptyEntity(),$this->request->getData());
            if ($media = $this->Medias->save($media)){

                $filename = $file_uploaded['filename_real']; // replace old name to new name
                $file_uploaded['media_id'] = $media->id;
                $file_uploaded['filename_miniaddr'] = $this->upload_path. $filename;
                $file_uploaded['filename_fulladdr'] = router::url(DS.$this->upload_path. $filename,true);
                $file_uploaded['tokn_id'] = isset($this->request->getData()['tokn_id'])?intval($this->request->getData()['tokn_id']):"";

                $this->Func->PostMetaSave($media->id,[
                    'type' => 'url',
                    'name' => 'full',
                    'value' => $filename,
                    'action' => 'create']);

                $p = $this->save_image_size($filename, $media->id);
                if($p != 0)
                    $file_uploaded += $p;

                if( $this->Func->OptionGet('watermark_enable') == 1 and ($watermark = $this->Func->OptionGet('watermark_url')) != "" ){
                    
                    try {
                        $watermarkImage = imagecreatefrompng($watermark); 
                        $file_fullname = $file_uploaded['file_fullname'];
                        $extension = mb_strtolower(strtolower(pathinfo($filename, PATHINFO_EXTENSION)));
                        if($extension == 'jpg'){
                            $im = imagecreatefromjpeg($file_fullname); 
                        }elseif($extension == 'jpeg'){
                            $im = imagecreatefromjpeg($file_fullname); 
                        }elseif($extension == 'png'){
                            $im = imagecreatefrompng($file_fullname); 
                        }else{
                            $im = imagecreatefromjpeg($file_fullname);
                        }
                        
                        // Set the margins for the watermark 
                        $marge_right = $this->Func->OptionGet('marge_right')!= ""?intval($this->Func->OptionGet('marge_right')):100; 
                        $marge_bottom = $this->Func->OptionGet('marge_bottom')!= ""?intval($this->Func->OptionGet('marge_bottom')):100; 
                            
                        // Get the height/width of the watermark image 
                        $sx = imagesx($watermarkImage); 
                        $sy = imagesy($watermarkImage); 
                            
                        // Copy the watermark image onto our photo using the margin offsets and the photo width to calculate the positioning of the watermark. 
                        imagecopy($im, $watermarkImage, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($watermarkImage), imagesy($watermarkImage)); 
                            
                        // Save image and free memory 
                        imagepng($im, $file_fullname); 
                        imagedestroy($im); 
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
                $this->set([
                    'filename' =>$file_uploaded
                ]);
                return $this->response->withStringBody(json_encode($file_uploaded));
            }
            else
                $this->Flash->error(__d('Admin', 'آپلود فایل امکان پذیر نمی باشد. لطفا دوباره تلاش کنید (1)'));
        }
        else
            $this->Flash->error(__d('Admin', 'آپلود فایل امکان پذیر نمی باشد. لطفا دوباره تلاش کنید (2)'));
    }
    //-----------------------------------------------

    public function add_multi($id = null)
    {
        if ($this->request->is(['post','ajax'])) {
            //Log::write('debug',$this->request);
            $this->autoRender = false;
            $image = $this->request->getUploadedFile('file');
            if ($image !== null && $image->getError() !== UPLOAD_ERR_NO_FILE){
                if($this->request->getQuery('parent_id'))
                    $this->request = $this->request->withData('categories._ids',[$this->request->getQuery('parent_id')]);

                return $this->before_upload();
            }
            else
                $this->Flash->error(__d('Admin', 'لطفا یک فایل برای آپلود انتخاب کنید.'));
        }
        $this->render('add_multi');
    }
    //-----------------------------------------------
    public function AjaxAdd($id = null)
    {
        $result = [];
        if( !$this->request->is('ajax') or !$this->request->is('post')) {
            die('0');
        }

        if(!empty($this->request->getData('file.name'))){
            $fileName = $this->request->getData('file.name');

            return $this->before_upload();

            /* if(($fileName = $this->uploadfile($this->request->getData('file'))) != '0'){
            
                $media = $this->Medias->patchEntity($this->Medias->newEmptyEntity(),[
                    'title'=> $fileName['filename'],
                    'image'=> $fileName['filename'],
                    'published'=> 1,
                    'post_type'=>$this->media_ptype,
                    'user_id'=> $this->request->getAttribute('identity')->get('id'),
                ]);
                if ($media = $this->Medias->save($media)){

                    $fileName['media_id'] = $media->id;
                    $fileName['filename_miniaddr'] = $this->upload_path. $fileName['filename'];
                    $fileName['filename_fulladdr'] = router::url(DS.$this->upload_path. $fileName['filename'],true);
                    $fileName['token'] = isset($this->request->getData()['token'])?$this->request->getData()['token']:"";
                    
                    $this->Func->PostMetaSave($media->id,[
                        'type' => 'url',
                        'name' => 'full',
                        'value' => $fileName['filename'],
                        'action' => 'create']);

                    $p = $this->save_image_size($fileName['filename'],$media->id);
                    $fileName += $p;

                    die(json_encode($fileName));
                }
                else die('0');
            }
            else die('0'); */
        }
        else die('0');
    }
    //-----------------------------------------------
    public function edit($id = null)
    {
        if($this->request->getQuery('id'))
            $id = $this->request->getQuery('id');
        $media = $this->Medias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $media = $this->Medias->patchEntity($media, $this->request->getData());
            if ($this->Medias->save($media)) {
                $this->Flash->success(__d('Admin', 'The media has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('Admin', 'The media could not be saved. Please, try again.'));
        }
        $this->set(compact('media'));
    }
    //-----------------------------------------------
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $delete = [];

        if($id != 'list'):
            $delete [] = $id;
        else:
            foreach($this->request->getData() as $k => $v)
            $delete [] = $k;
        endif;

        if(count($delete)):
            foreach($delete as $id):
                $media = $this->Medias->get($id, [
                    'contain' => ['PostMetas']
                ]);
                if ($this->Medias->delete($media)){
                    @unlink($this->upload_path.$media->image);
                    foreach($media->post_metas as $pm){
                        @unlink($this->upload_path.$pm->meta_value);
                    }
                    $this->Flash->success(__d('Admin', 'The media has been deleted.'));
                }
                else
                    $this->Flash->error(__d('Admin', 'The media could not be deleted. Please, try again.'));
            endforeach;
        endif;

        return $this->redirect($this->referer());
    }
    //-----------------------------------------------
    private function uploadfile($file = null){
        $file = $this->request->getData('file');
        $filename = str_replace(' ', '-', $file->getClientFilename());
        $size = $file->getSize();
        $type = $file->getClientMediaType();
        $tmpName = $file->getStream()->getMetadata('uri');
        $extension = mb_strtolower(strtolower(pathinfo($filename, PATHINFO_EXTENSION)));

		if(!empty( $tmpName )){
            
            if($this->Func->OptionGet('media_renamefile') == 1)
                $file_name = $this->Func->UniqId(16).'.'.$extension ;
            else
                $file_name = $this->Func->Numconvert( $filename );

            /* $file_name = iconv('utf-8','windows-1256', str_replace('ی', 'ي', $file_name));
            $file_name = strtolower(str_replace(' ','_',$file_name)); */

            $file_name = str_ireplace(['/','(',')','<',',','>',' '],'_',$file_name);
            $file_name = str_replace('__','_',$file_name);
			$ext = array('webp','svg','zip','rar','jpg','jpeg','png','gif','pdf','docx','doc','xls','xlsx','mp4','mov','mp3','avi');
			if(!in_array($extension, $ext))
                return '0';

            if (!file_exists($this->upload_path)) {
                mkdir($this->upload_path, 0777, true);
            }

            $file_name = $this->_file_not_exists($file_name,$extension);
            $file_name = mb_strtolower($file_name);//.'.'.$extension;
            $file_fullname = $this->upload_path . $file_name;
			if (move_uploaded_file( $tmpName , $file_fullname)){
                return [
                    'filename' => $file_name,
                    'file_fullname' => $file_fullname,
                    'filename_real' => $filename,
                    'ext' => $extension,
                    'status'=>true,
                ];
            }
		}
        return 0;
	}
    //-----------------------------------------------
    private function _file_not_exists($file_name,$extension){
        $i=0;
        while(true){
            if(file_exists($this->upload_path. mb_strtolower($file_name))){
                $file_name = str_replace('.'.$extension,'',$file_name);
                $file_name = $file_name . ++$i . '.' .$extension;
            }
            else return $file_name;
        }
    }
    //-----------------------------------------------
    private function save_image_size($url, $media_id=null){
        $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        $ext = array('jpg','jpeg','png');
        if(! in_array($extension,$ext))
            return 0;

        /* $option_media = $this->getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name'=>'gallery_size'])
            ->first(); */
        $option_media = $this->Func->OptionGet('gallery_size');
        if($option_media)
            $option_media = unserialize($option_media);
        else
            $option_media = [];

        $size = $this->Func->gallery_size();
        $result_size = [];
        foreach($size as $size_key => $size_value):
            if($option_media == null or isset($option_media[$size_key]) ){
                $result = $this->ImageCreateTHumbnail(array(
                    'url'=> WWW_ROOT . $this->upload_path . $url,
                    'dest_path'=>'uploads',
                    'width'=>$size_value['width'],
                    'height'=>$size_value['height'],
                    'mode'=>$size_value['mode'],//(options: exact, portrait, landscape, auto, crop)
                    'quality'=>'100',
                ));

                if($result != null){
                    $newimg = str_replace($this->upload_path,'',$result);
                    $result_size[$size_key] = [
                        'size' => $size_key,
                        'name' => $newimg,
                        'miniaddr' => $this->upload_path. $newimg,
                        'fulladdr' => router::url(DS.$this->upload_path. $newimg,true),
                        'id' => $media_id];

                    $this->Func->PostMetaSave($media_id,[
                        'type' => 'image-size',
                        'name' => $size_key,
                        'value' => $newimg,
                        'action' => 'create']);
                }
                
            }
        endforeach;
        return $result_size;
    }
    //-----------------------------------------------
    private function ImageCreateTHumbnail( $opt = null)
    {
        $save_path = null;
        
        try {
            $resizeObj = new Resize($opt['url'], [
                'white_png_background' => $this->Func->OptionGet('white_png_background')
            ]);
        } catch (\Throwable $th) {
        }

        $ext = strtolower(pathinfo($opt['url'], PATHINFO_EXTENSION));
        $name = explode('/',str_replace('.'.$ext,'',$opt['url']).'-'.$opt['width'].'x'.$opt['height'].'.'.$ext);
        $name = end($name);

        if($resizeObj != null){
            $resizeObj -> resizeImage($opt['width'], $opt['height'], $opt['mode']);
            $resizeObj -> saveImage($save_path = ($opt['dest_path'].'/'.$name), $opt['quality']);
        }
 
        return ($save_path);
        
    }
    //-----------------------------------------------
}