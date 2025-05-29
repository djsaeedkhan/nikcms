<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopParam Entity
 *
 * @property int $id
 * @property string $title
 *
 * @property \Shop\Model\Entity\ShopParamlist[] $shop_paramlists
 */
class ShopParam extends Entity
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
        'shop_paramlists' => true,
    ];
}
