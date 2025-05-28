<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCoursefilenote Entity
 *
 * @property int $id
 * @property int $lms_coursefile_id
 * @property int $types
 * @property string|null $descr
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\LmsCoursefile $lms_coursefile
 */
class LmsCoursefilenote extends Entity
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
        'lms_coursefile_id' => true,
        'types' => true,
        'descr' => true,
        'created' => true,
        'lms_coursefile' => true,
    ];
}
