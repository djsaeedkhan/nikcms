<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsCoursecategory Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $descr
 * @property string|null $image
 * @property int|null $priority
 * @property string|null $descr1
 * @property string|null $descr2
 * @property string|null $descr3
 * @property string|null $button
 * @property \Cake\I18n\FrozenTime $created
 */
class LmsCoursecategory extends Entity
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
        'descr' => true,
        'image' => true,
        'priority' => true,
        'descr1' => true,
        'descr2' => true,
        'descr3' => true,
        'button' => true,
        'created' => true,
    ];
}
