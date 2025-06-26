<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCoursecategories Model
 *
 * @method \Lms\Model\Entity\LmsCoursecategory get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCoursecategory newEmptyEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursecategory[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursecategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursecategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoursecategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursecategory[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoursecategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsCoursecategoriesTable extends Table
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

        $this->setTable('lms_coursecategories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->maxLength('title', 1000)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 5000)
            ->allowEmptyString('descr');

        $validator
            ->scalar('image')
            ->maxLength('image', 500)
            ->allowEmptyFile('image');

        $validator
            ->integer('priority')
            ->allowEmptyString('priority');

        $validator
            ->scalar('descr1')
            ->maxLength('descr1', 1000)
            ->allowEmptyString('descr1');

        $validator
            ->scalar('descr2')
            ->maxLength('descr2', 1000)
            ->allowEmptyString('descr2');

        $validator
            ->scalar('descr3')
            ->maxLength('descr3', 1000)
            ->allowEmptyString('descr3');

        $validator
            ->scalar('button')
            ->maxLength('button', 100)
            ->allowEmptyString('button');

        return $validator;
    }
}
