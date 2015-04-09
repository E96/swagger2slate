<?php

namespace e96\swagger;


class Swagger extends Object
{
    public static $root;

    /**
     * @var string
     */
    public $swagger;
    
    /**
     * @var mixed
     */
    public $info;
    
    /**
     * @var string
     */
    public $basePath;

    /**
     * @var string[]
     */
    public $consumes;
    
    /**
     * @var string[]
     */
    public $produces;

    /**
     * @var mixed
     */
    public $paths;

    /**
     * @var mixed
     */
    public $definitions;

    /**
     * @var Response[]
     */
    public $responses;

    /**
     * @var SecurityScheme[]
     */
    public $securityDefinitions;

    /**
     * @var mixed
     */
    public $tags;
    
    public function setSecurityDefinitions($config)
    {
        $this->securityDefinitions = [];
        foreach ($config as $name => $innerConfig) {
            $this->securityDefinitions[$name] = new SecurityScheme($innerConfig);
        }
    }

    public function setResponses($config)
    {
        $this->responses = [];
        foreach ($config as $name => $innerConfig) {
            $this->responses[$name] = new Response($innerConfig);
        }
    }

    public function getPathsByTag($tag)
    {
        $methods = ['get', 'post', 'put', 'delete', 'options', 'head', 'path'];
        $res = [];
        foreach ($this->paths as $endPoint => $pathItem) {
            foreach ($methods as $method) {
                if (array_key_exists($method, $pathItem) && 
                    array_key_exists('tags', $pathItem[$method]) &&
                    in_array($tag, $pathItem[$method]['tags'])
                ) {
                    $res[$endPoint][$method] = $pathItem[$method];
                }
            }
        }
        
        return $res;
    }
}