<?php

namespace e96\swagger;


class Schema extends Object
{
    /**
     * @var string
     */
    public $type = 'object';
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var Schema
     */
    public $items;
    /**
     * @var Schema[]
     */
    public $properties = [];
    /**
     * @var string[]
     */
    public $required;
    
    protected $isRef = false;

    public function setItems($value)
    {
        $this->items = new Schema($value);
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toString($md = true)
    {
        if ($this->title) {
            return $this->isRef && $md ? "[$this->title](#".strtolower($this->title).")" : $this->title;
        } elseif ($this->type == 'array') {
            return 'array['.$this->items->toString($md).']';
        } else {
            return $this->type;
        }
    }

    public function setRef($value)
    {
        $value = str_replace('#/', '', $value);
        $pathEntries = explode('/', $value);

        $array = Swagger::$root;
        foreach ($pathEntries as $entry) {
            $array = $array[$entry];
        }
        
        if (!array_key_exists('title', $array)) {
            $array['title'] = end($pathEntries);
            $array['isRef'] = true;
        }
        $this->setConfig($array);
    }

    public function setAllOf($value)
    {
        foreach ($value as $schema) {
            $this->setConfig($schema);
        }
    }

    public function setProperties($value)
    {
        foreach ($value as $name => $obj) {
            $this->properties[$name] = new Schema($obj);
        }
    }

    public function getObject()
    {
        if ($this->properties) {
            $res = [];
            foreach ($this->properties as $name => $schema) {
                if ($schema->type == 'object') {
                    $res[$name] = $schema->getObject();
                } elseif ($schema->type == 'array') {
                    $res[$name] = [$schema->items->getObject()];
                } else {
                    $res[$name] = $schema->type;
                }
            }
            return $res;
        } else {
            if ($this->type == 'object') {
                return $this->getObject();
            } elseif ($this->type == 'array') {
                return [$this->items->getObject()];
            } else {
                return $this->type;
            }
        }
    }

    public function getPropertiesDescription()
    {
        $res = [];
        foreach ($this->properties as $name => $schema) {
            $res[$name] = $schema->description ? $schema->description : (string)$schema;
        }
        
        return $res;
    }
}