<?php
declare(strict_types=1);

namespace SSS\Model\Entity;

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
 * @property \Cake\I18n\FrozenTime|null $expired
 *
 * @property \SSS\Model\Entity\Role $role
 * @property \SSS\Model\Entity\Challengebluetick[] $challengeblueticks
 * @property \SSS\Model\Entity\Challengefollower[] $challengefollowers
 * @property \SSS\Model\Entity\Challengeforum[] $challengeforums
 * @property \SSS\Model\Entity\Challengeqanswer[] $challengeqanswers
 * @property \SSS\Model\Entity\Challenge[] $challenges
 * @property \SSS\Model\Entity\Challengeuserform[] $challengeuserforms
 * @property \SSS\Model\Entity\Challengeuserprofile[] $challengeuserprofiles
 * @property \SSS\Model\Entity\Comment[] $comments
 * @property \SSS\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \SSS\Model\Entity\LmsCertificate[] $lms_certificates
 * @property \SSS\Model\Entity\LmsCoursefilecan[] $lms_coursefilecans
 * @property \SSS\Model\Entity\LmsCourse[] $lms_courses
 * @property \SSS\Model\Entity\LmsCoursesession[] $lms_coursesessions
 * @property \SSS\Model\Entity\LmsCourseuser[] $lms_courseusers
 * @property \SSS\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 * @property \SSS\Model\Entity\LmsExamresult[] $lms_examresults
 * @property \SSS\Model\Entity\LmsExam[] $lms_exams
 * @property \SSS\Model\Entity\LmsExamuser[] $lms_examusers
 * @property \SSS\Model\Entity\LmsFactor[] $lms_factors
 * @property \SSS\Model\Entity\LmsPayment[] $lms_payments
 * @property \SSS\Model\Entity\LmsUserfactor[] $lms_userfactors
 * @property \SSS\Model\Entity\LmsUsernote[] $lms_usernotes
 * @property \SSS\Model\Entity\LmsUserprofile[] $lms_userprofiles
 * @property \SSS\Model\Entity\Log[] $logs
 * @property \SSS\Model\Entity\PollVote[] $poll_votes
 * @property \SSS\Model\Entity\Post[] $posts
 * @property \SSS\Model\Entity\Profile[] $profiles
 * @property \SSS\Model\Entity\ShopAddress[] $shop_addresses
 * @property \SSS\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \SSS\Model\Entity\ShopLogesticuser[] $shop_logesticusers
 * @property \SSS\Model\Entity\ShopOrderlogesticlog[] $shop_orderlogesticlogs
 * @property \SSS\Model\Entity\ShopOrderlogestic[] $shop_orderlogestics
 * @property \SSS\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \SSS\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \SSS\Model\Entity\ShopOrder[] $shop_orders
 * @property \SSS\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \SSS\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \SSS\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \SSS\Model\Entity\ShopPayment[] $shop_payments
 * @property \SSS\Model\Entity\ShopProfile[] $shop_profiles
 * @property \SSS\Model\Entity\ShopUseraddress[] $shop_useraddresses
 * @property \SSS\Model\Entity\SmsValidation[] $sms_validations
 * @property \SSS\Model\Entity\Ticketaudit[] $ticketaudits
 * @property \SSS\Model\Entity\Ticketcomment[] $ticketcomments
 * @property \SSS\Model\Entity\Ticket[] $tickets
 * @property \SSS\Model\Entity\TmpChallengeform[] $tmp_challengeforms
 * @property \SSS\Model\Entity\TmpMember[] $tmp_members
 * @property \SSS\Model\Entity\TmpPersonlike[] $tmp_personlikes
 * @property \SSS\Model\Entity\TmpPerson[] $tmp_persons
 * @property \SSS\Model\Entity\TmpProblemform[] $tmp_problemforms
 * @property \SSS\Model\Entity\TmpProblem[] $tmp_problems
 * @property \SSS\Model\Entity\UserMeta[] $user_metas
 * @property \SSS\Model\Entity\Challengetag[] $challengetags
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
        'lms_certificates' => true,
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
     * @var array<string>
     */
    protected $_hidden = [
        'password',
        'token',
    ];
}
