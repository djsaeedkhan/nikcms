<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopProductmajor Entity
 *
 * @property int $id
 * @property int $post_id
 * @property int $start
 * @property string|null $pattern
 * @property int|null $stock
 * @property int $price
 *
 * @property \Shop\Model\Entity\Post $post
 */
class ShopProductmajor extends Entity
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
        'start' => true,
        'pattern' => true,
        'stock' => true,
        'price' => true,
        'post' => true,
    ];
}
