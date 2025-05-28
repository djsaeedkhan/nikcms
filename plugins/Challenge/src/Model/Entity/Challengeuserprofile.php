<?php
namespace Challenge\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challengeuserprofile Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $gender
 * @property int $provice
 * @property int|null $birth_date
 * @property int $single
 * @property int|null $eductions
 * @property string|null $email
 * @property string|null $mobile
 * @property int|null $center
 * @property string|null $center_name
 * @property string|null $semat
 * @property string|null $codemeli
 * @property string|null $field
 * @property string|null $univercity
 * @property string|null $image
 *
 * @property \Challenge\Model\Entity\User $user
 * @property \Challenge\Model\Entity\Challengetopic[] $challengetopics
 */
class Challengeuserprofile extends Entity
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
        'user_id' => true,
        'gender' => true,
        'provice' => true,
        'birth_date' => true,
        'single' => true,
        'eductions' => true,
        'email' => true,
        'mobile' => true,
        'center' => true,
        'center_name' => true,
        'semat' => true,
        'codemeli' => true,
        'field' => true,
        'univercity' => true,
        'descr' => true,
        'extra' => true,
        'image' => true,
        'user' => true,
        'challengetopics' => true,
    ];
}
