<?php
namespace Ticketing\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticketpriority Entity
 *
 * @property int $id
 * @property string $title
 * @property int $color
 *
 * @property \Ticketing\Model\Entity\Ticket[] $tickets
 */
class Ticketpriority extends Entity
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
        'color' => true,
        'tickets' => true,
    ];
}
