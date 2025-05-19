<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCoursefilecan Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $lms_course_id
 * @property int $lms_coursefile_id
 * @property bool $enable
 * @property bool $types
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 * @property \Lms\Model\Entity\LmsCoursefile $lms_coursefile
 */
class LmsCoursefilecan extends Entity
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
        'user_id' => true,
        'lms_course_id' => true,
        'lms_coursefile_id' => true,
        'enable' => true,
        'types' => true,
        'created' => true,
        'user' => true,
        'lms_course' => true,
        'lms_coursefile' => true,
    ];
}
