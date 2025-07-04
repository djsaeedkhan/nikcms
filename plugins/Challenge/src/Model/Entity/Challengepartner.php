<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengepartner Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property string|null $title
 * @property string|null $link
 * @property string|null $image
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 */
class Challengepartner extends Entity
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
        'link' => true,
        'image' => true,
        'challenge' => true,
    ];
}
