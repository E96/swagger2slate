<?php

/** @var \Composer\Autoload\ClassLoader $autoLoader */
$autoLoader = require_once __DIR__ . '/vendor/autoload.php';
$autoLoader->setPsr4('m8rge\\', __DIR__ . '/src');

$app = new Silly\Application('swagger2slate', '@version@');
$containerBuilder = new \DI\ContainerBuilder();
$container = $containerBuilder->build();
$app->useContainer($container, true, true);

$container->set('app', $app);

$app->command('convert inputFile [-o|--outputFile=]', \m8rge\ConvertCommand::class)
    ->descriptions('Converts swagger json or yml to slate markdown file', [
        'inputFile' => 'swagger{.json|.yml} file path',
        '--outputFile' => 'source/index.html.md file path',
    ]);
$app->run();