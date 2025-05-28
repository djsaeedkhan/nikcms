<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comment Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string|null $author
 * @property string|null $author_email
 * @property string|null $author_url
 * @property string|null $author_IP
 * @property string $content
 * @property string $approved
 * @property string|null $post_type
 * @property int|null $parent_id
 * @property int $lft
 * @property int $rght
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Admin\Model\Entity\Post $post
 * @property \Admin\Model\Entity\Comment $parent_comment
 * @property \Admin\Model\Entity\User $user
 * @property \Admin\Model\Entity\CommentMeta[] $comment_metas
 * @property \Admin\Model\Entity\Comment[] $child_comments
 */
class Comment extends Entity
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
        'author' => true,
        'author_email' => true,
        'author_url' => true,
        'author_IP' => true,
        'content' => true,
        'approved' => true,
        'post_type' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'user_id' => true,
        'created' => true,
        'post' => true,
        'parent_comment' => true,
        'user' => true,
        'comment_metas' => true,
        'child_comments' => true,
    ];
}
