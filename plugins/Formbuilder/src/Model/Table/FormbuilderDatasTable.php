<?php
namespace Formbuilder\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormbuilderDatas Model
 *
 * @property \Formbuilder\Model\Table\FormbuildersTable&\Cake\ORM\Association\BelongsTo $Formbuilders
 * @property \Formbuilder\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Formbuilder\Model\Entity\FormbuilderData get($primaryKey, $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderData newEmptyEntity($data = null, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderData[] newEntities(array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderData[] patchEntities($entities, array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderData findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FormbuilderDatasTable extends Table
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

        $this->setTable('formbuilder_datas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Formbuilders', [
            'foreignKey' => 'formbuilder_id',
            'className' => 'Formbuilder.Formbuilders',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Formbuilder.Users',
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
            ->scalar('data')
            ->allowEmptyString('data');

        $validator
            ->scalar('field')
            ->allowEmptyString('field');

        $validator
            ->scalar('ips')
            ->maxLength('ips', 20)
            ->allowEmptyString('ips');

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
        $rules->add($rules->existsIn(['formbuilder_id'], 'Formbuilders'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
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
