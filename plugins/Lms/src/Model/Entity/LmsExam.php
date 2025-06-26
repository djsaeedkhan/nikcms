<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsExam Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $descr
 * @property int|null $timer
 * @property int|null $reexam
 * @property int $fail_count
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsCourseexam[] $lms_courseexams
 * @property \Lms\Model\Entity\LmsExamquest[] $lms_examquests
 * @property \Lms\Model\Entity\LmsExamresultlist[] $lms_examresultlists
 * @property \Lms\Model\Entity\LmsExamresult[] $lms_examresults
 * @property \Lms\Model\Entity\LmsExamuser[] $lms_examusers
 */
class LmsExam extends Entity
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
        'title' => true,
        'descr' => true,
        'timer' => true,
        'reexam' => true,
        'fail_count' => true,
        'user_id' => true,
        'options' => true,
        'created' => true,
        'user' => true,
        'lms_courseexams' => true,
        'lms_examquests' => true,
        'lms_examresultlists' => true,
        'lms_examresults' => true,
        'lms_examusers' => true,
    ];

    protected $_virtual = ['myoptions'];
    protected function _getmyoptions($options){
        if($this->options != ""){
            return json_decode($this->options,true);
        }
    }

}
