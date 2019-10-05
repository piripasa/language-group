<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

$config = require_once __DIR__ . '/config/app.php';

$serviceMapper = require_once  __DIR__  . '/config/console.php';

//Load IOC
$container = new \Illuminate\Container\Container();

//Bind Classes
foreach ((array)$config['bindings'] as $interface => $abstract) {
    $container->bind($interface, $abstract);
}

//Load service
$command = $container->makeWith(\App\Interfaces\CountryConsoleInterface::class, [
    'serviceMapper' => $serviceMapper
]);

//var_dump($argv);
$container->call([$command, 'print'], ['data' => $argv]);