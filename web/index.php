<?php

ini_set('display_errors', 1);
require_once __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
      'driver' => 'pdo_mysql',
      'dbname' => 'heroku_58f81519d0861be',
      'user' => 'bb75251cb2c1f9',
      'password' => '0b7d2b1c',
      'host'=> "us-cdbr-iron-east-01.cleardb.net",
    )
));

$app->register(new Silex\Provider\SessionServiceProvider, array(
    'session.storage.save_path' => dirname(__DIR__) . '/tmp/sessions'
));

$app->before(function(Request $request) use($app){
    $request->getSession()->start();
});

$app->get("/",function() use($app){
    return "INVALID_PARAMETERS";
});

$app->run();
?>