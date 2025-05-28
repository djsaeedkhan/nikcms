<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCourseexams Model
 *
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\BelongsTo $LmsCourses
 * @property \Lms\Model\Table\LmsCoursefilesTable&\Cake\ORM\Association\BelongsTo $LmsCoursefiles
 * @property \Lms\Model\Table\LmsExamsTable&\Cake\ORM\Association\BelongsTo $LmsExams
 *
 * @method \Lms\Model\Entity\LmsCourseexam get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCourseexam newEmptyEntity(($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCourseexam[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourseexam|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCourseexam saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCourseexam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourseexam[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourseexam findOrCreate($search, callable $callback = null, $options = [])
 */
class LmsCourseexamsTable extends Table
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

        $this->setTable('lms_courseexams');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('LmsCourses', [
            'foreignKey' => 'lms_course_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsCourses',
        ]);
        $this->belongsTo('LmsCoursefiles', [
            'foreignKey' => 'lms_coursefile_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsCoursefiles',
        ]);
        $this->belongsTo('LmsExams', [
            'foreignKey' => 'lms_exam_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsExams',
        ]);
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
            ->boolean('on_success')
            ->allowEmptyString('on_success');

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
        $rules->add($rules->existsIn(['lms_course_id'], 'LmsCourses'));
        $rules->add($rules->existsIn(['lms_coursefile_id'], 'LmsCoursefiles'));
        $rules->add($rules->existsIn(['lms_exam_id'], 'LmsExams'));

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
                    $entity->{$v} = strip_tags($entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
    }
}
