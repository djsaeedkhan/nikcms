<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopProductprice Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string $price
 * @property \Cake\I18n\FrozenDate $created
 *
 * @property \Shop\Model\Entity\Post $post
 */
class ShopProductprice extends Entity
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
        'id' => true,
        'post_id' => true,
        'price' => true,
        'created' => true,
        'post' => true,
    ];
}
