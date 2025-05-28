<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\Translate\TranslateTrait;

/**
 * Option Entity
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $types
 * @property int $autoload
 */
class Toption extends Entity
{
    use TranslateTrait;

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
        '*' => true,
    ];
}
