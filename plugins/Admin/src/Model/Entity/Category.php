<?php
declare(strict_types=1);

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\ORM\Behavior\Translate\TranslateTrait;

/**
 * Category Entity
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $description
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property string|null $post_type
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\CategoriesTitleTranslation $title_translation
 * @property \App\Model\Entity\CategoriesDescriptionTranslation $description_translation
 * @property \App\Model\Entity\CategoriesI18n[] $_i18n
 * @property \Admin\Model\Entity\Post[] $posts
 * @property \App\Model\Entity\ParentCategory $parent_category
 * @property \App\Model\Entity\ChildrenCategory[] $children_categories
 * @property \Admin\Model\Entity\CategorieMeta[] $categorie_metas
 */
class Category extends Entity
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
    use TranslateTrait;
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'description' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'post_type' => true,
        'created' => true,
        'title_translation' => true,
        'description_translation' => true,
        '_i18n' => true,
        'posts' => true,
        'parent_category' => true,
        'children_categories' => true,
        'categorie_metas' => true,
    ];
    
    protected function _setSlug($slug){
        return Text::slug(
            Text::excerpt($slug==''?$this->get('title'):$slug,'',20, '...' ),['transliteratorId'=>false]
        );
    }
}
