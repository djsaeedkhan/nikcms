<?php
namespace Lms\Model\Entity;

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
 * @property \Lms\Model\Entity\Role $role
 * @property \Lms\Model\Entity\Challengebluetick[] $challengeblueticks
 * @property \Lms\Model\Entity\Challengefollower[] $challengefollowers
 * @property \Lms\Model\Entity\Challengeforum[] $challengeforums
 * @property \Lms\Model\Entity\Challengeqanswer[] $challengeqanswers
 * @property \Lms\Model\Entity\Challenge[] $challenges
 * @property \Lms\Model\Entity\Challengeuserform[] $challengeuserforms
 * @property \Lms\Model\Entity\Challengeuserprofile[] $challengeuserprofiles
 * @property \Lms\Model\Entity\Comment[] $comments
 * @property \Lms\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \Lms\Model\Entity\LmsCoursefilecan[] $lms_coursefilecans
 * @property \Lms\Model\Entity\LmsCourse[] $lms_courses
 * @property \Lms\Model\Entity\LmsCoursesession[] $lms_coursesessions
 * @property \Lms\Model\Entity\LmsCourseuser[] $lms_courseusers
 * @property \Lms\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 * @property \Lms\Model\Entity\LmsExamresult[] $lms_examresults
 * @property \Lms\Model\Entity\LmsExam[] $lms_exams
 * @property \Lms\Model\Entity\LmsExamuser[] $lms_examusers
 * @property \Lms\Model\Entity\LmsFactor[] $lms_factors
 * @property \Lms\Model\Entity\LmsPayment[] $lms_payments
 * @property \Lms\Model\Entity\LmsUserfactor[] $lms_userfactors
 * @property \Lms\Model\Entity\LmsUsernote[] $lms_usernotes
 * @property \Lms\Model\Entity\LmsUserprofile[] $lms_userprofiles
 * @property \Lms\Model\Entity\Log[] $logs
 * @property \Lms\Model\Entity\PollVote[] $poll_votes
 * @property \Lms\Model\Entity\Post[] $posts
 * @property \Lms\Model\Entity\Profile[] $profiles
 * @property \Lms\Model\Entity\ShopAddress[] $shop_addresses
 * @property \Lms\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \Lms\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \Lms\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \Lms\Model\Entity\ShopOrder[] $shop_orders
 * @property \Lms\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \Lms\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \Lms\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \Lms\Model\Entity\ShopPayment[] $shop_payments
 * @property \Lms\Model\Entity\ShopProfile[] $shop_profiles
 * @property \Lms\Model\Entity\ShopUseraddress[] $shop_useraddresses
 * @property \Lms\Model\Entity\SmsValidation[] $sms_validations
 * @property \Lms\Model\Entity\Ticketaudit[] $ticketaudits
 * @property \Lms\Model\Entity\Ticketcomment[] $ticketcomments
 * @property \Lms\Model\Entity\Ticket[] $tickets
 * @property \Lms\Model\Entity\TmpChallengeform[] $tmp_challengeforms
 * @property \Lms\Model\Entity\TmpMember[] $tmp_members
 * @property \Lms\Model\Entity\TmpPersonlike[] $tmp_personlikes
 * @property \Lms\Model\Entity\TmpPerson[] $tmp_persons
 * @property \Lms\Model\Entity\TmpProblemform[] $tmp_problemforms
 * @property \Lms\Model\Entity\TmpProblem[] $tmp_problems
 * @property \Lms\Model\Entity\UserMeta[] $user_metas
 * @property \Lms\Model\Entity\Challengetag[] $challengetags
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
        'Fname'=>true
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

    protected function _getFname(){
        return ($this->family!=''?$this->family .' (':'').
                $this->username.
                ($this->family!=''?')':'');
    }
}
