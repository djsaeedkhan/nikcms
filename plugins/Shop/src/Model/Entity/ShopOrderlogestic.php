<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopOrderlogestic Entity
 *
 * @property int $id
 * @property int $shop_order_id
 * @property int $shop_orderproduct_id
 * @property int $shop_logestic_id
 * @property int $user_id
 * @property int|null $enable
 * @property string|null $enable_descr
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\ShopOrder $shop_order
 * @property \Shop\Model\Entity\ShopOrderproduct $shop_orderproduct
 * @property \Shop\Model\Entity\ShopLogestic $shop_logestic
 * @property \Shop\Model\Entity\User $user
 * @property \Shop\Model\Entity\ShopOrderlogesticlog[] $shop_orderlogesticlogs
 */
class ShopOrderlogestic extends Entity
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
        'shop_order_id' => true,
        'shop_orderproduct_id' => true,
        'shop_logestic_id' => true,
        'user_id' => true,
        'enable' => true,
        'enable_descr' => true,
        'created' => true,
        'shop_order' => true,
        'shop_orderproduct' => true,
        'shop_logestic' => true,
        'user' => true,
        'shop_orderlogesticlogs' => true,
    ];
}
