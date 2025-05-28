<?php
namespace Lms\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Lms\View\Helper\LmsHelper;

/**
 * LmsFactor Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $user_ids
 * @property int $price
 * @property int|null $old_price
 * @property int|null $lms_coupon_id
 * @property int $paid
 * @property int|null $status
 * @property string|null $descr
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsCoupon $lms_coupon
 * @property \Lms\Model\Entity\LmsPayment[] $lms_payments
 * @property \Lms\Model\Entity\LmsUserfactor[] $lms_userfactors
 */
class LmsFactor extends Entity
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
        'user_ids' => true,
        'price' => true,
        'old_price' => true,
        'lms_coupon_id' => true,
        'paid' => true,
        'status' => true,
        'descr' => true,
        'options' => true,
        'types' => true,
        'created' => true,
        'user' => true,
        'lms_coupon' => true,
        'lms_payments' => true,
        'lms_userfactors' => true,
    ];

    protected $_virtual = ['coupons'];
    protected function _getcoupons(){
        if($this->get('lms_coupon_id') != ""){
            $counpon = TableRegistry::getTableLocator()->get('Lms.LmsCoupons')->find('all')
                ->where(['id'=>$this->get('lms_coupon_id')])
                ->first();
            return  '<br><span style="text-decoration: line-through;">'.
                LmsHelper::PriceShow($this->get('old_price')).
                '</span>'.
                ($counpon?' <span class="badge badge-secondary fw-n">'.$counpon['title'].'</span>':'');
        }
    }
}
