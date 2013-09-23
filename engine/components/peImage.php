<?php

/*
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peImage
 *  @Project: Proto Engine 3
 */

class peImage 
{
    public $image;
    public $name;
    public $required_size;
    
    protected static $types = array(
        "image/gif", "image/jpeg", "image/png", "image/pjpeg"
    );
    protected static $extensions = array(
        "jpg", "jpeg", "gif", "png"
    );
    
    public function __construct($array, $size = 20000)
    {
        $this->image = (object)$array;
        $this->required_size = $size;
    }
    
    public function save($name = null)
    {
        if ($this->image->error) return false;
        if (!$name) {
            $name = $this->image->name;
        } else {
            $name .= "." . $this->getExtension();
        }
        if ($this->checkType() && $this->checkExtension()) {
            if ($this->image->size <= $this->required_size) {
                $path = pePath_Uploads . $name;
                $this->name = $name;
                return move_uploaded_file($this->image->tmp_name, $path);
            } else {
                peHttp::error(7);
            }
        }
    }
    
    public function getUrl()
    {
        return peProject::getHost() . peDir_Uploads . us . $this->name;
    }
    
    public function getPath()
    {
        return peDir_Uploads . $this->name;
    }
    
    protected function checkType()
    {
        return in_array($this->image->type, self::$types);
    }
    
    protected function getExtension()
    {
        $ext = explode(".", $this->image->name);
        return end($ext);
    }
    
    protected function checkExtension() 
    {
        return in_array($this->getExtension(), self::$extensions);
    }
    
    public static function rearrange($arr)
    {
        $new = array();
        foreach($arr as $key => $all) {
            foreach($all as $i => $val) {
                $new[$i][$key] = $val;    
            }    
        }
       return $new;
    }
}