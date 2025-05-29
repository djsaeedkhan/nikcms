<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopProductdetail Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string|null $pattern
 * @property string|null $image
 * @property string|null $sku
 * @property int|null $price
 * @property int|null $special_price
 * @property int|null $stock
 * @property bool $disable
 * @property string|null $descr
 *
 * @property \Shop\Model\Entity\Post $post
 */
class ShopProductdetail extends Entity
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
        'post_id' => true,
        'pattern' => true,
        'image' => true,
        'sku' => true,
        'price' => true,
        'special_price' => true,
        'stock' => true,
        'disable' => true,
        'descr' => true,
        'post' => true,
    ];
}
