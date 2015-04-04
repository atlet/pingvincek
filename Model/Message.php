<?php

class Message extends AppModel
{

    var $name = 'Message';
    var $actsAs = array('Containable');
    var $belongsTo = array(
        'Fromuser' => array('className' => 'User',
            'foreignKey' => 'from_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Touser' => array('className' => 'User',
            'foreignKey' => 'to_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $validate = array(
        'subject' => array(
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        ),
        'message' => array(
            'rule' => 'notEmpty',
            'message' => 'To polje ne sme biti prazno!'
        )
    );

    function afterFind($results, $primary = false)    {
        foreach ($results as $key => $val)
        {
            if (isset($val['Message']['message']))
            {
                $results[$key]['Message']['message'] = h($val['Message']['message']);
            }
            
            if (isset($val['Message']['subject']))
            {
                $results[$key]['Message']['subject'] = h($val['Message']['subject']);
            }
        } return $results;
    }

    function spremeniStatus($id = NULL, $statusID = NULL)
    {
        if (isset($id) && isset($statusID))
        {
            $statusTMP = $this->read('status', $id);
            if ($statusTMP['Message']['status'] < $statusID)
            {
                $this->read(null, $id);
                $this->set(array(
                    'status' => $statusID
                ));
                $this->save();
            }
        }
    }

    function deleteMessage($messageID = NULL, $userID = NULL)
    {
        if (isset($messageID) && isset($userID))
        {
            $messageTMP = $this->read(array("from_user_id", "to_user_id"), $messageID);
            if ($messageTMP['Message']['from_user_id'] == $userID)
            {
                $this->read(NULL, $messageID);
                $this->set(array('fromUserDelete' => 1));
                $this->save();
            }
            if ($messageTMP['Message']['to_user_id'] == $userID)
            {
                $this->read(NULL, $messageID);
                $this->set(array('toUserDelete' => 1));
                $this->save();
            }
        }
    }

}

?>