<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopProductmajors Model
 *
 * @property \Shop\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \Shop\Model\Entity\ShopProductmajor get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopProductmajor newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopProductmajor[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductmajor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductmajor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductmajor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductmajor[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductmajor findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopProductmajorsTable extends Table
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

        $this->setTable('shop_productmajors');
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
            ->integer('start')
            ->requirePresence('start', 'create')
            ->notEmptyString('start');

        $validator
            ->scalar('pattern')
            ->maxLength('pattern', 15)
            ->allowEmptyString('pattern');

        $validator
            ->integer('stock')
            ->allowEmptyString('stock');

        $validator
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

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
