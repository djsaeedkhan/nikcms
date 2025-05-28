<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopAddress Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $emails
 * @property string $phone
 * @property string|null $nationalid
 * @property int $shop_useraddress_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\User $user
 * @property \Shop\Model\Entity\ShopUseraddress $shop_useraddress
 * @property \Shop\Model\Entity\ShopOrder[] $shop_orders
 */
class ShopAddress extends Entity
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
        'user_id' => true,
        'first_name' => true,
        'last_name' => true,
        'emails' => true,
        'phone' => true,
        'nationalid' => true,
        'shop_useraddress_id' => true,
        'created' => true,
        'user' => true,
        'shop_useraddress' => true,
        'shop_orders' => true,
    ];
}
