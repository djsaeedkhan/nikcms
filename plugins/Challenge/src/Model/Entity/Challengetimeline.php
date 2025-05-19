<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengetimeline Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property string $title
 * @property int $types
 * @property \Cake\I18n\FrozenTime $dates
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 */
class Challengetimeline extends Entity
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
        'title' => true,
        'types' => true,
        'dates' => true,
        'challenge' => true,
    ];
}
