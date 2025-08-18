<?php
namespace Admin\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
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
 * @property \Admin\Model\Entity\Role $role
 * @property \Admin\Model\Entity\Comment[] $comments
 * @property \Admin\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \Admin\Model\Entity\Log[] $logs
 * @property \Admin\Model\Entity\PollVote[] $poll_votes
 * @property \Admin\Model\Entity\Post[] $posts
 * @property \Admin\Model\Entity\Profile[] $profiles
 * @property \Admin\Model\Entity\SmsValidation[] $sms_validations
 * @property \Admin\Model\Entity\UserMeta[] $user_metas
 */
class User extends Entity
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
        'expired' => true,
        'role' => true,
        'challengeblueticks' => true,
        'challengefollowers' => true,
        'challengeforums' => true,
        'challengeqanswers' => true,
        'challenges' => true,
        'challengeuserforms' => true,
        'challengeuserprofiles' => true,
        'comments' => true,
        'formbuilder_datas' => true,
        'lms_coursefilecans' => true,
        'lms_courses' => true,
        'lms_coursesessions' => true,
        'lms_courseusers' => true,
        'lms_examresultlists' => true,
        'lms_examresults' => true,
        'lms_exams' => true,
        'lms_examusers' => true,
        'lms_factors' => true,
        'lms_payments' => true,
        'lms_userfactors' => true,
        'lms_usernotes' => true,
        'lms_userprofiles' => true,
        'logs' => true,
        'poll_votes' => true,
        'posts' => true,
        'profiles' => true,
        'shop_addresses' => true,
        'shop_favorites' => true,
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
        'ticketaudits' => true,
        'ticketcomments' => true,
        'tickets' => true,
        'tmp_challengeforms' => true,
        'tmp_members' => true,
        'tmp_personlikes' => true,
        'tmp_persons' => true,
        'tmp_problemforms' => true,
        'tmp_problems' => true,
        'user_metas' => true,
        'challengetags' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'token',
    ];

    /* protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    } */
}
