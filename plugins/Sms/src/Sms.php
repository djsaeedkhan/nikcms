<?php
namespace Sms;
use Cake\ORM\TableRegistry;
use SoapClient;
use SoapFault;
use Cake\Log\Log;
use Exception;
use nusoap_client;

class Sms
{
    public $enable = true;
    public $setting = [];
    protected $data = [];
    protected $result = [];
    //------------------------------------------------------------
    public function __construct(){
        $data = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_sms'])
            ->toArray();
        if(! isset($data['plugin_sms'])){
            $this->enable = false;
        }
        else
            $this->setting = unserialize($data['plugin_sms']);
    }
    //------------------------------------------------------------
    public function __call($name, array $arguments){
        $existing = isset($this->setting[$name]) ? $this->setting[$name] : [];
        $this->setting[$name] = array_merge($existing, $arguments);
        return $this;
    }
    //------------------------------------------------------------
    public function status(){
        if($this->enable === false)
            return false;
    }
    //------------------------------------------------------------
    public function sendsingle($data = null){
        if($this->enable === false) 
            return false;

        $this->SmsLogs = TableRegistry::getTableLocator()->get('Sms.SmsLogs');
        try{
            $temp = $this->SmsLogs->newEmptyEntity(null,['validate' => false]);
            $temp = $this->SmsLogs->patchEntity($temp,[
                'mobile' => $data['mobile'],
                'message'=> $data['text'],
                'terminal'=> $this->setting['sms_panel'],
                'status'=> 0,
                'sender'=> $this->setting['sms_sender'] ],[
                    'validate' => false
            ]);
            $saved = $this->SmsLogs->save($temp);
            //Log::write('debug',$temp->getErrors());
        }
        catch (\Exception $e ) {}

        $status = null;
        switch ($this->setting['sms_panel']) {
            case 'vandasms':
                $status = $this->send_single_vanda($data);
                break;

            case 'payamak90':
                # code...
                break;

            case 'mihansms':
                $status = $this->send_single_mihan($data);
                break;

            case 'asanak':
                $status = $this->send_single_asanak($data);
                break;
            default:
                # code...
                break;
        }
        
        if($status != null and isset($saved->id) ){
            $fstatus = $ferror = $ferrortxt = null;
            try {
                if(isset($status['status'])) $fstatus = $status['status'];
                elseif(isset($status->status)) $fstatus = $status->status;
            } catch (\Throwable $th) {
                $fstatus = '';
            }

            try {
                if(isset($status['error'])) $ferror = $status['error'];
                elseif(isset($status->error)) $ferror = $status->error;
            } catch (\Throwable $th) {
                $ferror = '';
            }

            try {
                if(isset($status['error_text'])) $ferrortxt = $status['error_text'];
                elseif(isset($status->error_text)) $ferrortxt = $status->error;
            } catch (\Throwable $th) {
                $ferrortxt = '';
            }
                
            try {
                $p = $this->SmsLogs->query()->update()
                ->set([
                    'status' => $fstatus , 
                    'error'=>   $ferror,
                    'error_text'=> $ferrortxt,
                    ])
                ->where(['id' =>$saved->id ])
                ->execute();
            } catch (\Throwable $th) {
                echo "SmsLogs Not Updated";
            }
        }
        return $status;
    }

    private function send_single_vanda($data = null)
    {
        $client = $this->GetSoap('send');
        if($client == false) return false;

        ini_set("soap.wsdl_cache_enabled", "0");
		try {
			$parameters['username'] = $this->setting['sms_username'] ;
			$parameters['password'] = $this->setting['sms_password'];
			$parameters['from'] = $this->setting['sms_sender'];
			$parameters['to'] = array_values(array($data['mobile']));
			$parameters['text'] = $data['text'];
			$parameters['isflash'] = false;
            $parameters['udh'] = "";
			return @$client->SendSms($parameters);
		} catch (SoapFault $ex) {
			return ($ex->faultstring);
		}
    }

    private function send_single_mihan($data = null)
    {
        require_once(__DIR__.DS.'nusoap.php'); 
        $client = new nusoap_client('http://mihansmscenter.com/webservice/?wsdl', 'wsdl');
        if($client == false) return false;

        $client->decodeUTF8(false);
        $res = null;
        $res = $client->call('send', array(
            'username'	=> $this->setting['sms_username'],
            'password'	=> $this->setting['sms_password'],
            'to'		=> $data['mobile'],
            'from'		=> $this->setting['sms_sender'],
            'message'	=> $data['text']
        ));
        $status = [];
        try {
            if (is_array($res) && isset($res['status']) && $res['status'] === 0) {
                $status = [
                    'status'=>isset($res['status'])? $res['status'] :null,
                    'error' => isset($res['identifier'])? $res['identifier'] :null,
                    'error_text' => isset($res['status_message'])? $res['status_message'] :null,
                ];
                //echo "Message successfully sent. <br />";
                //echo "Message ID: " . $res['identifier'];
            } 
            elseif (is_array($res)) {
                $status = [
                    'status'=>isset($res['status'])? $res['status'] :null,
                    'error' => isset($res['identifier'])? $res['identifier'] :null,
                    'error_text' => isset($res['status_message'])? $res['status_message'] :null,
                ];
                //echo "Error: ".@$res['status_message'];
            }
            else {
                //echo $client->getError();
                $status = [
                    'status'=>isset($res['status'])? $res['status'] :null,
                    'error' => isset($res['identifier'])? $res['identifier'] :null,
                    'error_text' => isset($res['status_message'])? $res['status_message'] :null,
                ];
            }
        } catch (SoapFault $ex) {
            return ($ex->faultstring);
        }
        return  $status;
    }
    //------------------------------------------------------------
    private function send_single_asanak($data = null){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://panel.asanak.com/webservice/v1rest/sendsms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'username' =>  $this->setting['sms_username'],
                'password' => $this->setting['sms_password'],
                'Source' => $this->setting['sms_sender'],
                'Message' => $data['text'],
                'destination' => $data['mobile'],
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = str_replace('[','',$response );
        $response = str_replace(']','',$response );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://panel.asanak.com/webservice/v1rest/msgstatus",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'username' =>  $this->setting['sms_username'],
                'password' => $this->setting['sms_password'],
                'msgid' => $response
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        $status = [];
        try {
            $status = [
                'status'=>isset($response[0]['Status'])? $response[0]['Status'] :null,
                /* 'ferrortxt' =>'',
                'fstatus'=>'',
                'ferror'=>'', */
                'error' => "", //isset($res['identifier'])? $res['identifier'] :null,
                'error_text' => "",// isset($res['status_message'])? $res['status_message'] :null,
            ];
        } catch (SoapFault $ex) {
            return ($ex->faultstring);
        }
        return  $status;
    }
    //------------------------------------------------------------
    public function sendbypattern($data = null){
        $client = new SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
        $user = "mardomyar"; 
        $pass = "m1ardomyar1"; 
        $fromNum = "+985000125475"; 
        $toNum = array($data['mobile']); 
        $pattern_code = "0pqbjg3iso"; 
        $input_data = array( "code" => $data['text']); 
        return $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);
    }
    //------------------------------------------------------------
    public function sendbysingle($data = null){
        if($this->enable === false) 
            return false;

        try{
            $this->SmsLogs = TableRegistry::getTableLocator()->get('Sms.SmsLogs');
            $temp = $this->SmsLogs->newEmptyEntity(null, ['validate' => false]);
            $temp = $this->SmsLogs->patchEntity($temp,[
                'mobile' => $data['mobile'],
                'message'=> $data['text'],
                'sender'=> $this->setting['sms_sender'] ],[
                'validate' => false
            ]);
            $this->SmsLogs->save($temp);
            //Log::write('debug',$temp->getErrors());
        }
        catch (\Exception $e ) {}

        if($this->setting['sendbysingle_provider'] == 'vanda'){
            $client = $this->GetSoap('send');
            ini_set("soap.wsdl_cache_enabled", "0");
            try {
                $parameters['username'] = $this->setting['sendbysingle_user'] ;
                $parameters['password'] = $this->setting['sendbysingle_pass'];
                $parameters['from'] = $this->setting['sendbysingle_sendnum'];
                $parameters['to'] = $data['mobile'];
                $parameters['text'] = $data['text'];
                if(isset($this->setting['sendbysingle_bodyid']) and $this->setting['sendbysingle_bodyid'] !='')
                    $parameters['bodyId'] = $this->setting['sendbysingle_bodyid'];
                return @$client->SendByBaseNumber2($parameters);
            } catch (SoapFault $ex) {
                return ($ex->faultstring);
            }
        }
        elseif($this->setting['sendbysingle_provider'] == 'ippanel'){
            $client = new SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
            $user = $this->setting['sendbysingle_user']; 
            $pass = $this->setting['sendbysingle_pass']; 
            $fromNum = $this->setting['sendbysingle_sendnum']; 
            $toNum = array_values(array($data['mobile'])); 
            $pattern_code = $this->setting['sendbysingle_bodyid']; 
            $input_data['code'] = isset($data['text'])? $data['text']:null;
            $input_data['user'] = isset($data['mobile'])?$data['mobile']: null;
           // $input_data = (['code'=>'1234']);

            if(isset($this->setting['sendbysingle_pattern']) and $this->setting['sendbysingle_pattern']!= ''){
                $list = explode(',',$this->setting['sendbysingle_pattern']);
                foreach($input_data as $k=>$v){
                    if(!in_array($k , $list))
                        unset($input_data[$k]);
                }
            }
            $p = $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);
            Log::write('debug',$p);
            return $p;
        }
    }
    //------------------------------------------------------------
    public function GetSoap($type = null){
        ini_set("default_socket_timeout", 20000);
        $url = null;
        switch($type):
            case 'users':
                $url = $this->setting['sms_apiurl'].'/post/Users.asmx?wsdl';break;
            case 'actions':
                $url = $this->setting['sms_apiurl'].'/post/actions.asmx?wsdl';break;
            case 'receive':
                $url = $this->setting['sms_apiurl'].'/post/receive.asmx?wsdl';break;
            case 'send':
                $url = $this->setting['sms_apiurl'].'/post/Send.asmx?wsdl';break;  
            /* case 'sendmax':
                $url = 'http://ippanel.com/class/sms/wsdlservice/server.php?wsdl';break;   */
        endswitch;

        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }

        return new SoapClient($url, [
            'encoding'=>'UTF-8',
            'exceptions' => true,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'connection_timeout' => 30000,
            //'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
        ]);
    }
    //------------------------------------------------------------
    public function create_message($type , $token = null){
        $text = isset($this->setting['smstext_before'])?$this->setting['smstext_before']:'';
        switch ($type) {
            case 'activate':
                $temp = str_replace('{token}', $token, 
                    (isset($this->setting['smstext_activate'])?$this->setting['smstext_activate']:'')
                );
                $text .= $temp;
                break;
            case 'register_success':
                $temp = (isset($this->setting['smstext_regsucc'])?$this->setting['smstext_regsucc']:'');
                if($temp == '')
                    return false;

                $text .= $temp;
                break;
            default:
                $text .=$token;
                break;
        }
        $text.= isset($this->setting['smstext_after'])?$this->setting['smstext_after']:'';
        return $text;
    }
    //------------------------------------------------------------
    public function create_text($text = null , $token = null){
        if(is_array($token)){
            foreach($token as $k=>$v){
                if(strpos($text, ("%".$k."%") ) !== false)
                $text = str_replace(("%".$k."%") , $v,$text);
            }
        }
        return $text;
    }
    //------------------------------------------------------------
}