<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * Media Entity
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $summary
 * @property string|null $content
 * @property string|null $image
 * @property bool $published
 * @property int|null $post_status
 * @property bool $in_rss
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int|null $user_id
 * @property string $post_type
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Admin\Model\Entity\PostMeta[] $post_metas
 * @property \Admin\Model\Entity\Category[] $categories
 */
class Media extends Entity
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
        'slug' => true,
        'summary' => true,
        'content' => true,
        'image' => true,
        'published' => true,
        'post_status' => true,
        'in_rss' => true,
        'meta_title' => true,
        'meta_description' => true,
        'meta_keywords' => true,
        'user_id' => true,
        'post_type' => true,
        'created' => true,
        'modified' => true,
        'post_metas' => true,
        'categories' => true,
    ];

    protected function _setSlug($slug){
        return Text::slug(
            Text::excerpt($slug==''?$this->get('title'):$slug,'',20, '...' ),['transliteratorId'=>false]
        );
    }
}
