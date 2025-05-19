<?php
namespace Shop\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Log\Log;

class ProductComponent extends Component
{
    protected $_defaultConfig = [];
    public function Save() {

        if ($this->request->is(['patch', 'post', 'put'])) {
            Log::write('debug',"haaaaaaaaaaaaaaaa");
        }

    }

}
