<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopLogesticuser Entity
 *
 * @property int $id
 * @property int $shop_logestic_id
 * @property int $user_id
 * @property int $created
 *
 * @property \Shop\Model\Entity\ShopLogestic $shop_logestic
 * @property \Shop\Model\Entity\User $user
 */
class ShopLogesticuser extends Entity
{
    /**
     * Fields that can be mass assigned using newEmptyEntity(() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'shop_logestic_id' => true,
        'user_id' => true,
        'created' => true,
        'shop_logestic' => true,
        'user' => true,
    ];
}
