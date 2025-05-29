<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopLabel Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $color
 * @property string|null $image
 * @property string|null $descr
 * @property string|null $link
 */
class ShopLabel extends Entity
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
        'color' => true,
        'image' => true,
        'descr' => true,
        'link' => true,
    ];
}
