<?php
namespace Role\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $title
 * @property string $data
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Role\Model\Entity\User[] $users
 */
class Role extends Entity
{
    /**
     * Fields that can be mass assigned using newEmptyEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'data' => true,
        'created' => true,
        'users' => true,
    ];
}
