<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsUserfactor Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $lms_factor_id
 * @property int $lms_course_id
 * @property int|null $user_ids
 * @property bool $enable
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsFactor $lms_factor
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 */
class LmsUserfactor extends Entity
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
        'lms_factor_id' => true,
        'lms_course_id' => true,
        'lms_exam_id' => true,
        'user_ids' => true,
        'enable' => true,
        'created' => true,
        'user' => true,
        'lms_factor' => true,
        'lms_course' => true,
        'lms_exam' => true,
    ];
}
