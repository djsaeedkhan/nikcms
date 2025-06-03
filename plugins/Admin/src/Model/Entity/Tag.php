<?php
declare(strict_types=1);

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

/**
 * Tag Entity
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $post_type
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\TagsTitleTranslation $title_translation
 * @property \App\Model\Entity\I18n[] $_i18n
 * @property \Admin\Model\Entity\Post[] $posts
 */
class Tag extends Entity
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
        'title' => true,
        'slug' => true,
        'meta_title' => true,
        'meta_description' => true,
        'meta_keywords' => true,
        'post_type' => true,
        'created' => true,
        'title_translation' => true,
        '_i18n' => true,
        'posts' => true,
    ];

    protected function _setSlug($slug){
        return Text::slug(
            Text::excerpt($slug==''?$this->get('title'):$slug,'',20, '...' ),['transliteratorId'=>false]
        );
    }
}
