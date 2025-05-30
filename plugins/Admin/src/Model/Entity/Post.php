<?php
declare(strict_types=1);

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\Traits\CommonTrait;
use Admin\Model\Entity\View;

/**
 * Post Entity
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $summary
 * @property string|null $content
 * @property string|resource|null $image
 * @property bool $published
 * @property int|null $post_status
 * @property bool $in_rss
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int|null $user_id
 * @property string $post_type
 * @property int|null $priority
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\PostsTitleTranslation $title_translation
 * @property \App\Model\Entity\PostsSummaryTranslation $summary_translation
 * @property \App\Model\Entity\PostsContentTranslation $content_translation
 * @property \App\Model\Entity\PostsI18n[] $_i18n
 * @property \Admin\Model\Entity\User $user
 * @property \Admin\Model\Entity\Comment[] $comments
 * @property \Admin\Model\Entity\PostMeta[] $post_metas
 * @property \Admin\Model\Entity\Category[] $categories
 * @property \Admin\Model\Entity\Tag[] $tags
 */
class Post extends Entity
{
    // src/Model/Entity/Traits/CommonTrait.php
    use CommonTrait;

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
        'priority' => true,
        'created' => true,
        'modified' => true,
        'title_translation' => true,
        'summary_translation' => true,
        'content_translation' => true,
        '_i18n' => true,
        'user' => true,
        'comments' => true,
        'post_metas' => true,
        'categories' => true,
        'tags' => true,
    ];

    protected $_virtual = ['meta_list'];
    protected function _getmetaList()
    {
        if($this->get('post_metas')):
            $tmp = [];
            foreach($this->get('post_metas') as $d){
                if(isset($d['meta_key'])):
                    $tmp[$d['meta_key']] = $this->is_serialized($d['meta_value'])?unserialize($d['meta_value']):$d['meta_value'];
                endif;
            }
            return $tmp;
        endif;
    }
}