<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengeimage Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property string|null $title
 * @property string $src
 * @property int|null $types
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 */
class Challengeimage extends Entity
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
        'src' => true,
        'types' => true,
        'challenge' => true,
    ];
}
