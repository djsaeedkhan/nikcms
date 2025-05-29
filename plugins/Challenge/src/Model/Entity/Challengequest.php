<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengequest Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property int $types
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $description
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property int|null $priority
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 * @property \Challenge\Model\Entity\ParentChallengequest $parent_challengequest
 * @property \Challenge\Model\Entity\Challengeqanswer[] $challengeqanswers
 * @property \Challenge\Model\Entity\ChildChallengequest[] $child_challengequests
 */
class Challengequest extends Entity
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
        'types' => true,
        'title' => true,
        'slug' => true,
        'description' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'priority' => true,
        'created' => true,
        'challenge' => true,
        'parent_challengequest' => true,
        'challengeqanswers' => true,
        'child_challengequests' => true,
    ];
}
