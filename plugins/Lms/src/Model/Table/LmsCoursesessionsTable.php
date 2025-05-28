<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCoursesessions Model
 *
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\BelongsTo $LmsCourses
 * @property \Lms\Model\Table\LmsCourseweeksTable&\Cake\ORM\Association\BelongsTo $LmsCourseweeks
 * @property \Lms\Model\Table\LmsCoursefilesTable&\Cake\ORM\Association\BelongsTo $LmsCoursefiles
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Lms\Model\Entity\LmsCoursesession get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCoursesession newEmptyEntity(($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursesession[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursesession|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursesession saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursesession patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursesession[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursesession findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsCoursesessionsTable extends Table
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

        $this->setTable('lms_coursesessions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LmsCourses', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCourses',
        ]);
        $this->belongsTo('LmsCourseweeks', [
            'foreignKey' => 'lms_courseweek_id',
            'className' => 'Lms.LmsCourseweeks',
        ]);
        $this->belongsTo('LmsCoursefiles', [
            'foreignKey' => 'lms_coursefile_id',
            'className' => 'Lms.LmsCoursefiles',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Lms.Users',
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
                    $entity->{$v} = strip_tags($entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
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
        $rules->add($rules->existsIn(['lms_courseweek_id'], 'LmsCourseweeks'));
        $rules->add($rules->existsIn(['lms_coursefile_id'], 'LmsCoursefiles'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
