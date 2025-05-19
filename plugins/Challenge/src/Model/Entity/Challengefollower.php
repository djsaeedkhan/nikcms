<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengefollower Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenDate $created
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 * @property \Challenge\Model\Entity\User $user
 */
class Challengefollower extends Entity
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
        'challenge_id' => true,
        'user_id' => true,
        'created' => true,
        'challenge' => true,
        'user' => true,
    ];
}
