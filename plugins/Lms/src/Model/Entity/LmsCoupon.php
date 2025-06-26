<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCoupon Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $product_ids
 * @property int|null $usage_limit_per_user
 * @property int|null $usage_limit_price
 * @property int|null $usage_count
 * @property int|null $maximum_amount
 * @property string|null $product_categories
 * @property string|null $discount_type
 * @property \Cake\I18n\FrozenDate|null $expiry_date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Lms\Model\Entity\LmsFactor[] $lms_factors
 */
class LmsCoupon extends Entity
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
        'product_ids' => true,
        'usage_limit_per_user' => true,
        'usage_limit_price' => true,
        'usage_count' => true,
        'maximum_amount' => true,
        'product_categories' => true,
        'discount_type' => true,
        'expiry_date' => true,
        'descr'=> true,
        'created' => true,
        'modified' => true,
        'lms_factors' => true,
    ];
}
