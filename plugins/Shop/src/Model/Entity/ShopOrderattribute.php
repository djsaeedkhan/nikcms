<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopOrderattribute Entity
 *
 * @property int $id
 * @property int $shop_orderproduct_id
 * @property int $shop_attribute_id
 * @property int $shop_attributelist_id
 *
 * @property \Shop\Model\Entity\ShopOrderproduct $shop_orderproduct
 * @property \Shop\Model\Entity\ShopAttribute $shop_attribute
 * @property \Shop\Model\Entity\ShopAttributelist $shop_attributelist
 */
class ShopOrderattribute extends Entity
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
        'shop_orderproduct_id' => true,
        'shop_attribute_id' => true,
        'shop_attributelist_id' => true,
        'shop_orderproduct' => true,
        'shop_attribute' => true,
        'shop_attributelist' => true,
    ];
}
