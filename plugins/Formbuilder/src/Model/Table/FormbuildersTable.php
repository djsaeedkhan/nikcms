<?php
namespace Formbuilder\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Formbuilders Model
 *
 * @property \Formbuilder\Model\Table\FormbuilderDatasTable&\Cake\ORM\Association\HasMany $FormbuilderDatas
 * @property \Formbuilder\Model\Table\FormbuilderItemsTable&\Cake\ORM\Association\HasMany $FormbuilderItems
 *
 * @method \Formbuilder\Model\Entity\Formbuilder get($primaryKey, $options = [])
 * @method \Formbuilder\Model\Entity\Formbuilder newEmptyEntity($data = null, array $options = [])
 * @method \Formbuilder\Model\Entity\Formbuilder[] newEntities(array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\Formbuilder|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Formbuilder\Model\Entity\Formbuilder saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Formbuilder\Model\Entity\Formbuilder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\Formbuilder[] patchEntities($entities, array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\Formbuilder findOrCreate($search, callable $callback = null, $options = [])
 */
class FormbuildersTable extends Table
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

        $this->setTable('formbuilders');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('FormbuilderDatas', [
            'foreignKey' => 'formbuilder_id',
            'className' => 'Formbuilder.FormbuilderDatas',
        ]);
        $this->hasMany('FormbuilderItems', [
            'foreignKey' => 'formbuilder_id',
            'className' => 'Formbuilder.FormbuilderItems',
        ]);
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
            ->maxLength('title', 30)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('passwords')
            ->maxLength('passwords', 20)
            ->allowEmptyString('passwords');

        $validator
            ->scalar('action')
            ->maxLength('action', 5)
            ->allowEmptyString('action');

        $validator
            ->scalar('alert')
            ->maxLength('alert', 5)
            ->allowEmptyString('alert');

        $validator
            ->integer('counts')
            ->notEmptyString('counts');

        $validator
            ->scalar('emails')
            ->maxLength('emails', 50)
            ->allowEmptyString('emails');

        $validator
            ->boolean('enable')
            ->allowEmptyString('enable');

        return $validator;
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
}
