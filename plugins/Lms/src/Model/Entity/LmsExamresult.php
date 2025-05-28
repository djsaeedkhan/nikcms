<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsExamresult Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $lms_exam_id
 * @property int|null $lms_coursefile_id
 * @property string|null $token
 * @property int|null $result
 * @property string|null $descr
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsExam $lms_exam
 * @property \Lms\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 */
class LmsExamresult extends Entity
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
        'lms_exam_id' => true,
        'lms_coursefile_id' => true,
        'token' => true,
        'result' => true,
        'descr' => true,
        'created' => true,
        'user' => true,
        'lms_exam' => true,
        'lms_examresultlists' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
