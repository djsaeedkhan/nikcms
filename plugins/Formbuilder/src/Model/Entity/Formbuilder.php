<?php
namespace Formbuilder\Model\Entity;

use Cake\ORM\Entity;

/**
 * Formbuilder Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $passwords
 * @property string|null $action
 * @property string|null $alert
 * @property int $counts
 * @property string|null $emails
 * @property bool|null $enable
 *
 * @property \Formbuilder\Model\Entity\FormbuilderData[] $formbuilder_datas
 * @property \Formbuilder\Model\Entity\FormbuilderItem[] $formbuilder_items
 */
class Formbuilder extends Entity
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
        'passwords' => true,
        'action' => true,
        'alert' => true,
        'counts' => true,
        'emails' => true,
        'enable' => true,
        'formbuilder_datas' => true,
        'formbuilder_items' => true,
    ];
}
