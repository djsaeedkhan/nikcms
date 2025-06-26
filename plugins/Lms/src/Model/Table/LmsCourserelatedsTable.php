<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCourserelateds Model
 *
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\BelongsTo $LmsCourses
 *
 * @method \Lms\Model\Entity\LmsCourserelated get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCourserelated newEmptyEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCourserelated[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourserelated|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCourserelated saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCourserelated patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourserelated[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourserelated findOrCreate($search, callable $callback = null, $options = [])
 */
class LmsCourserelatedsTable extends Table
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

        $this->setTable('lms_courserelateds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('LmsCourses', [
            'foreignKey' => 'lms_course_id',
            'joinType' => 'INNER',
            'className' => 'Lms.LmsCourses',
        ]);

        $this->belongsTo('LmsCoursess', [
            'foreignKey' => 'lms_course_ids',
            //'joinType' => 'INNER',
            'className' => 'Lms.LmsCourses',
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

       /*  $validator
            ->integer('lms_course_ids')
            ->requirePresence('lms_course_ids', 'create')
            ->notEmptyString('lms_course_ids'); */

        $validator
            ->notEmptyString('types');

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
        $rules->add($rules->existsIn(['lms_course_ids'], 'LmsCoursess'));
        $rules->add($rules->isUnique(['lms_course_id','lms_course_ids'], 'دوره انتخاب شده قبلا اضافه شده و تکراری است'));

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
