<?php
declare(strict_types=1);

namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengestatus Entity
 *
 * @property int $id
 * @property string $title
 *
 * @property \Challenge\Model\Entity\Challenge[] $challenges
 */
class Challengestatus extends Entity
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
        'title' => true,
        'challenges' => true,
    ];
}
