<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCourserelated Entity
 *
 * @property int $id
 * @property int $lms_course_id
 * @property int $lms_course_ids
 * @property int $types
 *
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 */
class LmsCourserelated extends Entity
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
        'lms_course_id' => true,
        'lms_course_ids' => true,
        'types' => true,
        'lms_course' => true,
        'LmsCoursess'=> true
    ];
}
