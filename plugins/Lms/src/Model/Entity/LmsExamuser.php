<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsExamuser Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $lms_exam_id
 * @property int|null $token
 * @property string|null $final_result
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsExam $lms_exam
 */
class LmsExamuser extends Entity
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
        'token' => true,
        'final_result' => true,
        'created' => true,
        'user' => true,
        'lms_exam' => true,
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
