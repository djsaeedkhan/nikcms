<?php
namespace Challenge\Model\Entity;

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
 * @property \Challenge\Model\Entity\Role $role
 * @property \Challenge\Model\Entity\Challengebluetick[] $challengeblueticks
 * @property \Challenge\Model\Entity\Challengefollower[] $challengefollowers
 * @property \Challenge\Model\Entity\Challengeforum[] $challengeforums
 * @property \Challenge\Model\Entity\Challengeqanswer[] $challengeqanswers
 * @property \Challenge\Model\Entity\Challenge[] $challenges
 * @property \Challenge\Model\Entity\Challengeuserform[] $challengeuserforms
 * @property \Challenge\Model\Entity\Challengeuserprofile[] $challengeuserprofiles
 * @property \Challenge\Model\Entity\Comment[] $comments
 * @property \Challenge\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \Challenge\Model\Entity\LmsCoursefilecan[] $lms_coursefilecans
 * @property \Challenge\Model\Entity\LmsCourse[] $lms_courses
 * @property \Challenge\Model\Entity\LmsCoursesession[] $lms_coursesessions
 * @property \Challenge\Model\Entity\LmsCourseuser[] $lms_courseusers
 * @property \Challenge\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 * @property \Challenge\Model\Entity\LmsExamresult[] $lms_examresults
 * @property \Challenge\Model\Entity\LmsExam[] $lms_exams
 * @property \Challenge\Model\Entity\LmsExamuser[] $lms_examusers
 * @property \Challenge\Model\Entity\LmsUsernote[] $lms_usernotes
 * @property \Challenge\Model\Entity\LmsUserprofile[] $lms_userprofiles
 * @property \Challenge\Model\Entity\Log[] $logs
 * @property \Challenge\Model\Entity\PollVote[] $poll_votes
 * @property \Challenge\Model\Entity\Post[] $posts
 * @property \Challenge\Model\Entity\Profile[] $profiles
 * @property \Challenge\Model\Entity\ShopAddress[] $shop_addresses
 * @property \Challenge\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \Challenge\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \Challenge\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \Challenge\Model\Entity\ShopOrder[] $shop_orders
 * @property \Challenge\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \Challenge\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \Challenge\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \Challenge\Model\Entity\ShopPayment[] $shop_payments
 * @property \Challenge\Model\Entity\ShopProfile[] $shop_profiles
 * @property \Challenge\Model\Entity\ShopUseraddress[] $shop_useraddresses
 * @property \Challenge\Model\Entity\SmsValidation[] $sms_validations
 * @property \Challenge\Model\Entity\Ticketaudit[] $ticketaudits
 * @property \Challenge\Model\Entity\Ticketcomment[] $ticketcomments
 * @property \Challenge\Model\Entity\Ticket[] $tickets
 * @property \Challenge\Model\Entity\TmpChallengeform[] $tmp_challengeforms
 * @property \Challenge\Model\Entity\TmpMember[] $tmp_members
 * @property \Challenge\Model\Entity\TmpPersonlike[] $tmp_personlikes
 * @property \Challenge\Model\Entity\TmpPerson[] $tmp_persons
 * @property \Challenge\Model\Entity\TmpProblemform[] $tmp_problemforms
 * @property \Challenge\Model\Entity\TmpProblem[] $tmp_problems
 * @property \Challenge\Model\Entity\UserMeta[] $user_metas
 * @property \Challenge\Model\Entity\Challengetag[] $challengetags
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
