<?php

use Symfony\Component\HttpFoundation\Request;
use PokeStore\Form\Type\UserType;
use PokeStore\Domain\User;

// Home page
$app->get('/', function () use ($app) {
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('index.html.twig', array('types' => $types));
});

// Details for a pokemon
$app->get('/pokemons/{id}', function($id) use ($app) {
    $pokemon = $app['dao.pokemon']->find($id);
    return $app['twig']->render('pokemon.html.twig', array('pokemon' => $pokemon));
});
// List of all pokemon
$app->get('/pokemons/', function() use ($app) {
    $pokemons = $app['dao.pokemon']->findAll();
    return $app['twig']->render('pokemons.html.twig', array('pokemons' => $pokemons));
});

//List of pokemon's image by type
$app->post('/results/', function(Request $request) use ($app) {
    $TypeId = $request->request->get('type');
    $pokemons = $app['dao.pokemon']->findAllByType($TypeId);
    return $app['twig']->render('results.html.twig', array('pokemons' => $pokemons));
});


// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');  // named route so that path('login') works in Twig templates
// Personal info

// Admin zone

$app->get('/admin', function() use ($app) {
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('admin.html.twig', array(
                'users' => $users));
});
// Add a user
$app->match('/user/add', function(Request $request) use ($app) {
    $user = new User();
    $userForm = $app['form.factory']->create(new UserType(), $user);
    $userForm->handleRequest($request);
    if ($userForm->isValid()) {
        $salt = substr(md5(time()), 0, 23);
        $user->setSalt($salt);
        $plainPassword = $user->getPassword();
        // find the default encoder
        $encoder = $app['security.encoder.digest'];
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
    }
    return $app['twig']->render('user_form.html.twig', array(
                'title' => 'New user',
                'userForm' => $userForm->createView()));
});

// Edit an existing user
$app->match('/user/{id}/edit', function($id, Request $request) use ($app) {
    $user = $app['dao.user']->find($id);
    $userForm = $app['form.factory']->create(new UserType(), $user);
    $userForm->handleRequest($request);
    if ($userForm->isValid()) {
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
    }
    return $app['twig']->render('user_form.html.twig', array(
                'title' => 'Edit user',
                'userForm' => $userForm->createView()));
});

// Remove a user
$app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.comment']->deleteAllByUser($id);
    // Delete the user
    $app['dao.user']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
    return $app->redirect('/admin');
});


