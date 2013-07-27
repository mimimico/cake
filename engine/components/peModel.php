<?php

/*
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peModel
 *  @Project: Proto Engine 3
 */

abstract class peModel extends peHttp
{
    protected $_data = array();
    protected $_cache = array();
    protected static $_viewdata = array();

    public function insert($params)
    {
        $this->_data = array_replace($this->_data, $params->extract());
    }
    
    public function __get($name) 
    {
        if ($result = @$this->_data[strtolower($name)]) {
            return $result;
        } else {
            return null;
        }
    }
    
    public function __set($name, $value) 
    {
        if (@$this->_data[strtolower($name)] = $value) {
            return true;
        } else {
            return false;
        }
    }   

    public function bind() 
    {
        return array($this, func_get_args());
    }
    
    function getParam($array, $id = 0)
    {
        if (is_array($array) && isset($array[$id])) {
            $element = $array[$id];
        } else {
            $element = 0;
        }
        return $element;
    }
    
    public function _recall($data)
    {
        if (isset($data[1]) && is_array($data[1])) {
            $params = $data[1];
            $name = "view_" . array_shift($params);
            if (is_callable(array($data[0], $name))) {
                if (isset($this->_cache[$name]) && !empty($this->_cache[$name])) {
                    return $this->_cache[$name];
                } else {
                    $this->_cache[$name] = $data[0]->$name($params);
                    return $this->_cache[$name];
                }
            }
        }
        return null;
    }
    
    public function _getdata()
    {
        return $this->_data;
    }
    
    public function query()
    {
        return new peQuery;
    }
}