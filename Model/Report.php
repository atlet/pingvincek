<?php

class Report extends AppModel
{

    var $name = 'Report';

    var $validate = array(
        'message' => array(
            'rule' => 'notEmpty',
            'message' => 'Prosim, vnesite sporočilo!'
        )
    );
    
    function afterFind($results, $primary = false) {
        foreach ($results as $key => $val) {
            if (isset($val['Report']['message'])) {
                $results[$key]['Report']['message'] = h($val['Report']['message']);
            }
            
            if (isset($val['Report']['comment'])) {
                $results[$key]['Report']['comment'] = h($val['Report']['comment']);
            }
        } 
	return $results;
    }
}

?>
