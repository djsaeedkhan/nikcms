<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * ShopProductprices Model
 *
 * @property \Shop\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \Shop\Model\Entity\ShopProductprice get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopProductprice newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopProductprice[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductprice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductprice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductprice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductprice[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductprice findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopProductpricesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shop_productprices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Posts',
        ]);
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified'])) return true;
                if(is_array($entity->{$v})){
                    //$entity->{$v} = ($entity->{$v});
                }else{
                    $entity->{$v} = strip_tags($entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('price')
            ->maxLength('price', 10)
            ->notEmptyString('price');

        return $validator;
    }

    /* public function beforeSave($event, $entity, $options) {
        if($entity->post_id > 0)
            $this->getTableLocator()->get('Shop.ShopProductprices')->deleteAll(['post_id'=>$entity->post_id]);
    } */

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        return $rules;
    }
}
