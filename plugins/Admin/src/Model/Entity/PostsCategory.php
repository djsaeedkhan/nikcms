<?php
declare(strict_types=1);

namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostsCategory Entity
 *
 * @property int $id
 * @property int $post_id
 * @property int $category_id
 *
 * @property \Admin\Model\Entity\Post $post
 * @property \Admin\Model\Entity\Category $category
 */
class PostsCategory extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'post_id' => true,
        'category_id' => true,
        'post' => true,
        'category' => true,
    ];
}
