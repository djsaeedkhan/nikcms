<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCourseexam Entity
 *
 * @property int $id
 * @property int $lms_course_id
 * @property int $lms_coursefile_id
 * @property int $lms_exam_id
 * @property bool|null $on_success
 *
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 * @property \Lms\Model\Entity\LmsCoursefile $lms_coursefile
 * @property \Lms\Model\Entity\LmsExam $lms_exam
 */
class LmsCourseexam extends Entity
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
        'lms_coursefile_id' => true,
        'lms_exam_id' => true,
        'on_success' => true,
        'lms_course' => true,
        'lms_coursefile' => true,
        'lms_exam' => true,
    ];
}
