<?php

$autoLoader = require_once 'vendor/autoload.php';
$autoLoader->addPsr4('m8rge\\', __DIR__. '/src');

$app = new Silly\Application('swagger2slate', '@version@');
$containerBuilder = new \DI\ContainerBuilder();
$container = $containerBuilder->build();
$app->useContainer($container, true, true);

$container->set('app', $app);

$app->command('convert inputFile [-o|--outputFile=]', \m8rge\ConvertCommand::class)
    ->descriptions('Converts swagger.json to slate markdown file', [
        'inputFile' => 'swagger.json file path',
        '--outputFile' => 'source/index.md file path',
    ]);
$app->run();