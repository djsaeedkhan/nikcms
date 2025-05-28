<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopLogestic Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $descr
 * @property string|null $address
 * @property int $shop_logesticlist_id
 * @property string|null $image
 * @property string|null $phone1
 * @property string|null $phone2
 * @property string|null $mobile1
 * @property string|null $mobile2
 * @property string|null $level
 * @property bool $enable
 * @property string|null $map_url
 * @property string|null $location
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\ShopLogesticlist $shop_logesticlist
 * @property \Shop\Model\Entity\ShopLogesticuser[] $shop_logesticusers
 * @property \Shop\Model\Entity\ShopOrderlogesticlog[] $shop_orderlogesticlogs
 * @property \Shop\Model\Entity\ShopOrderlogestic[] $shop_orderlogestics
 */
class ShopLogestic extends Entity
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
        'descr' => true,
        'address' => true,
        'shop_logesticlist_id' => true,
        'image' => true,
        'phone1' => true,
        'phone2' => true,
        'mobile1' => true,
        'mobile2' => true,
        'level' => true,
        'enable' => true,
        'map_url' => true,
        'location' => true,
        'modified' => true,
        'created' => true,
        'shop_logesticlist' => true,
        'shop_logesticusers' => true,
        'shop_orderlogesticlogs' => true,
        'shop_orderlogestics' => true,
    ];
}
