<?php
namespace Ticketing\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ticketcomments Model
 *
 * @property \Ticketing\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Ticketing\Model\Table\TicketsTable&\Cake\ORM\Association\BelongsTo $Tickets
 *
 * @method \Ticketing\Model\Entity\Ticketcomment get($primaryKey, $options = [])
 * @method \Ticketing\Model\Entity\Ticketcomment newEmptyEntity(($data = null, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcomment[] newEntities(array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcomment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticketcomment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticketcomment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcomment[] patchEntities($entities, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketcomment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TicketcommentsTable extends Table
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

        $this->setTable('ticketcomments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            //'joinType' => 'INNER',
            'className' => 'Ticketing.Users',
        ]);
        $this->belongsTo('Tickets', [
            'foreignKey' => 'ticket_id',
            //'joinType' => 'INNER',
            'className' => 'Ticketing.Tickets',
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
                    $entity->{$v} = strip_tags($entity->{$v},'<button><fieldset><h1><h2><h3><h4><h5><h6><small><label><img><img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
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
            ->scalar('content')
            ->maxLength('content', 4294967295)
            ->allowEmptyString('content');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 500)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('filesrc')
            ->maxLength('filesrc', 200)
            ->allowEmptyFile('filesrc');

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
        $rules->add($rules->existsIn(['ticket_id'], 'Tickets'));

        return $rules;
    }
}
