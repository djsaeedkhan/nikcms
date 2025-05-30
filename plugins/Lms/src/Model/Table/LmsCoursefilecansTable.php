<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCoursefilecans Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\BelongsTo $LmsCourses
 * @property \Lms\Model\Table\LmsCoursefilesTable&\Cake\ORM\Association\BelongsTo $LmsCoursefiles
 *
 * @method \Lms\Model\Entity\LmsCoursefilecan get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCoursefilecan newEmptyEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefilecan[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefilecan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursefilecan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursefilecan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefilecan[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursefilecan findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsCoursefilecansTable extends Table
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

        $this->setTable('lms_coursefilecans');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Lms.Users',
        ]);
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
            ->boolean('enable')
            ->notEmptyString('enable');

        $validator
            ->boolean('types')
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['lms_course_id'], 'LmsCourses'));
        $rules->add($rules->existsIn(['lms_coursefile_id'], 'LmsCoursefiles'));

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
