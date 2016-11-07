<?php

namespace m8rge\swagger;


class Parameter extends Object
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $in;
    /**
     * @var bool
     */
    public $required;
    /**
     * @var string
     */
    public $description;
    /**
     * @var Schema
     */
    public $schema;
    /**
     * @var string
     */
    public $type;
    /**
     * todo: convert to limited schema
     * @var Schema
     */
    public $items;

    public function setSchema($value)
    {
        $this->schema = new Schema($value);
    }

    public function setItems($value)
    {
        $this->items = new Schema($value);
    }
    
    public function __toString()
    {
        if ($this->in == 'body') {
            return (string)$this->schema;
        } else {
            if ($this->type != 'array') {
                return $this->type;
            } else {
                return "array[$this->items]";
            }
        }
    }
}