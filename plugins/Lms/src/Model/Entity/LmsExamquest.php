<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsExamquest Entity
 *
 * @property int $id
 * @property int $lms_exam_id
 * @property string $title
 * @property string|null $images
 * @property int $priority
 * @property bool $types
 * @property string|null $q1
 * @property string|null $q2
 * @property string|null $q3
 * @property string|null $q4
 * @property string|null $q5
 * @property int|null $correct
 *
 * @property \Lms\Model\Entity\LmsExam $lms_exam
 * @property \Lms\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 */
class LmsExamquest extends Entity
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
        'lms_exam_id' => true,
        'title' => true,
        'images' => true,
        'priority' => true,
        'types' => true,
        'q1' => true,
        'q2' => true,
        'q3' => true,
        'q4' => true,
        'q5' => true,
        'correct' => true,
        'lms_exam' => true,
        'lms_examresultlists' => true,
    ];
}
