<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengeforumtitle Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property string $title
 * @property string|null $descr
 * @property int $priority
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 * @property \Challenge\Model\Entity\Challengeforum[] $challengeforums
 */
class Challengeforumtitle extends Entity
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
        'title' => true,
        'descr' => true,
        'priority' => true,
        'challenge' => true,
        'challengeforums' => true,
    ];
}
