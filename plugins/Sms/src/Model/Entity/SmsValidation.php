<?php
namespace Sms\Model\Entity;

use Cake\ORM\Entity;

/**
 * SmsValidation Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $mobile
 * @property string|null $code
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Sms\Model\Entity\User $user
 */
class SmsValidation extends Entity
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
        'user_id' => true,
        'mobile' => true,
        'code' => true,
        'status' => true,
        'created' => true,
        'user' => true,
    ];
}
