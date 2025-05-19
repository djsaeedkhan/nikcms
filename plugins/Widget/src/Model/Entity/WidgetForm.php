<?php
namespace Widget\Model\Entity;

use Cake\ORM\Entity;

/**
 * WidgetForm Entity
 *
 * @property int $id
 * @property int $widgets_id
 * @property string $title
 * @property string $data
 *
 * @property \Widget\Model\Entity\Widget $widget
 */
class WidgetForm extends Entity
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
        '*' => true,
        //'title' => true,
        //'data' => true,
        //'widget' => true
    ];
}
