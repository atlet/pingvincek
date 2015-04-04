<?php

class Config extends AppModel
{

    var $name = 'Config';
    var $primaryKey = 'name';
    var $validate = array('name' => 'notEmpty');

    function get($name, $default = null)
    {
        $config = $this->findByName($name);
        if (isset($config['Config']['value']))
            return $config['Config']['value'];
        else
            return $default;
    }

    function store($name, $value)
    {
        return $this->save(array('name' => $name, 'value' => $value));
    }

}

?>