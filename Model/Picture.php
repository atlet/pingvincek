<?php

class Picture extends AppModel
{
    var $name = 'Picture';

    var $belongsTo = array(
        'User' => array('className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    
    var $hasMany = array(
        'Profilepicture' => array('className' => 'User',
            'foreignKey' => 'picture_id'
        )
    );

    function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $val)
        {
            if (isset($val['Picture']['description']))
            {
                $results[$key]['Picture']['description'] = h($val['Picture']['description']);
            }
        } return $results;
    }
    
    function userPictureCount($uid = NULL)
    {
        if (isset($uid))
        {
            return $this->find('count', array('conditions' => array('Picture.user_id' => $uid)));
        }
        else
        {
            return FALSE;
        }
    }
    
}

?>