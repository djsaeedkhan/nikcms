<?php
namespace Ticketing\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticketstatus Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $color
 *
 * @property \Ticketing\Model\Entity\Ticket[] $tickets
 */
class Ticketstatus extends Entity
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
        'title' => true,
        'color' => true,
        'tickets' => true,
    ];
}
