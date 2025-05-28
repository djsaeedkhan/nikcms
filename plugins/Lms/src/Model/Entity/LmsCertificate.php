<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCertificate Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $lms_course_id
 * @property string|null $input_data
 * @property string|null $image
 * @property string|null $download
 * @property int|null $status
 * @property string|null $alert
 * @property bool $enable
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $accepted
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsCourse $lms_course
 */
class LmsCertificate extends Entity
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
        'lms_course_id' => true,
        'input_data' => true,
        'image' => true,
        'download' => true,
        'status' => true,
        'alert' => true,
        'enable' => true,
        'created' => true,
        'accepted' => true,
        'user' => true,
        'lms_course' => true,
    ];
}
