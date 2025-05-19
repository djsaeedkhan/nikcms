<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCoursefile Entity
 *
 * @property int $id
 * @property string|null $title
 * @property int $lms_course_id
 * @property int $lms_courseweek_id
 * @property int $days
 * @property string|null $filesrc_1
 * @property string|null $filesrc_2
 * @property string|null $filesrc_3
 * @property string|null $filesrc_4
 * @property string|null $filesrc_extra
 * @property string|null $content
 * @property int|null $priority
 * @property string|null $image
 * @property bool $enable
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 * @property \Lms\Model\Entity\LmsCourseweek $lms_courseweek
 * @property \Lms\Model\Entity\LmsCourseexam[] $lms_courseexams
 * @property \Lms\Model\Entity\LmsCoursefilecan[] $lms_coursefilecans
 * @property \Lms\Model\Entity\LmsCoursefilenote[] $lms_coursefilenotes
 * @property \Lms\Model\Entity\LmsCoursesession[] $lms_coursesessions
 * @property \Lms\Model\Entity\LmsExamresult[] $lms_examresults
 * @property \Lms\Model\Entity\LmsUsernote[] $lms_usernotes
 */
class LmsCoursefile extends Entity
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
        'title' => true,
        'lms_course_id' => true,
        'lms_courseweek_id' => true,
        'show_in_list' => true,
        'days' => true,
        'filesrc_1' => true,
        'filesrc_2' => true,
        'filesrc_3' => true,
        'filesrc_4' => true,
        'filesrc_extra' => true,
        'preview'=>true,
        'content' => true,
        'top_content' => true,
        'priority' => true,
        'total_time' => true,
        'image' => true,
        'enable' => true,
        'created' => true,
        'lms_course' => true,
        'lms_courseweek' => true,
        'lms_courseexams' => true,
        'lms_coursefilecans' => true,
        'lms_coursefilenotes' => true,
        'lms_coursesessions' => true,
        'lms_examresults' => true,
        'lms_usernotes' => true,
    ];
}
