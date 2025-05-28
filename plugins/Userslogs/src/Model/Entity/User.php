<?php
namespace UsersLogs\Model\Entity;

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
 * @property \UsersLogs\Model\Entity\Role $role
 * @property \UsersLogs\Model\Entity\Challengebluetick[] $challengeblueticks
 * @property \UsersLogs\Model\Entity\Challengefollower[] $challengefollowers
 * @property \UsersLogs\Model\Entity\Challengeforum[] $challengeforums
 * @property \UsersLogs\Model\Entity\Challengeqanswer[] $challengeqanswers
 * @property \UsersLogs\Model\Entity\Challenge[] $challenges
 * @property \UsersLogs\Model\Entity\Challengeuserform[] $challengeuserforms
 * @property \UsersLogs\Model\Entity\Challengeuserprofile[] $challengeuserprofiles
 * @property \UsersLogs\Model\Entity\Comment[] $comments
 * @property \UsersLogs\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \UsersLogs\Model\Entity\LmsCoursefilecan[] $lms_coursefilecans
 * @property \UsersLogs\Model\Entity\LmsCourse[] $lms_courses
 * @property \UsersLogs\Model\Entity\LmsCoursesession[] $lms_coursesessions
 * @property \UsersLogs\Model\Entity\LmsCourseuser[] $lms_courseusers
 * @property \UsersLogs\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 * @property \UsersLogs\Model\Entity\LmsExamresult[] $lms_examresults
 * @property \UsersLogs\Model\Entity\LmsExam[] $lms_exams
 * @property \UsersLogs\Model\Entity\LmsExamuser[] $lms_examusers
 * @property \UsersLogs\Model\Entity\LmsFactor[] $lms_factors
 * @property \UsersLogs\Model\Entity\LmsPayment[] $lms_payments
 * @property \UsersLogs\Model\Entity\LmsUserfactor[] $lms_userfactors
 * @property \UsersLogs\Model\Entity\LmsUsernote[] $lms_usernotes
 * @property \UsersLogs\Model\Entity\LmsUserprofile[] $lms_userprofiles
 * @property \UsersLogs\Model\Entity\Log[] $logs
 * @property \UsersLogs\Model\Entity\PollVote[] $poll_votes
 * @property \UsersLogs\Model\Entity\Post[] $posts
 * @property \UsersLogs\Model\Entity\Profile[] $profiles
 * @property \UsersLogs\Model\Entity\ShopAddress[] $shop_addresses
 * @property \UsersLogs\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \UsersLogs\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \UsersLogs\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \UsersLogs\Model\Entity\ShopOrder[] $shop_orders
 * @property \UsersLogs\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \UsersLogs\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \UsersLogs\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \UsersLogs\Model\Entity\ShopPayment[] $shop_payments
 * @property \UsersLogs\Model\Entity\ShopProfile[] $shop_profiles
 * @property \UsersLogs\Model\Entity\ShopUseraddress[] $shop_useraddresses
 * @property \UsersLogs\Model\Entity\SmsValidation[] $sms_validations
 * @property \UsersLogs\Model\Entity\Ticketaudit[] $ticketaudits
 * @property \UsersLogs\Model\Entity\Ticketcomment[] $ticketcomments
 * @property \UsersLogs\Model\Entity\Ticket[] $tickets
 * @property \UsersLogs\Model\Entity\TmpChallengeform[] $tmp_challengeforms
 * @property \UsersLogs\Model\Entity\TmpMember[] $tmp_members
 * @property \UsersLogs\Model\Entity\TmpPersonlike[] $tmp_personlikes
 * @property \UsersLogs\Model\Entity\TmpPerson[] $tmp_persons
 * @property \UsersLogs\Model\Entity\TmpProblemform[] $tmp_problemforms
 * @property \UsersLogs\Model\Entity\TmpProblem[] $tmp_problems
 * @property \UsersLogs\Model\Entity\UserMeta[] $user_metas
 * @property \UsersLogs\Model\Entity\Challengetag[] $challengetags
 */
class User extends Entity
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
}
