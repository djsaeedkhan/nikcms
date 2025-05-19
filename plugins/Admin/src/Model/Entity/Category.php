<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Admin\Core\Shortcode;
use Cake\ORM\Behavior\Translate\TranslateTrait;

class Category extends Entity
{
    use TranslateTrait;
    protected $_accessible = [
        'id' =>false,
        '*' => true,
    ];

    protected function _setSlug($slug){
        return Text::slug(
            Text::excerpt($slug==''?$this->get('title'):$slug,'',20, '...' ),['transliteratorId'=>false]
        );
    }
}