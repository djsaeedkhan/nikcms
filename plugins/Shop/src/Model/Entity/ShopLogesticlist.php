<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopLogesticlist Entity
 *
 * @property int $id
 * @property string $title
 * @property bool $enable
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\ShopLogestic[] $shop_logestics
 */
class ShopLogesticlist extends Entity
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
        'enable' => true,
        'created' => true,
        'shop_logestics' => true,
    ];
}
