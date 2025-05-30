<?php
namespace Scheduler\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cronjobs Model
 *
 * @method \Scheduler\Model\Entity\Cronjob get($primaryKey, $options = [])
 * @method \Scheduler\Model\Entity\Cronjob newEmptyEntity($data = null, array $options = [])
 * @method \Scheduler\Model\Entity\Cronjob[] newEntities(array $data, array $options = [])
 * @method \Scheduler\Model\Entity\Cronjob|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Scheduler\Model\Entity\Cronjob saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Scheduler\Model\Entity\Cronjob patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Scheduler\Model\Entity\Cronjob[] patchEntities($entities, array $data, array $options = [])
 * @method \Scheduler\Model\Entity\Cronjob findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CronjobsTable extends Table
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

        $this->setTable('cronjobs');
        $this->setDisplayField('name');
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('plugin')
            ->maxLength('plugin', 100)
            ->allowEmptyString('plugin');

        $validator
            ->allowEmptyString('status');

        $validator
            ->scalar('result')
            ->allowEmptyString('result');

        return $validator;
    }
}
