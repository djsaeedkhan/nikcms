<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopAttributelist Entity
 *
 * @property int $id
 * @property int $shop_attribute_id
 * @property string $title
 * @property string $value
 *
 * @property \Shop\Model\Entity\ShopAttribute $shop_attribute
 */
class ShopAttributelist extends Entity
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
        'shop_attribute_id' => true,
        'title' => true,
        'value' => true,
        'shop_attribute' => true,
    ];
}
