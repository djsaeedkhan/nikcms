<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengeuserform Entity
 *
 * @property int $id
 * @property int $challenge_id
 * @property int $user_id
 * @property string|null $userinfo
 * @property string|null $filesrc
 * @property string|null $filesrc2
 * @property string|null $filesrc3
 * @property string|null $title
 * @property string|null $descr1
 * @property string|null $descr2
 * @property string|null $descr3
 * @property string|null $descr4
 * @property string|null $descr5
 * @property string|null $descr6
 * @property bool|null $enable
 * @property bool|null $approved
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Challenge\Model\Entity\Challenge $challenge
 * @property \Challenge\Model\Entity\User $user
 */
class Challengeuserform extends Entity
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
        'user_id' => true,
        'userinfo' => true,
        'filesrc' => true,
        'filesrc2' => true,
        'filesrc3' => true,
        'title' => true,
        'descr1' => true,
        'descr2' => true,
        'descr3' => true,
        'descr4' => true,
        'descr5' => true,
        'descr6' => true,
        'token1' => true,
        'enable' => true,
        'approved' => true,
        'created' => true,
        'challenge' => true,
        'user' => true,
    ];
}
