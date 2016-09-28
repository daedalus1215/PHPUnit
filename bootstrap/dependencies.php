<?php


// lets create an injector
$injector = new \Auryn\Injector();

$signer = new \Kunststube\CSRFP\SignatureGenerator(getenv('CSRF_SECRET'));
$blade = new BladeInstance(getenv('VIEWS_DIRECTORY'), getenv('CACHE_DIRECTORY'));



$injector->make('Acme\Http\Request');
$injector->make('Acme\Http\Response');
$injector->make('Acme\Http\Session');



$injector->share($signer);
$injector->share($blade);
$injector->share('Acme\Http\Request');
$injector->share('Acme\Http\Response');
$injector->share('Acme\Http\Session');



return $injector;

