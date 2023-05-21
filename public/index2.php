<?php 
// AQUI LO MISMO QUE YA TENÍAMOS

//USANDO EL NUEVO ROUTER. ALGUNOS EJEMPLOS
require_once __DIR__.'/../vendor/autoload.php';

    use Controllers\HomeController;
    use Controllers\HermanoController;
    use Controllers\UsersController;
    use Dotenv\Dotenv;
    use Lib\Router2;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    session_start();

$router = new Router2();

// Login
$router->get('/', function(){ return (new HomeController())->home();});
$router->get('users/login', function(){ return (new UsersController())->login();});
$router->post('users/login', function(){ return (new UsersController())->login();});
$router->get('/users/home', function(){ return (new UsersController())->home2();});
//No olvides esta parte
$router->comprobarRutas();