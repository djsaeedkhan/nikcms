<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopProductstock Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string|null $pattern
 * @property int $stock
 *
 * @property \Shop\Model\Entity\Post $post
 */
class ShopProductstock extends Entity
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
        'post_id' => true,
        'pattern' => true,
        'stock' => true,
        'post' => true,
    ];
}
