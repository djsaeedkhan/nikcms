<?php
namespace Ticketing\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticketcomment Entity
 *
 * @property int $id
 * @property string|null $content
 * @property int $user_id
 * @property int $ticket_id
 * @property \Cake\I18n\FrozenTime $created
 * @property string|null $filename
 * @property string|null $filesrc
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Ticketing\Model\Entity\User $user
 * @property \Ticketing\Model\Entity\Ticket $ticket
 */
class Ticketcomment extends Entity
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
        'content' => true,
        'user_id' => true,
        'ticket_id' => true,
        'created' => true,
        'filename' => true,
        'filesrc' => true,
        'modified' => true,
        'user' => true,
        'ticket' => true,
    ];
}
