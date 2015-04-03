<?php

namespace e96\swagger;


class Response extends Object
{
    /**
     * @var Schema
     */
    public $schema;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $examples;

    public function setSchema($value)
    {
        $this->schema = new Schema($value);
    }

    public function __toString()
    {
        return (string)$this->schema;
    }
}