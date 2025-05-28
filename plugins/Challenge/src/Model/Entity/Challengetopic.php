<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengetopic Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $img
 * @property string|null $descr
 *
 * @property \Challenge\Model\Entity\Challenge[] $challenges
 */
class Challengetopic extends Entity
{
    /**
     * Fields that can be mass assigned using newEmptyEntity(() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'img' => true,
        'descr' => true,
        'challenges' => true,
    ];
}
