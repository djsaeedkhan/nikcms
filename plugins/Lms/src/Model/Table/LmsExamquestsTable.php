<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsExamquests Model
 *
 * @property \Lms\Model\Table\LmsExamsTable&\Cake\ORM\Association\BelongsTo $LmsExams
 * @property \Lms\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 *
 * @method \Lms\Model\Entity\LmsExamquest get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsExamquest newEmptyEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsExamquest[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamquest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExamquest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExamquest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamquest[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamquest findOrCreate($search, callable $callback = null, $options = [])
 */
class LmsExamquestsTable extends Table
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

        $this->setTable('lms_examquests');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('LmsExams', [
            'foreignKey' => 'lms_exam_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsExams',
        ]);
        $this->hasMany('LmsExamresultlists', [
            'foreignKey' => 'lms_examquest_id',
            'className' => 'Lms.LmsExamresultlists',
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
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            //->requirePresence('title', 'create')
            ->notEmptyString('title');
            /*
            ->scalar('title')
            ->maxLength('title', 2000)
            ->requirePresence('title', 'create')
            ->notEmptyString('title'); */

        $validator
            ->scalar('images')
            ->maxLength('images', 200)
            ->allowEmptyFile('images');

        $validator
            ->notEmptyString('priority');

        $validator
            ->boolean('types')
            ->notEmptyString('types');

        $validator
            ->scalar('q1')
            ->allowEmptyString('q1');

        $validator
            ->scalar('q2')
            ->allowEmptyString('q2');

        $validator
            ->scalar('q3')
            ->allowEmptyString('q3');

        $validator
            ->scalar('q4')
            ->allowEmptyString('q4');

        $validator
            ->scalar('q5')
            ->allowEmptyString('q5');

        $validator
            ->allowEmptyString('correct');

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
        $rules->add($rules->existsIn(['lms_exam_id'], 'LmsExams'));

        return $rules;
    }
}
