<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengerelated Entity
 *
 * @property int $id
 * @property int|null $challenge_id
 * @property int|null $challenges_id
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 */
class Challengerelated extends Entity
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
        'challenges_id' => true,
        'challenge' => true,
    ];
}
