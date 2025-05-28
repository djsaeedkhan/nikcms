<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopBrand Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $descr
 * @property string|null $image
 * @property string|null $link
 */
class ShopBrand extends Entity
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
        'title' => true,
        'slug' => true,
        'descr' => true,
        'image' => true,
        'link' => true,
    ];
}
