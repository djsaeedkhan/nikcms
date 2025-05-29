<?php
declare(strict_types=1);

namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengeview Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property int $views
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 */
class Challengeview extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'challenge_id' => true,
        'views' => true,
        'challenge' => true,
    ];
}
