<?php

class Support extends AppModel
{

	var $name = 'Support';
	public $useTable = false;

	var $validate = array
		(
		'email' => array
			(
			'notEmpty' => array
				(
				'rule'    => 'notEmpty',
				'message' => 'Prosim, vnesite vaš email!'
			),
			'email' => array(
				'rule'    => array('email', true),
				'message' => 'Prosim, vnesite veljaven email!'
			)
		),
		'subject'    => array
			(
			'notEmpty' => array
				(
				'rule'    => 'notEmpty',
				'message' => 'Prosim, vnesite zadevo!'
			)
		),
		'message' => array
			(
			'notEmpty' => array
				(
				'rule'      => 'notEmpty',
				'message'   => 'Prosim, vnesite sporočilo!'
			)
		)
	);

}
?>