<?php
declare(strict_types=1);

namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Option Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property string|null $types
 * @property int $autoload
 */
class Option extends Entity
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
        'name' => true,
        'value' => true,
        'types' => true,
        'autoload' => true,
    ];
}
