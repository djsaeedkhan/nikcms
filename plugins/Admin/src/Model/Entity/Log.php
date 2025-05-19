<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

class Log extends Entity
{
    protected $_accessible = [
        'id' => true,
        'user_id' => true,
        'action_id' => true,
        'group_id' => true,
        'value' => true,
        'created' => true,
        /* 'user' => true,
        'action' => true,
        'group' => true */
    ];
}
