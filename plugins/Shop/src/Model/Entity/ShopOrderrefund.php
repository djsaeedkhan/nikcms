<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopOrderrefund Entity
 *
 * @property int $id
 * @property int $shop_order_id
 * @property int $user_id
 * @property int $types
 * @property int|null $status
 * @property int|null $enable
 * @property string|null $descr
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\ShopOrder $shop_order
 * @property \Shop\Model\Entity\User $user
 */
class ShopOrderrefund extends Entity
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
        'shop_order_id' => true,
        'user_id' => true,
        'types' => true,
        'status' => true,
        'enable' => true,
        'descr' => true,
        'created' => true,
        'shop_order' => true,
        'user' => true,
    ];
}
