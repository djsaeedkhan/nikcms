<?php
namespace Widget\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Widgets Model
 *
 * @method \Widget\Model\Entity\Widget get($primaryKey, $options = [])
 * @method \Widget\Model\Entity\Widget newEntity($data = null, array $options = [])
 * @method \Widget\Model\Entity\Widget[] newEntities(array $data, array $options = [])
 * @method \Widget\Model\Entity\Widget|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Widget\Model\Entity\Widget|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Widget\Model\Entity\Widget patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Widget\Model\Entity\Widget[] patchEntities($entities, array $data, array $options = [])
 * @method \Widget\Model\Entity\Widget findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WidgetsTable extends Table
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

        $this->setTable('widgets');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('WidgetForms', [
            'foreignKey' => 'widgets_id',
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
                    $entity->{$v} = strip_tags($entity->{$v},'<button><fieldset><h1><h2><h3><h4><h5><h6><small><label><img><img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 50)
            //->requirePresence('slug', 'create')
            ->allowEmpty('slug');

        return $validator;
    }
}
