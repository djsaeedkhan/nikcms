<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopLabels Model
 *
 * @method \Shop\Model\Entity\ShopLabel get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopLabel newEmptyEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopLabel[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLabel|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLabel saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopLabel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLabel[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopLabel findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopLabelsTable extends Table
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

        $this->setTable('shop_labels');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
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
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('color')
            ->maxLength('color', 100)
            ->allowEmptyString('color');

        $validator
            ->scalar('image')
            ->maxLength('image', 500)
            ->allowEmptyFile('image');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 2000)
            ->allowEmptyString('descr');

        $validator
            ->scalar('link')
            ->maxLength('link', 500)
            ->allowEmptyString('link');

        return $validator;
    }
}
