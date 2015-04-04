<?php

class Visit extends AppModel
{

    var $name = 'Visit';

    public function saveVisit($user_id = NULL, $visitor_id = NULL)
    {
        if ($user_id && $visitor_id)
        {
            $tmpDataVisit = array();
            $tmpDataVisit['Visit']['user_id']    = $user_id;
            $tmpDataVisit['Visit']['visitor_id'] = $visitor_id;

            if ($this->save($tmpDataVisit))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

}

?>