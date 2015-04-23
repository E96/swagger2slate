<?php

namespace e96\swagger;


use IteratorAggregate;

class Parameters extends Object implements IteratorAggregate
{
    /**
     * @var Parameter[]
     */
    protected $parameters = [];

    public function __set($name, $value)
    {
        $this->parameters[$value['name']] = new Parameter($value);
    }

    function __get($name)
    {
        return $this->parameters[$name];
    }

    public function getBodyObject()
    {
        $res = null;
        foreach ($this->parameters as $name => $parameter) {
            if ($parameter->in == 'body') {
                if (!is_array($res)) {
                    $res = [];
                }
                $res[$name] = $parameter->schema->getObject();
            }
        }
        
        return $res;
    }

    public function getHeaderParameters()
    {
        $res = null;
        foreach ($this->parameters as $name => $parameter) {
            if ($parameter->in == 'header') {
                if (!is_array($res)) {
                    $res = [];
                }
                $res[$name] = $parameter;
            }
        }

        return $res;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }
}