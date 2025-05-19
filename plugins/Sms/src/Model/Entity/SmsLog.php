<?php
namespace Sms\Model\Entity;

use Cake\ORM\Entity;

/**
 * SmsLog Entity
 *
 * @property int $id
 * @property string $mobile
 * @property string|null $message
 * @property string $sender
 * @property string|null $terminal
 * @property string|null $status
 * @property string|null $error
 * @property string|null $error_text
 * @property \Cake\I18n\FrozenTime $created
 */
class SmsLog extends Entity
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
        'mobile' => true,
        'message' => true,
        'sender' => true,
        'terminal' => true,
        'status' => true,
        'error' => true,
        'error_text' => true,
        'created' => true,
    ];
}
