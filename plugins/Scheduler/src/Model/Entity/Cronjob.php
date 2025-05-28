<?php
namespace Scheduler\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cronjob Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $plugin
 * @property int|null $status
 * @property string|null $result
 * @property \Cake\I18n\FrozenTime $created
 */
class Cronjob extends Entity
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
        'name' => true,
        'plugin' => true,
        'status' => true,
        'result' => true,
        'created' => true,
    ];
}
