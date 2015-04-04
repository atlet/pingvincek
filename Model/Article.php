<?php

class Article extends AppModel
{

    var $name = 'Article';

    var $validate = array(
        'slug' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'To polje ne sme biti prazno!'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',        
                'message' => 'Ta naslov je že zaseden! Prosim, izberite drugega.'
            )
        ),
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'body' => array(
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'description' => array(
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'keywords' => array(
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        )
    );
   
}

?>