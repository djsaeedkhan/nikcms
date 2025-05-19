<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCertificates Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\BelongsTo $LmsCourses
 *
 * @method \Lms\Model\Entity\LmsCertificate get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCertificate newEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCertificate[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCertificate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCertificate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCertificate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCertificate[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCertificate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsCertificatesTable extends Table
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

        $this->setTable('lms_certificates');
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
            ->scalar('input_data')
            ->allowEmptyString('input_data');

        $validator
            ->scalar('image')
            ->maxLength('image', 1000)
            ->allowEmptyFile('image');

        $validator
            ->scalar('download')
            ->maxLength('download', 1000)
            ->allowEmptyString('download');

        $validator
            ->allowEmptyString('status');

        $validator
            ->scalar('alert')
            ->allowEmptyString('alert');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

        $validator
            ->dateTime('accepted')
            ->allowEmptyDateTime('accepted');

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
        $rules->add($rules->existsIn(['lms_course_id'], 'LmsCourses'));

        return $rules;
    }
}
