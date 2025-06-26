<?php
declare(strict_types=1);

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
 * @property \Lms\Model\Entity\Post[] $posts
 * @property \Lms\Model\Entity\Profile[] $profiles
 * @property \Lms\Model\Entity\SmsValidation[] $sms_validations
 * @property \Lms\Model\Entity\Ticketaudit[] $ticketaudits
 * @property \Lms\Model\Entity\Ticketcomment[] $ticketcomments
 * @property \Lms\Model\Entity\Ticket[] $tickets
 * @property \Lms\Model\Entity\UserMeta[] $user_metas
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
     * @var array<string>
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
