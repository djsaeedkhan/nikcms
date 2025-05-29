<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopOrderlogesticlog Entity
 *
 * @property int $id
 * @property string $descr
 * @property string|null $image
 * @property int $shop_logestic_id
 * @property int $shop_order_id
 * @property int $shop_orderlogestic_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\ShopLogestic $shop_logestic
 * @property \Shop\Model\Entity\ShopOrder $shop_order
 * @property \Shop\Model\Entity\ShopOrderlogestic $shop_orderlogestic
 * @property \Shop\Model\Entity\User $user
 */
class ShopOrderlogesticlog extends Entity
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
        'descr' => true,
        'image' => true,
        'shop_logestic_id' => true,
        'shop_order_id' => true,
        'shop_orderlogestic_id' => true,
        'user_id' => true,
        'created' => true,
        'shop_logestic' => true,
        'shop_order' => true,
        'shop_orderlogestic' => true,
        'user' => true,
    ];
}
