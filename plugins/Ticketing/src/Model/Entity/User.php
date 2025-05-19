<?php
namespace Ticketing\Model\Entity;

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
 * @property \Ticketing\Model\Entity\Role $role
 * @property \Ticketing\Model\Entity\Challengebluetick[] $challengeblueticks
 * @property \Ticketing\Model\Entity\Challengefollower[] $challengefollowers
 * @property \Ticketing\Model\Entity\Challengeforum[] $challengeforums
 * @property \Ticketing\Model\Entity\Challengeqanswer[] $challengeqanswers
 * @property \Ticketing\Model\Entity\Challenge[] $challenges
 * @property \Ticketing\Model\Entity\Challengeuserform[] $challengeuserforms
 * @property \Ticketing\Model\Entity\Challengeuserprofile[] $challengeuserprofiles
 * @property \Ticketing\Model\Entity\Comment[] $comments
 * @property \Ticketing\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \Ticketing\Model\Entity\LmsCoursefilecan[] $lms_coursefilecans
 * @property \Ticketing\Model\Entity\LmsCourse[] $lms_courses
 * @property \Ticketing\Model\Entity\LmsCoursesession[] $lms_coursesessions
 * @property \Ticketing\Model\Entity\LmsCourseuser[] $lms_courseusers
 * @property \Ticketing\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 * @property \Ticketing\Model\Entity\LmsExamresult[] $lms_examresults
 * @property \Ticketing\Model\Entity\LmsExam[] $lms_exams
 * @property \Ticketing\Model\Entity\LmsExamuser[] $lms_examusers
 * @property \Ticketing\Model\Entity\LmsFactor[] $lms_factors
 * @property \Ticketing\Model\Entity\LmsPayment[] $lms_payments
 * @property \Ticketing\Model\Entity\LmsUserfactor[] $lms_userfactors
 * @property \Ticketing\Model\Entity\LmsUsernote[] $lms_usernotes
 * @property \Ticketing\Model\Entity\LmsUserprofile[] $lms_userprofiles
 * @property \Ticketing\Model\Entity\Log[] $logs
 * @property \Ticketing\Model\Entity\PollVote[] $poll_votes
 * @property \Ticketing\Model\Entity\Post[] $posts
 * @property \Ticketing\Model\Entity\Profile[] $profiles
 * @property \Ticketing\Model\Entity\ShopAddress[] $shop_addresses
 * @property \Ticketing\Model\Entity\ShopFavorite[] $shop_favorites
 * @property \Ticketing\Model\Entity\ShopOrderlog[] $shop_orderlogs
 * @property \Ticketing\Model\Entity\ShopOrderrefund[] $shop_orderrefunds
 * @property \Ticketing\Model\Entity\ShopOrder[] $shop_orders
 * @property \Ticketing\Model\Entity\ShopOrdershipping[] $shop_ordershippings
 * @property \Ticketing\Model\Entity\ShopOrdertext[] $shop_ordertexts
 * @property \Ticketing\Model\Entity\ShopOrdertoken[] $shop_ordertokens
 * @property \Ticketing\Model\Entity\ShopPayment[] $shop_payments
 * @property \Ticketing\Model\Entity\ShopProfile[] $shop_profiles
 * @property \Ticketing\Model\Entity\ShopUseraddress[] $shop_useraddresses
 * @property \Ticketing\Model\Entity\SmsValidation[] $sms_validations
 * @property \Ticketing\Model\Entity\Ticketaudit[] $ticketaudits
 * @property \Ticketing\Model\Entity\Ticketcomment[] $ticketcomments
 * @property \Ticketing\Model\Entity\Ticket[] $tickets
 * @property \Ticketing\Model\Entity\TmpChallengeform[] $tmp_challengeforms
 * @property \Ticketing\Model\Entity\TmpMember[] $tmp_members
 * @property \Ticketing\Model\Entity\TmpPersonlike[] $tmp_personlikes
 * @property \Ticketing\Model\Entity\TmpPerson[] $tmp_persons
 * @property \Ticketing\Model\Entity\TmpProblemform[] $tmp_problemforms
 * @property \Ticketing\Model\Entity\TmpProblem[] $tmp_problems
 * @property \Ticketing\Model\Entity\UserMeta[] $user_metas
 * @property \Ticketing\Model\Entity\Challengetag[] $challengetags
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
        'comments' => true,
        'logs' => true,
        'poll_votes' => true,
        'posts' => true,
        'profiles' => true,
        'sms_validations' => true,
        'ticketaudits' => true,
        'ticketcomments' => true,
        'tickets' => true,
        'user_metas' => true,
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
