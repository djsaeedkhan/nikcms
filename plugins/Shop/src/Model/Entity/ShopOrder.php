<?php
namespace Shop\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopOrder Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $trackcode
 * @property string|null $token
 * @property string|null $shipmentcode
 * @property string|null $currency
 * @property bool $enable
 * @property string $status
 * @property int|null $shop_address_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Shop\Model\Entity\User $user
 * @property \Shop\Model\Entity\ShopAddress $shop_address
 * @property \Shop\Model\Entity\ShopOrderlogesticlog[] $shop_orderlogesticlogs
 * @property \Shop\Model\Entity\ShopOrderlogestic[] $shop_orderlogestics
 * @property \Shop\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \Shop\Model\Entity\ShopOrderproduct[] $shop_orderproducts
 * @property \Shop\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \Shop\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \Shop\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \Shop\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \Shop\Model\Entity\ShopPayment[] $shop_payments
 */
class ShopOrder extends Entity
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
        'trackcode' => true,
        'token' => true,
        'shipmentcode' => true,
        'currency' => true,
        'enable' => true,
        'status' => true,
        'shop_address_id' => true,
        'created' => true,
        'user' => true,
        'shop_address' => true,
        'shop_orderlogesticlogs' => true,
        'shop_orderlogestics' => true,
        'shop_orderlogs' => true,
        'shop_orderproducts' => true,
        'shop_orderrefunds' => true,
        'shop_ordershippings' => true,
        'shop_ordertexts' => true,
        'shop_ordertokens' => true,
        'shop_payments' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
