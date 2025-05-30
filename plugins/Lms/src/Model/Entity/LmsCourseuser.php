<?php
declare(strict_types=1);

namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCourseuser Entity
 *
 * @property int $id
 * @property int $lms_course_id
 * @property int $user_id
 * @property int|null $status
 * @property bool $enable
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 * @property \Lms\Model\Entity\User $user
 */
class LmsCourseuser extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'lms_course_id' => true,
        'user_id' => true,
        'status' => true,
        'enable' => true,
        'created' => true,
        'lms_course' => true,
        'user' => true,
    ];
}
