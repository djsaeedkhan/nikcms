<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsExamresultlists Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\BelongsTo $LmsExamresults
 * @property \Lms\Model\Table\LmsExamsTable&\Cake\ORM\Association\BelongsTo $LmsExams
 * @property \Lms\Model\Table\LmsExamquestsTable&\Cake\ORM\Association\BelongsTo $LmsExamquests
 *
 * @method \Lms\Model\Entity\LmsExamresultlist get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsExamresultlist newEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresultlist[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresultlist|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExamresultlist saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExamresultlist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresultlist[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresultlist findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsExamresultlistsTable extends Table
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

        $this->setTable('lms_examresultlists');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Lms.Users',
        ]);
        $this->belongsTo('LmsExamresults', [
            'foreignKey' => 'lms_examresult_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsExamresults',
        ]);
        $this->belongsTo('LmsExams', [
            'foreignKey' => 'lms_exam_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsExams',
        ]);
        $this->belongsTo('LmsExamquests', [
            'foreignKey' => 'lms_examquest_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsExamquests',
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
            ->allowEmptyString('token');

        $validator
            ->scalar('answer')
            ->requirePresence('answer', 'create')
            ->notEmptyString('answer');

        $validator
            ->allowEmptyString('result');

        $validator
            ->scalar('filesrc')
            ->maxLength('filesrc', 200)
            ->allowEmptyFile('filesrc');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['lms_examresult_id'], 'LmsExamresults'));
        $rules->add($rules->existsIn(['lms_exam_id'], 'LmsExams'));
        $rules->add($rules->existsIn(['lms_examquest_id'], 'LmsExamquests'));

        return $rules;
    }
}
