<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopFavorite Entity
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 *
 * @property \Shop\Model\Entity\Post $post
 * @property \Shop\Model\Entity\User $user
 */
class ShopFavorite extends Entity
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
        'user_id' => true,
        'post' => true,
        'user' => true,
    ];
}
