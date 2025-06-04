<?php
declare(strict_types=1);

namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Log Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $action_id
 * @property string $group_id
 * @property string $value
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Challenge\Model\Entity\User[] $users
 * @property \Challenge\Model\Entity\Group $group
 */
class Log extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'id' => true,
        'user_id' => true,
        'action_id' => true,
        'group_id' => true,
        'value' => true,
        'created' => true,
        'users' => true,
        'group' => true,
    ];
}
