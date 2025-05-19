<?php
namespace Widget\Model\Entity;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

class Widget extends Entity
{
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'created' => true
    ];

    protected function _setSlug($slug){
        return Text::slug(
            Text::excerpt($slug==''?$this->get('title'):$slug,'',20, '...' ),['transliteratorId'=>false]
        );
    }
}
