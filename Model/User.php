<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

    var $name = 'User';
    var $actsAs = array('Containable');
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'Group' => array('className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Gender' => array('className' => 'Gender',
            'foreignKey' => 'gender_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'City' => array('className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Profilepicture' => array('className' => 'Picture',
            'foreignKey' => 'picture_id'
        )
    );
    var $hasMany = array(
        'Picture' => array('className' => 'Picture',
            'foreignKey' => 'user_id'
        ),
        'Favorite' => array('className' => 'Favorite',
            'foreignKey' => 'user_id'
        )
    );

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            'yearOld' => "DATE_FORMAT( FROM_DAYS( DATEDIFF( NOW( ) , `{$this->alias}`.`birthdate` ) ) ,  '%Y' ) +0"
        );
    }

    var $validate = array
        (
        'username' => array
            (
            'notEmpty' => array
                (
                'rule' => 'notEmpty',
                'message' => 'Prosim, vnesite e-mail naslov!'
            ),
            'email' => array
                (
                'rule' => array('email', true),
                'message' => 'Prosim, vnesite veljaven e-mail naslov!'
            ),
            'isUnique' => array
                (
                'rule' => 'isUnique',
                'message' => 'Uporabnik, s tem e-mail naslovom že obstaja!'
            )
        ),
        'password' => array
            (
            'notEmpty' => array
                (
                'rule' => 'notEmpty',
                'message' => 'Prosim, vnesite geslo!'
            )
        ),
        'name' => array
            (
            'notEmpty' => array
                (
                'rule' => 'notEmpty',
                'message' => 'Prosim, vnesite ime!'
            )
        ),
        'surname' => array
            (
            'notEmpty' => array
                (
                'rule' => 'notEmpty',
                'message' => 'Prosim, vnesite priimek!'
            )
        ),
        'gender_id' => array
            (
            'notEmpty' => array
                (
                'rule' => 'notEmpty',
                'message' => 'Prosim, izberite spol!'
            )
        ),
        'city_id' => array
            (
            'notEmpty' => array
                (
                'rule' => 'notEmpty',
                'message' => 'Prosim, izberite mesto!'
            )
        ),
        'lgender_id' => array
            (
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'smoker_id' => array
            (
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'drinker_id' => array
            (
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'city_id' => array
            (
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'searchfor_id' => array
            (
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'status_id' => array
            (
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'nickName' => array
            (
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'nickName' => array
            (
            'notEmpty' => array
                (
                'rule' => 'notEmpty',
                'message' => 'To polje ne sme biti prazno!'
            ),
            'isUnique' => array
                (
                'rule' => 'isUnique',
                'message' => 'Zporabniško ime je že zasedeno!'
            )
        )
    );

    public function afterFind($results, $primary = false) {
        foreach ($results as $key => $val) {
            if (isset($val['User']['nickName'])) {
                $results[$key]['User']['nickName'] = h($val['User']['nickName']);
            }

            if (isset($val['User']['aboutme'])) {
                $results[$key]['User']['aboutme'] = h($val['User']['aboutme']);
            }

            if (isset($val['User']['whywritetome'])) {
                $results[$key]['User']['whywritetome'] = h($val['User']['whywritetome']);
            }
        } return $results;
    }

    public function isProfileOk($id = NULL) {
        if (isset($id)) {
            $tmpData = $this->findById($id);

            if (($tmpData['User']['picture_id'] != 0) && (!empty($tmpData['User']['aboutme'])) && (!empty($tmpData['User']['whywritetome']))) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function beforeSave($options = array()) {
        if (!$this->id) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }
        return true;
    }

}

?>
