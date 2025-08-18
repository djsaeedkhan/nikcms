<?php
namespace App\Policy;

use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;

class RequestPolicy implements RequestPolicyInterface
{
    public function canAccess($identity, ServerRequest $request)
    {
        $plg = strtolower( (string) $request->getParam('plugin'));
        $cont = strtolower( (string) $request->getParam('controller'));
        $act = strtolower( (string) $request->getParam('action'));
        
        $unauthorize = [
            '',
            'website',
            'captcha',
            'lms'
        ];
        
        //pr($request->getAttribute('identity'));
        //die("{$plg}__{$cont}__{$act}");
        if($request->getAttribute('identity')):
            if($request->getAttribute('identity')->get('role_id') == 1 )
                return true;

            $role = ($request->getAttribute('identity')->get('role')['data']);
            $role = unserialize($role);
            if (isset($role[$plg])) {
                if (isset($role[$plg][$cont][$act]) and $role[$plg][$cont][$act] != "0"){
                    //$this->Flash->error("{$plg}__{$cont}__{$act}");
                    return true;
                }else{
                    //$this->Flash->error("{$plg}__{$cont}__{$act}");
                    //Log::write('debug', ['plgin'=>$plg,'cont'=>$cont,'act'=>$act ]);
                    return false;
                }
            }
            return true;

        elseif(in_array($plg, $unauthorize)):
            return true;

        else:
            return false;
            
        endif;
    }
}