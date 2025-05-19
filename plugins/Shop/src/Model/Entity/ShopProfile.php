<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopProfile Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $family
 * @property string|null $email
 * @property string $phone
 * @property string $nationalid
 *
 * @property \Shop\Model\Entity\User $user
 */
class ShopProfile extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'name' => true,
        'family' => true,
        'email' => true,
        'phone' => true,
        'nationalid' => true,
        'user' => true,
    ];
}
