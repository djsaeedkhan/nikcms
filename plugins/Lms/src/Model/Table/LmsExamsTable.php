<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsExams Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsCourseexamsTable&\Cake\ORM\Association\HasMany $LmsCourseexams
 * @property \Lms\Model\Table\LmsExamquestsTable&\Cake\ORM\Association\HasMany $LmsExamquests
 * @property \Lms\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 * @property \Lms\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\HasMany $LmsExamresults
 * @property \Lms\Model\Table\LmsExamusersTable&\Cake\ORM\Association\HasMany $LmsExamusers
 *
 * @method \Lms\Model\Entity\LmsExam get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsExam newEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsExam[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExam|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExam saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExam[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExam findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsExamsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('lms_exams');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Users',
        ]);
        $this->hasMany('LmsCourseexams', [
            'foreignKey' => 'lms_exam_id',
            'className' => 'Lms.LmsCourseexams',
        ]);
        $this->hasMany('LmsExamquests', [
            'foreignKey' => 'lms_exam_id',
            'className' => 'Lms.LmsExamquests',
        ]);
        $this->hasMany('LmsExamresultlists', [
            'foreignKey' => 'lms_exam_id',
            'className' => 'Lms.LmsExamresultlists',
        ]);
        $this->hasMany('LmsExamresults', [
            'foreignKey' => 'lms_exam_id',
            'className' => 'Lms.LmsExamresults',
        ]);
        $this->hasMany('LmsExamusers', [
            'foreignKey' => 'lms_exam_id',
            'className' => 'Lms.LmsExamusers',
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
            ->scalar('title')
            ->maxLength('title', 300)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 5000)
            ->allowEmptyString('descr');

        $validator
            ->allowEmptyString('timer');

        $validator
            ->allowEmptyString('reexam');

        $validator
            ->requirePresence('fail_count', 'create')
            ->notEmptyString('fail_count');

        $validator
            ->scalar('options')
            ->maxLength('options', 10000)
            ->allowEmptyString('options');
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

        return $rules;
    }
}
