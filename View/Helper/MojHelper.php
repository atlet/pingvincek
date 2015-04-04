<?php

App::uses('AppHelper', 'View/Helper');

class MojHelper extends AppHelper {

    function GetAge($p_strDate)
    {
	list($Y,$m,$d)    = explode("-",$p_strDate);
	return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    }

}

?>
