<?php

// Register global error and exception handlers
use Symfony\Component\Debug\ErrorHandler;

ErrorHandler::register();

use Symfony\Component\Debug\ExceptionHandler;

ExceptionHandler::register();


// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new PokeStore\DAO\UserDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));
$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = "Something went wrong.";
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});
// Register error handler
use Symfony\Component\HttpFoundation\Response;


$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
// Register services.

$app['dao.type'] = $app->share(function ($app) {
    return new PokeStore\DAO\TypeDAO($app['db']);
});
$app['dao.pokemon'] = $app->share(function ($app) {
    $pokemonDAO = new PokeStore\DAO\PokemonDAO($app['db']);
    $pokemonDAO->setTypeDAO($app['dao.type']);
    return $pokemonDAO;
});

$app['dao.user'] = $app->share(function ($app) {
    return new PokeStore\DAO\UserDAO($app['db']);
});

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
            $twig->addExtension(new Twig_Extensions_Extension_Text());
            return $twig;
        }));
$app->register(new Silex\Provider\ValidatorServiceProvider());


