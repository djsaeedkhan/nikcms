<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;

/**
 * LmsPayment Entity
 *
 * @property int $id
 * @property int|null $lms_factor_id
 * @property string|null $token
 * @property int $price
 * @property int $user_id
 * @property int|null $terminal_ids
 * @property string|null $auth
 * @property string|null $RefID
 * @property string|null $TraceID
 * @property string|null $Errcode
 * @property string|null $Errtext
 * @property int $status
 * @property bool $enable
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\LmsFactor $lms_factor
 * @property \Lms\Model\Entity\User $user
 */
class LmsPayment extends Entity
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
        'lms_factor_id' => true,
        'token' => true,
        'price' => true,
        'user_id' => true,
        'terminal_ids' => true,
        'auth' => true,
        'RefID' => true,
        'TraceID' => true,
        'Errcode' => true,
        'Errtext' => true,
        'status' => true,
        'enable' => true,
        'created' => true,
        'lms_factor' => true,
        'user' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
