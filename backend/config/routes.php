<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
use Zend\Diactoros\Response\JsonResponse;
//$app->get('/', App\Action\HomePageAction::class, 'home');
$app->get('/api/ping', App\Action\PingAction::class, 'api.ping');

$app->post('/login',  function(){
    return new JsonResponse(['token' => time()]);
}, 'login');

// Usuários

$app->get('/usuarios', ContatoModulo\Http\Acao\ListarUsuarioAcao::class, 'usuarios');
$app->get('/usuarios/{id}', ContatoModulo\Http\Acao\ObterUsuarioAcao::class, 'usuarios.get');
$app->post('/usuarios', ContatoModulo\Http\Acao\CadastrarUsuarioAcao::class, 'usuarios.create');
$app->put('/usuarios/{id}', ContatoModulo\Http\Acao\AtualizarUsuarioAcao::class, 'usuarios.put');
$app->delete('/usuarios/{id}', ContatoModulo\Http\Acao\ExcluirUsuarioAcao::class, 'usuarios.delete');

// Login
$app->post('/login', \ContatoModulo\Http\Acao\LoginAcao::class, 'login');
