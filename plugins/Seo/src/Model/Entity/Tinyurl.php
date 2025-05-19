<?php
namespace Tinyurl\Model\Entity;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

class Tinyurl extends Entity
{
    protected $_accessible = [
        'title' => true,
        'link' => true,
        'slug' => true,
        'category' => true,
        'expire' => true,
        'status' => true,
        'created' => true
    ];
    protected function _setSlug($slug){
        return Text::slug(
            Text::excerpt($slug==''?$this->get('title'):$slug,'',20, '...' ),['transliteratorId'=>false]
        );
    }
}
