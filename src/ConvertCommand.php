<?php

namespace m8rge;

use m8rge\swagger\Parameters;
use m8rge\swagger\Schema;
use m8rge\swagger\Swagger;
use Silly\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;

class ConvertCommand
{
    function __invoke(Application $app, InputInterface $input, OutputInterface $output, $inputFile, $outputFile)
    {
        $config = json_decode(file_get_contents($inputFile), true);
        if ($config['swagger'] != '2.0') {
            $output->writeln('swagger version must be 2.0');
            return 1;
        }
        Swagger::$root = $config;
        $swagger = new Swagger($config);

        $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
        $twig = new Twig_Environment($loader);
        $twig->addFilter(new Twig_SimpleFilter('newSchema', function ($data) {
            return new Schema($data);
        }));
        $twig->addFilter(new Twig_SimpleFilter('newParameters', function ($data) {
            return new Parameters($data);
        }));
        $twig->addFilter(new Twig_SimpleFilter('textStatus', [$this, 'httpTextStatus']));

        $slate = $twig->render('slate.twig', array(
            'api' => $swagger,
        ));

        if (!empty($outputFile)) {
            file_put_contents($outputFile, $slate);
        } else {
            $output->writeln($slate);
        }

        return 0;
    }

    public function httpTextStatus($httpStatus)
    {
        static $statusTexts = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            208 => 'Already Reported',
            226 => 'IM Used',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Reserved for WebDAV advanced collections expired proposal',
            426 => 'Upgrade required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates (Experimental)',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
        ];
        
        if (array_key_exists($httpStatus, $statusTexts)) {
            return $statusTexts[$httpStatus];
        } else {
            return '';
        }
    }
}