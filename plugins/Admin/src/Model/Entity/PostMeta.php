<?php
namespace Admin\Model\Entity;

use Admin\View\Helper\FuncHelper;
use Cake\ORM\Entity;

/**
 * PostMeta Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string $meta_type
 * @property string|null $meta_key
 * @property string|null $meta_value
 *
 * @property \Admin\Model\Entity\Post $post
 */
class PostMeta extends Entity
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
        'post_id' => true,
        'meta_type' => true,
        'meta_key' => true,
        'meta_value' => true,
        'post' => true,
    ];

    protected $_virtual = ['meta_values'];
    protected function _getmetaValues()
    {
        $this->Func = new FuncHelper(new \Cake\View\View());
        return ($this->Func->is_serial($this->get('meta_value'))?
        unserialize($this->get('meta_value')):
        $this->get('meta_value'));
    }
}
