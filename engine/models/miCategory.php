<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miCategory
 *  @Project: Proto Engine 3
 */


class miCategory extends peModel 
{
    private static $data = array();
    
    protected function getTableData() 
    {
        self::$data = $this->query()->select()->table("categories")->run();
    }
    
    public function getCategories()
    {
        if (empty(self::$data)) $this->getTableData();
        $result = array();
        foreach(self::$data as $obj) {
            if (!$obj->parent) {
                $obj->name = peLanguage::get($obj->name);
                $result[$obj->uid] = $obj;
            }
        }
        return $result;
    }
    
    public function getSubCategories()
    {
        if (empty(self::$data)) $this->getTableData();
        $result = array();
        foreach(self::$data as $obj) {
            if ($obj->parent) {
                $obj->name = peLanguage::get($obj->name);
                $result[$obj->uid] = $obj;
            }
        }
        return $result;
    }
    
    public function view_displaySubCategories($params)
    {
        $id = $this->getParam($params);
        $type = $this->getParam($params, 1);
        if ($type) {
            $cat = $this->getSubCategories();
            $id = $cat[$id]->parent;
        }
        $data = array();
        foreach($this->getSubCategories() as $sub) {
            if ($sub->parent == $id) {
                $data[] = $sub;
            }
        }
        return $data;
    }
    
    public function view_listCategoryWithSub()
    {
        $c = $this->getCategories();
        $s = $this->getSubCategories();
        foreach($c as $category) {
            $a = array();
            foreach($s as $subcat) {
                if ($subcat->parent == $category->uid) {
                    $a[] = $subcat;
                }
            }
            $category->subcat = $a;
        }
        return $c;
    }
    
    public function view_displayCategories()
    {
        return $this->getCategories();
    }
}