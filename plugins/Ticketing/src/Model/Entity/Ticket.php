<?php
namespace Ticketing\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticket Entity
 *
 * @property int $id
 * @property string $subject
 * @property string|null $content
 * @property string|null $html
 * @property int|null $ticketstatus_id
 * @property int|null $ticketpriority_id
 * @property int $user_id
 * @property int|null $agent_id
 * @property int|null $post_id
 * @property string|null $phone_number
 * @property int|null $alert_type
 * @property string|null $email
 * @property int|null $ticketcategory_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime|null $completed
 *
 * @property \Ticketing\Model\Entity\Ticketstatus $ticketstatus
 * @property \Ticketing\Model\Entity\Ticketpriority $ticketpriority
 * @property \Ticketing\Model\Entity\User $user
 * @property \Ticketing\Model\Entity\Agent $agent
 * @property \Ticketing\Model\Entity\Post $post
 * @property \Ticketing\Model\Entity\Ticketcategory $ticketcategory
 * @property \Ticketing\Model\Entity\Ticketaudit[] $ticketaudits
 * @property \Ticketing\Model\Entity\Ticketcomment[] $ticketcomments
 */
class Ticket extends Entity
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
        'subject' => true,
        'content' => true,
        'html' => true,
        'ticketstatus_id' => true,
        'ticketpriority_id' => true,
        'user_id' => true,
        'agent_id' => true,
        'post_id' => true,
        'phone_number' => true,
        'alert_type' => true,
        'email' => true,
        'ticketcategory_id' => true,
        'created' => true,
        'modified' => true,
        'completed' => true,
        'ticketstatus' => true,
        'ticketpriority' => true,
        'user' => true,
        'agent' => true,
        'post' => true,
        'ticketcategory' => true,
        'ticketaudits' => true,
        'ticketcomments' => true,
    ];
}
