<?php

namespace m8rge\swagger;


class Object // implements ArrayAccess
{
    public function __construct($config = [])
    {
        $this->setConfig($config);
        $this->init();
    }

    public function init()
    {
        
    }

    public function setConfig($config = [])
    {
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                $this->__set($name, $value);
            }
        }
    }
    
    public function __set($name, $value)
    {
        if ($name == '$ref') {
            $name = 'ref';
        }
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->$name = $value;
        }
    }

//    public function offsetExists($offset)
//    {
//        property_exists($this, $offset);
//    }
//
//    public function offsetGet($offset)
//    {
//        return $this->$offset;
//    }
//
//    public function offsetSet($offset, $value)
//    {
//        $this->__set($offset, $value);
//    }
//
//    public function offsetUnset($offset)
//    {
//        $this->__set($offset, null);
//    }
}