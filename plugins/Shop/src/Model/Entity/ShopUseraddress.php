<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopUseraddress Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $billing_state
 * @property string $billing_city
 * @property string $billing_address
 * @property string|null $billing_zip
 * @property string|null $m1
 * @property string|null $m2
 *
 * @property \Shop\Model\Entity\User $user
 */
class ShopUseraddress extends Entity
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
        'user_id' => true,
        'billing_state' => true,
        'billing_city' => true,
        'billing_address' => true,
        'billing_zip' => true,
        'm1' => true,
        'm2' => true,
        'user' => true,
    ];
}
