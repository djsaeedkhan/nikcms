<?php
namespace Formbuilder\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormbuilderItems Model
 *
 * @property \Formbuilder\Model\Table\FormbuildersTable&\Cake\ORM\Association\BelongsTo $Formbuilders
 *
 * @method \Formbuilder\Model\Entity\FormbuilderItem get($primaryKey, $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderItem newEmptyEntity(($data = null, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderItem[] newEntities(array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderItem[] patchEntities($entities, array $data, array $options = [])
 * @method \Formbuilder\Model\Entity\FormbuilderItem findOrCreate($search, callable $callback = null, $options = [])
 */
class FormbuilderItemsTable extends Table
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

        $this->setTable('formbuilder_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Formbuilders', [
            'foreignKey' => 'formbuilder_id',
            'joinType' => 'INNER',
            'className' => 'Formbuilder.Formbuilders',
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
            ->scalar('form_data')
            ->maxLength('form_data', 4294967295)
            ->allowEmptyString('form_data');

        $validator
            ->scalar('form_html')
            ->maxLength('form_html', 4294967295)
            ->allowEmptyString('form_html');

        $validator
            ->scalar('css')
            ->allowEmptyString('css');

        $validator
            ->scalar('logo')
            ->allowEmptyString('logo');

        $validator
            ->scalar('uinfo')
            ->allowEmptyString('uinfo');

        $validator
            ->scalar('footer')
            ->allowEmptyString('footer');

        $validator
            ->scalar('smstext')
            ->maxLength('smstext', 200)
            ->allowEmptyString('smstext');

        $validator
            ->scalar('submit')
            ->allowEmptyString('submit');

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

        return $rules;
    }
    /* public function beforeSave($event){
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
    } */
}
