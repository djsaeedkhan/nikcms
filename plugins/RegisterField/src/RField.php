<?php
namespace RegisterField;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Sms\Sms;

class RField
{
    public $enable = true;
    protected $data = [];
    public function __construct(){
        $data = TableRegistry::get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_registerfield'])
            ->toArray();
        //$data = $this->Func->OptionGet('plugin_registerfield');

        if(! isset($data['plugin_registerfield']))
            $this->enable = false;
        else
            $this->data = unserialize($data['plugin_registerfield']);
    }
    //-----------------------------------------------------------------
    public function __call($name, array $arguments){
        $existing = isset($this->data[$name]) ? $this->data[$name] : [];
        $this->data[$name] = array_merge($existing, $arguments);
        return $this;
    }
    //-----------------------------------------------------------------
    public function create_RegisterField($query = null){

        if($this->enable === false)
            return [];

        $list = [];
        foreach($this->data as $k => $v){
            if(isset($query['type']) and $query['type'] == $v['query'] and $v['enable'] == 1){
                foreach($v as $kv => $vv){
                    if(!in_array($kv , ['enable','query','title']) ){
                        if(isset($vv['field_title']) and $vv['field_title'] != ''){
                            if(in_array($vv['field_type'],['text','textarea']) ){
                                $list["UserMetas.rf_".$vv['field_name']] = [
                                    'name'=> "UserMetas.rf_".$vv['field_name'],
                                    'required' =>'required',
                                    'type' => $vv['field_type'],
                                    'title' => $vv['field_title'],
                                ];
                            }

                            if(in_array($vv['field_type'],['select']) ){
                                $temp = [];
                                foreach(explode(';',$vv['field_value']) as $kim =>$itm){
                                    $temp[$itm] = $itm;
                                }
                                $list["UserMetas.rf_".$vv['field_name']] = [
                                    'name'=> "UserMetas.rf_".$vv['field_name'],
                                    'required' =>'required',
                                    'options' => $temp,
                                    'type' => $vv['field_type'],
                                    'title' => $vv['field_title'],
                                ];
                            }
                        }
                    }
                }
            }
        }
        return $list;
    }
    //-----------------------------------------------------------------
    public function getSms($query = null){
        global $register_users;

        if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($query['type']) and $query['type'] != ''){
            foreach($this->data as $v){
                if( ($v['query'] == $query['type']) and (isset($v['sms']) and $v['sms']!='') ){
                    $sms = new Sms();
                    if($register_users != null and is_numeric($register_users['username'])){
                        $sms->sendsingle([
                            'mobile' => $register_users['username'],
                            'text' => $v['sms']
                        ]);
                    }
                }
            }
        }
    }
    //-----------------------------------------------------------------
}