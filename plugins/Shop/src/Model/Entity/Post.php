<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
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
 * @property \Shop\Model\Entity\User $user
 * @property \Shop\Model\Entity\Comment[] $comments
 * @property \Shop\Model\Entity\PostMeta[] $post_metas
 * @property \Shop\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \Shop\Model\Entity\ShopOrderproduct[] $shop_orderproducts
 * @property \Shop\Model\Entity\ShopProductMeta[] $shop_product_metas
 * @property \Shop\Model\Entity\ShopProductParam[] $shop_product_params
 * @property \Shop\Model\Entity\ShopProductdetail[] $shop_productdetails
 * @property \Shop\Model\Entity\ShopProductmajor[] $shop_productmajors
 * @property \Shop\Model\Entity\ShopProductprice[] $shop_productprices
 * @property \Shop\Model\Entity\ShopProductstock[] $shop_productstocks
 * @property \Shop\Model\Entity\Ticket[] $tickets
 * @property \Shop\Model\Entity\Category[] $categories
 * @property \Shop\Model\Entity\I18n[] $i18n
 * @property \Shop\Model\Entity\Tag[] $tags
 */
class Post extends Entity
{
    /**
     * Fields that can be mass assigned using newEmptyEntity() or patchEntity().
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
        'user' => true,
        'comments' => true,
        'post_metas' => true,
        'shop_favorites' => true,
        'shop_orderproducts' => true,
        'shop_product_metas' => true,
        'shop_product_params' => true,
        'shop_productdetails' => true,
        'shop_productmajors' => true,
        'shop_productprices' => true,
        'shop_productstocks' => true,
        'tickets' => true,
        'categories' => true,
        'i18n' => true,
        'tags' => true,
    ];
}
