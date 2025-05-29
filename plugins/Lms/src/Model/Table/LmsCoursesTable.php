<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCourses Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsCourseexamsTable&\Cake\ORM\Association\HasMany $LmsCourseexams
 * @property \Lms\Model\Table\LmsCoursefilecansTable&\Cake\ORM\Association\HasMany $LmsCoursefilecans
 * @property \Lms\Model\Table\LmsCoursefilesTable&\Cake\ORM\Association\HasMany $LmsCoursefiles
 * @property \Lms\Model\Table\LmsCourserelatedsTable&\Cake\ORM\Association\HasMany $LmsCourserelateds
 * @property \Lms\Model\Table\LmsCoursesessionsTable&\Cake\ORM\Association\HasMany $LmsCoursesessions
 * @property \Lms\Model\Table\LmsCourseusersTable&\Cake\ORM\Association\HasMany $LmsCourseusers
 * @property \Lms\Model\Table\LmsCourseweeksTable&\Cake\ORM\Association\HasMany $LmsCourseweeks
 * @property \Lms\Model\Table\LmsUserfactorsTable&\Cake\ORM\Association\HasMany $LmsUserfactors
 * @property \Lms\Model\Table\LmsUsernotesTable&\Cake\ORM\Association\HasMany $LmsUsernotes
 *
 * @method \Lms\Model\Entity\LmsCourse get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCourse newEmptyEntity(($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCourse[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCourse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCourse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourse[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCourse findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsCoursesTable extends Table
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

        $this->setTable('lms_courses');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Users',
        ]);
        $this->hasMany('LmsCourseexams', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCourseexams',
        ]);

        $this->belongsTo('LmsCoursecategories', [
            'foreignKey' => 'lms_coursecategorie_id',
            'className' => 'Lms.LmsCoursecategories',
        ]);

        $this->hasMany('LmsCoursefilecans', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCoursefilecans',
        ]);
        $this->hasMany('LmsCoursefiles', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCoursefiles',
        ]);
        $this->hasMany('LmsCourserelateds', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCourserelateds',
        ]);
        $this->hasMany('LmsCoursesessions', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCoursesessions',
        ]);
        $this->hasMany('LmsCourseusers', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCourseusers',
        ]);
        $this->hasMany('LmsCourseweeks', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsCourseweeks',
        ]);
        $this->hasMany('LmsUserfactors', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsUserfactors',
        ]);
        $this->hasMany('LmsUsernotes', [
            'foreignKey' => 'lms_course_id',
            'className' => 'Lms.LmsUsernotes',
        ]);
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified','date_end','date_start'])) return true;
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
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('text')
            ->allowEmptyString('text');

        $validator
            ->scalar('textweb')
            ->maxLength('textweb', 4294967295)
            ->allowEmptyString('textweb');

        $validator
            ->scalar('image')
            ->maxLength('image', 200)
            ->allowEmptyFile('image');

        $validator
            ->dateTime('date_start')
            ->allowEmptyDateTime('date_start');

        $validator
            ->dateTime('date_end')
            ->allowEmptyDateTime('date_end');

        $validator
            ->notEmptyString('date_type');

        $validator
            ->allowEmptyString('price');

        $validator
            ->allowEmptyString('price_special');

        $validator
            ->integer('price_renew')
            ->allowEmptyString('price_renew');

        $validator
            ->scalar('total_time')
            ->maxLength('total_time', 50)
            ->allowEmptyString('total_time');

        $validator
            ->boolean('show_in_list')
            ->notEmptyString('show_in_list');

        $validator
            ->boolean('can_add')
            ->notEmptyString('can_add');

        $validator
            ->boolean('can_renew')
            ->allowEmptyString('can_renew');

        $validator
            ->integer('renew_day')
            ->allowEmptyString('renew_day');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

        $validator
            ->allowEmptyString('priority');

        $validator
            ->scalar('options')
            ->maxLength('options', 2000)
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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
