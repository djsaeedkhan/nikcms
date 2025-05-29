<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengeqanswer Entity
 *
 * @property int $id
 * @property int|null $challenge_id
 * @property int|null $user_id
 * @property int $challengequest_id
 * @property string|null $value
 * @property string $types
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 * @property \Challenge\Model\Entity\User $user
 * @property \Challenge\Model\Entity\Challengequest $challengequest
 */
class Challengeqanswer extends Entity
{
    /**
     * Fields that can be mass assigned using newEmptyEntity() or patchEntity().
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
        'challengequest_id' => true,
        'value' => true,
        'types' => true,
        'challenge' => true,
        'user' => true,
        'challengequest' => true,
    ];
}
