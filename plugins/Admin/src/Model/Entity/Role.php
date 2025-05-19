<?php
namespace Admin\Model\Entity;
use Cake\ORM\Entity;

class Role extends Entity
{
    protected $_accessible = [
        '*' => true,
        //'data' => true,
    ];
}
