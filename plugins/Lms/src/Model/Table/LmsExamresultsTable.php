<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsExamresults Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsExamsTable&\Cake\ORM\Association\BelongsTo $LmsExams
 * @property &\Cake\ORM\Association\BelongsTo $LmsCoursefiles
 * @property \Lms\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 *
 * @method \Lms\Model\Entity\LmsExamresult get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsExamresult newEmptyEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresult[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresult|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExamresult saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsExamresult patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresult[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsExamresult findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsExamresultsTable extends Table
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

        $this->setTable('lms_examresults');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            //'joinType' => 'INNER',
            'className' => 'Lms.Users',
        ]);
        $this->belongsTo('LmsExams', [
            'foreignKey' => 'lms_exam_id',
            //'joinType' => 'INNER',
            'className' => 'Lms.LmsExams',
        ]);
        $this->belongsTo('LmsCoursefiles', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsCoursefiles',
        ]);
        $this->hasMany('LmsExamresultlists', [
            'foreignKey' => 'lms_examresult_id',
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
            ->scalar('token')
            ->maxLength('token', 15)
            ->allowEmptyString('token');

        $validator
            ->allowEmptyString('result');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 200)
            ->allowEmptyString('descr');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['lms_exam_id'], 'LmsExams'));
        $rules->add($rules->existsIn(['lms_coursefile_id'], 'LmsCoursefiles'));

        return $rules;
    }
}
