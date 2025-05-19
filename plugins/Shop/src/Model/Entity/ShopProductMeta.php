<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopProductMeta Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string|null $meta_type
 * @property string|null $meta_key
 * @property string|null $meta_value
 *
 * @property \Shop\Model\Entity\Post $post
 */
class ShopProductMeta extends Entity
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
        'post_id' => true,
        'meta_type' => true,
        'meta_key' => true,
        'meta_value' => true,
        'post' => true,
    ];
}
