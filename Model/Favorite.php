<?php

class Favorite extends AppModel
{

    var $name = 'Favorite';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Favoritep' => array(
            'className' => 'User',
            'foreignKey' => 'favoritep'
        ),
    );

    function addToFavorite($userID = NULL, $profileID = NULL)
    {
        $tmpCount = $this->find('count', array('conditions' => array('Favorite.user_id' => $userID, 'Favorite.favoritep' => $profileID)));
        $tmpData['Favorite']['user_id'] = $userID;
        $tmpData['Favorite']['favoritep'] = $profileID;
        if ($tmpCount == 0)
        {
            $this->save($tmpData);
        }
    }

    function deleteFromFavorite($fid = NULL, $userID = NULL)
    {
        $tmpData = $this->read('user_id', $fid);
        if($tmpData['Favorite']['user_id'] == $userID)
        {
            $this->delete($fid);
        }
    }

}
?>