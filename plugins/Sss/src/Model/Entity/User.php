<?php
declare(strict_types=1);

namespace Sss\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $family
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $role_id
 * @property bool $enable
 * @property string|null $token
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Sss\Model\Entity\Role $role
 * @property \Sss\Model\Entity\Comment[] $comments
 * @property \Sss\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \Sss\Model\Entity\Log[] $logs
 * @property \Sss\Model\Entity\PollVote[] $poll_votes
 * @property \Sss\Model\Entity\Post[] $posts
 * @property \Sss\Model\Entity\Profile[] $profiles
 * @property \Sss\Model\Entity\ShopAddress[] $shop_addresses
 * @property \Sss\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \Sss\Model\Entity\ShopLogesticuser[] $shop_logesticusers
 * @property \Sss\Model\Entity\ShopOrderlogesticlog[] $shop_orderlogesticlogs
 * @property \Sss\Model\Entity\ShopOrderlogestic[] $shop_orderlogestics
 * @property \Sss\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \Sss\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \Sss\Model\Entity\ShopOrder[] $shop_orders
 * @property \Sss\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \Sss\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \Sss\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \Sss\Model\Entity\ShopPayment[] $shop_payments
 * @property \Sss\Model\Entity\ShopProfile[] $shop_profiles
 * @property \Sss\Model\Entity\ShopUseraddress[] $shop_useraddresses
 * @property \Sss\Model\Entity\SmsValidation[] $sms_validations
 * @property \Sss\Model\Entity\UserMeta[] $user_metas
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'family' => true,
        'email' => true,
        'phone' => true,
        'role_id' => true,
        'enable' => true,
        'token' => true,
        'created' => true,
        'modified' => true,
        'role' => true,
        'comments' => true,
        'formbuilder_datas' => true,
        'logs' => true,
        'poll_votes' => true,
        'posts' => true,
        'profiles' => true,
        'shop_addresses' => true,
        'shop_favorites' => true,
        'shop_logesticusers' => true,
        'shop_orderlogesticlogs' => true,
        'shop_orderlogestics' => true,
        'shop_orderlogs' => true,
        'shop_orderrefunds' => true,
        'shop_orders' => true,
        'shop_ordershippings' => true,
        'shop_ordertexts' => true,
        'shop_ordertokens' => true,
        'shop_payments' => true,
        'shop_profiles' => true,
        'shop_useraddresses' => true,
        'sms_validations' => true,
        'user_metas' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
        'token',
    ];
}
