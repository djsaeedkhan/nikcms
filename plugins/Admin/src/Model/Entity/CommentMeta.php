<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * CommentMeta Entity
 *
 * @property int $id
 * @property int $comment_id
 * @property string $meta_type
 * @property string|null $meta_key
 * @property string|null $meta_value
 *
 * @property \Admin\Model\Entity\Comment $comment
 */
class CommentMeta extends Entity
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
        'comment_id' => true,
        'meta_type' => true,
        'meta_key' => true,
        'meta_value' => true,
        'comment' => true,
    ];
}
