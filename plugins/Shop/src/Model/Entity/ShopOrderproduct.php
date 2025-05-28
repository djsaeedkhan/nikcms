<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopOrderproduct Entity
 *
 * @property int $id
 * @property int $shop_order_id
 * @property int|null $post_id
 * @property string $name
 * @property int $quantity
 * @property string $price
 * @property string|null $subtotal
 * @property string|null $attrs
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\ShopOrder $shop_order
 * @property \Shop\Model\Entity\Post $post
 * @property \Shop\Model\Entity\ShopOrderattribute[] $shop_orderattributes
 * @property \Shop\Model\Entity\ShopOrderlogestic[] $shop_orderlogestics
 */
class ShopOrderproduct extends Entity
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
        'shop_order_id' => true,
        'post_id' => true,
        'name' => true,
        'quantity' => true,
        'price' => true,
        'subtotal' => true,
        'attrs' => true,
        'created' => true,
        'shop_order' => true,
        'post' => true,
        'shop_orderattributes' => true,
        'shop_orderlogestics' => true,
    ];
}
