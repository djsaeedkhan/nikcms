<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengeforum Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property int $challengeforumtitle_id
 * @property int $lft
 * @property int $rght
 * @property int|null $user_id
 * @property string $text
 * @property bool $enable
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 * @property \Challenge\Model\Entity\Challengeforumtitle $challengeforumtitle
 * @property \Challenge\Model\Entity\User $user
 */
class Challengeforum extends Entity
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
        'challengeforumtitle_id' => true,
        'lft' => true,
        'rght' => true,
        'user_id' => true,
        'text' => true,
        'enable' => true,
        'created' => true,
        'challenge' => true,
        'challengeforumtitle' => true,
        'user' => true,
    ];
}
