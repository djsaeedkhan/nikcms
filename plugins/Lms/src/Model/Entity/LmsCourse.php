<?php
declare(strict_types=1);

namespace Lms\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;
use Lms\View\Helper\LmsHelper;

/**
 * LmsCourse Entity
 *
 * @property int $id
 * @property string $title
 * @property int|null $lms_coursecategorie_id
 * @property int|null $user_id
 * @property string|null $text
 * @property string|null $textweb
 * @property string|null $image
 * @property \Cake\I18n\FrozenTime|null $date_start
 * @property \Cake\I18n\FrozenTime|null $date_end
 * @property int $date_type
 * @property int|null $price
 * @property int|null $price_special
 * @property int|null $price_renew
 * @property bool $show_in_list
 * @property bool $can_add
 * @property bool|null $can_renew
 * @property int|null $renew_day
 * @property string|null $total_time
 * @property bool $enable
 * @property int|null $priority
 * @property string|null $options
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Lms\Model\Entity\LmsCoursecategory $lms_coursecategory
 * @property \Lms\Model\Entity\User $user
 * @property \Lms\Model\Entity\LmsCertificate[] $lms_certificates
 * @property \Lms\Model\Entity\LmsCourseexam[] $lms_courseexams
 * @property \Lms\Model\Entity\LmsCoursefilecan[] $lms_coursefilecans
 * @property \Lms\Model\Entity\LmsCoursefile[] $lms_coursefiles
 * @property \Lms\Model\Entity\LmsCourserelated[] $lms_courserelateds
 * @property \Lms\Model\Entity\LmsCoursesession[] $lms_coursesessions
 * @property \Lms\Model\Entity\LmsCourseuser[] $lms_courseusers
 * @property \Lms\Model\Entity\LmsCourseweek[] $lms_courseweeks
 * @property \Lms\Model\Entity\LmsUserfactor[] $lms_userfactors
 * @property \Lms\Model\Entity\LmsUsernote[] $lms_usernotes
 */
class LmsCourse extends Entity
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
        'title' => true,
        'lms_coursecategorie_id' => true,
        'user_id' => true,
        'text' => true,
        'textweb' => true,
        'image' => true,
        'date_start' => true,
        'date_end' => true,
        'date_type' => true,
        'price' => true,
        'price_special' => true,
        'price_renew' => true,
        'show_in_list' => true,
        'can_add' => true,
        'can_renew' => true,
        'renew_day' => true,
        'total_time' => true,
        'enable' => true,
        'priority' => true,
        'options' => true,
        'created' => true,
        'lms_coursecategory' => true,
        'user' => true,
        'lms_certificates' => true,
        'lms_courseexams' => true,
        'lms_coursefilecans' => true,
        'lms_coursefiles' => true,
        'lms_courserelateds' => true,
        'lms_coursesessions' => true,
        'lms_courseusers' => true,
        'lms_courseweeks' => true,
        'lms_userfactors' => true,
        'lms_usernotes' => true,
    ];

    protected $_virtual = ['slug','sprice'];
    protected function _getslug(){
        try {
            return (Text::excerpt(preg_replace('/\s/u', '-',$this->get('title')),'',50) );
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $this->get('title');
    }
    protected function _getsprice(){
        if($this->get('price_special') != "" or $this->get('price_special') != 0){
            return  '<span class="mx-1" style="text-decoration: line-through;">'.
                LmsHelper::PriceShow($this->get('price_special')).
                '</span>';
        }
    }
}
