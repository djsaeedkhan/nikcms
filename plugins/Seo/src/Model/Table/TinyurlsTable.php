<?php
namespace Tinyurl\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tinyurls Model
 *
 * @method \Tinyurl\Model\Entity\Tinyurl get($primaryKey, $options = [])
 * @method \Tinyurl\Model\Entity\Tinyurl newEmptyEntity($data = null, array $options = [])
 * @method \Tinyurl\Model\Entity\Tinyurl[] newEntities(array $data, array $options = [])
 * @method \Tinyurl\Model\Entity\Tinyurl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Tinyurl\Model\Entity\Tinyurl|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Tinyurl\Model\Entity\Tinyurl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Tinyurl\Model\Entity\Tinyurl[] patchEntities($entities, array $data, array $options = [])
 * @method \Tinyurl\Model\Entity\Tinyurl findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TinyurlsTable extends Table
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

        $this->setTable('tinyurls');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
                    $entity->{$v} = strip_tags( (string) $entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('slug')
            //->requirePresence('slug', 'create')
            ->allowEmpty('slug');

        $validator
            ->scalar('link')
            ->requirePresence('link', 'create')
            ->notEmpty('link');

       /*  $validator
            ->integer('category')
            ->requirePresence('category', 'create')
            ->notEmpty('category');

        $validator
            ->integer('expire')
            ->requirePresence('expire', 'create')
            ->notEmpty('expire');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status'); */

        return $validator;
    }
}
