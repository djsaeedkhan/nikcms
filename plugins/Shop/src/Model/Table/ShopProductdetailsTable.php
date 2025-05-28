<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopProductdetails Model
 *
 * @property \Shop\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \Shop\Model\Entity\ShopProductdetail get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopProductdetail newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopProductdetail[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductdetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductdetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductdetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductdetail[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductdetail findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopProductdetailsTable extends Table
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

        $this->setTable('shop_productdetails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->scalar('pattern')
            ->maxLength('pattern', 100)
            ->allowEmptyString('pattern');

        $validator
            ->scalar('image')
            ->maxLength('image', 2000)
            ->allowEmptyFile('image');

        $validator
            ->scalar('sku')
            ->maxLength('sku', 15)
            ->allowEmptyString('sku');

        $validator
            ->allowEmptyString('price');

        $validator
            ->allowEmptyString('special_price');

        $validator
            ->integer('stock')
            ->allowEmptyString('stock');

        $validator
            ->boolean('disable')
            ->notEmptyString('disable');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 2000)
            ->allowEmptyString('descr');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['post_id'], 'Posts'));

        return $rules;
    }
}
