<?php
namespace Widget\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WidgetForms Model
 *
 * @property \Widget\Model\Table\WidgetsTable|\Cake\ORM\Association\BelongsTo $Widgets
 *
 * @method \Widget\Model\Entity\WidgetForm get($primaryKey, $options = [])
 * @method \Widget\Model\Entity\WidgetForm newEmptyEntity(($data = null, array $options = [])
 * @method \Widget\Model\Entity\WidgetForm[] newEntities(array $data, array $options = [])
 * @method \Widget\Model\Entity\WidgetForm|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Widget\Model\Entity\WidgetForm|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Widget\Model\Entity\WidgetForm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Widget\Model\Entity\WidgetForm[] patchEntities($entities, array $data, array $options = [])
 * @method \Widget\Model\Entity\WidgetForm findOrCreate($search, callable $callback = null, $options = [])
 */
class WidgetFormsTable extends Table
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

        $this->setTable('widget_forms');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Widgets', [
            'foreignKey' => 'widgets_id',
            'joinType' => 'INNER',
            'className' => 'Widget.Widgets'
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
    public function validationDefault(Validator $validator): Validator
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
            ->scalar('widgets_id')
            ->maxLength('widgets_id', 50)
            ->requirePresence('widgets_id', 'create')
            ->notEmpty('widgets_id');
        $validator
            ->scalar('data')
            ->requirePresence('data', 'create')
            ->notEmpty('data');

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
        //$rules->add($rules->existsIn(['widgets_id'], 'Widgets'));

        return $rules;
    }
}
