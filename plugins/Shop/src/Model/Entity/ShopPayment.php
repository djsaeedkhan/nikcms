<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopPayment Entity
 *
 * @property int $id
 * @property int $shop_order_id
 * @property int $user_id
 * @property string $terminalid
 * @property string $price
 * @property string $status
 * @property string $paid
 * @property string|null $au
 * @property string|null $err_code
 * @property string|null $err_text
 * @property string|null $return_data
 * @property string|null $mobile_number
 * @property string|null $myrahid
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\ShopOrder $shop_order
 * @property \Shop\Model\Entity\User $user
 */
class ShopPayment extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'shop_order_id' => true,
        'user_id' => true,
        'terminalid' => true,
        'price' => true,
        'status' => true,
        'paid' => true,
        'au' => true,
        'err_code' => true,
        'err_text' => true,
        'return_data' => true,
        'mobile_number' => true,
        'myrahid' => true,
        'created' => true,
        'shop_order' => true,
        'user' => true,
    ];
}
