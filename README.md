Swagger to slate converter
==========================

# How to document your php api

1. Install Php annotations plugin for PhpStorm (Preferences → Plugins → Browse repositories → PHP Annotation → Install Plugin)
2. Install swagger-php (`composer require zircote/swagger-php=2.*@dev`)
3. Write annotations ([Swagger-php getting started](https://github.com/zircote/swagger-php/blob/2.x/docs/Getting%20started.md))
4. Convert annotations to swagger.json (`./vendor/bin/swagger . -o ./swagger.json`)
5. Download swagger2slate ([]())
5. Convert swagger.json to slate markdown (`cat ./swagger.json | ./swagger2slate.phar > index.md`)
6. Use slate to generate static html documentation ([Getting Started with Slate](https://github.com/tripit/slate#getting-started-with-slate))

* [Swagger specification 2.0](https://github.com/swagger-api/swagger-spec/blob/master/versions/2.0.md)
* [Swagger explained](http://bfanger.github.io/swagger-explained)
* [Doctrine annotations](http://doctrine-common.readthedocs.org/en/latest/reference/annotations.html)
* [Swagger-php getting started](https://github.com/zircote/swagger-php/blob/2.x/docs/Getting%20started.md)
* [Slate](https://github.com/tripit/slate)