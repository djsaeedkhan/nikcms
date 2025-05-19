<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

class Tag extends Entity
{
    protected $_accessible = [
        '*' => true,
    ];

    protected function _setSlug($slug){
        return Text::slug(
            Text::excerpt($slug==''?$this->get('title'):$slug,'',20, '...' ),['transliteratorId'=>false]
        );
    }
}
