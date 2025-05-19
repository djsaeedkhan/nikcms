<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCoursesession Entity
 *
 * @property int $id
 * @property int|null $lms_course_id
 * @property int|null $lms_courseweek_id
 * @property int|null $lms_coursefile_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 * @property \Lms\Model\Entity\LmsCourseweek $lms_courseweek
 * @property \Lms\Model\Entity\LmsCoursefile $lms_coursefile
 * @property \Lms\Model\Entity\User $user
 */
class LmsCoursesession extends Entity
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
        'lms_course_id' => true,
        'lms_courseweek_id' => true,
        'lms_coursefile_id' => true,
        'user_id' => true,
        'created' => true,
        'lms_course' => true,
        'lms_courseweek' => true,
        'lms_coursefile' => true,
        'user' => true,
    ];
}
