<?php
declare(strict_types=1);

namespace Userslogs\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersLog Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $username
 * @property int|null $types
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Userslogs\Model\Entity\User $user
 */
class UsersLog extends Entity
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
        'user_id' => true,
        'username' => true,
        'types' => true,
        'created' => true,
        'user' => true,
    ];
}
