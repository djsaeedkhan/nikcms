<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LogsTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('logs');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Users'
        ]);
        /* $this->belongsTo('Actions', [
            'foreignKey' => 'action_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Actions'
        ]); */
        /* $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Groups'
        ]); */
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->scalar('value')
            ->requirePresence('value', 'create')
            ->notEmpty('value');
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
                    $entity->{$v} = strip_tags( (string) $entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
    }
    
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        /* $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['action_id'], 'Actions'));
        $rules->add($rules->existsIn(['group_id'], 'Groups')); */
        return $rules;
    }
}