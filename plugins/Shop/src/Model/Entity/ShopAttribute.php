<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopAttribute Entity
 *
 * @property int $id
 * @property string $title
 * @property int|null $types
 *
 * @property \Shop\Model\Entity\ShopAttributelist[] $shop_attributelists
 * @property \Shop\Model\Entity\ShopOrderattribute[] $shop_orderattributes
 */
class ShopAttribute extends Entity
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
        'title' => true,
        'types' => true,
        'shop_attributelists' => true,
        'shop_orderattributes' => true,
    ];
}
