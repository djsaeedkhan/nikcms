<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsExamresultlist Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $lms_examresult_id
 * @property int $lms_exam_id
 * @property int $lms_examquest_id
 * @property int|null $token
 * @property string $answer
 * @property int|null $result
 * @property string|null $filesrc
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsExamresult $lms_examresult
 * @property \Lms\Model\Entity\LmsExam $lms_exam
 * @property \Lms\Model\Entity\LmsExamquest $lms_examquest
 */
class LmsExamresultlist extends Entity
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
        'user_id' => true,
        'lms_examresult_id' => true,
        'lms_exam_id' => true,
        'lms_examquest_id' => true,
        'token' => true,
        'answer' => true,
        'result' => true,
        'filesrc' => true,
        'created' => true,
        'user' => true,
        'lms_examresult' => true,
        'lms_exam' => true,
        'lms_examquest' => true,
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
