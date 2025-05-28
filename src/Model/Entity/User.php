<?php
declare(strict_types=1);

namespace App\Model\Entity;

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
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \App\Model\Entity\Log[] $logs
 * @property \App\Model\Entity\PollVote[] $poll_votes
 * @property \App\Model\Entity\Post[] $posts
 * @property \App\Model\Entity\Profile[] $profiles
 * @property \App\Model\Entity\ShopAddress[] $shop_addresses
 * @property \App\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \App\Model\Entity\ShopLogesticuser[] $shop_logesticusers
 * @property \App\Model\Entity\ShopOrderlogesticlog[] $shop_orderlogesticlogs
 * @property \App\Model\Entity\ShopOrderlogestic[] $shop_orderlogestics
 * @property \App\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \App\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \App\Model\Entity\ShopOrder[] $shop_orders
 * @property \App\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \App\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \App\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \App\Model\Entity\ShopPayment[] $shop_payments
 * @property \App\Model\Entity\ShopProfile[] $shop_profiles
 * @property \App\Model\Entity\ShopUseraddress[] $shop_useraddresses
 * @property \App\Model\Entity\SmsValidation[] $sms_validations
 * @property \App\Model\Entity\UserMeta[] $user_metas
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
        'posts' => true,
        'profiles' => true,
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
