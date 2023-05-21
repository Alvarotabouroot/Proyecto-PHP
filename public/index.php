<?php 

    require_once __DIR__.'/../vendor/autoload.php';

    use Controllers\HomeController;
    use Controllers\HermanoController;
    use Controllers\UsersController;
    use Dotenv\Dotenv;
    use Lib\Router;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    session_start();
    

    //Cargar vista principal
    Router::add('GET', '/', function(){ return (new HomeController())->home();});

    //Cargar vista de opciones de administrador
    Router::add('GET', 'users/home', function(){ return (new UsersController())->home2();});

    //Cerrar sesion administrador
    Router::add('GET', 'users/logout', function(){ return (new UsersController())->logout();});

    //Login de un administrador
    Router::add('GET', 'users/login', function(){ return (new UsersController())->login();});
    Router::add('POST', 'users/login', function(){ return (new UsersController())->login();});

    //Registro de un administrador
    Router::add('GET', 'users/registrar', function(){ return (new UsersController())->registrar();});
    Router::add('POST', 'users/registrar', function(){ return (new UsersController())->registrar();});

    //Registro de un hermano
    Router::add('GET', 'users/registrarHermano', function(){ return (new UsersController())->registrarHermano();});
    Router::add('POST', 'users/registrarHermano', function(){ return (new UsersController())->registrarHermano();});

    //Login de un hermano 
    Router::add('GET', 'hermano/login', function(){ return (new HermanoController())->login();});
    Router::add('POST', 'hermano/login', function(){ return (new HermanoController())->login();});

    //Cambiar contraseña de un hermano
    Router::add('GET', 'hermano/cambiarPassword/:id', function($id){ return (new HermanoController())->cambiarPassword($id);});
    Router::add('POST', 'hermano/cambiarPassword/:id', function($id){ return (new HermanoController())->cambiarPassword($id);});

    //Editar datos del perfil 
    Router::add('GET', 'hermano/editarDatos/:id', function($id){return (new HermanoController())->editarDatos($id);});
    Router::add('POST', 'hermano/editarDatos/:id', function($id){return (new HermanoController())->editarDatos($id);});


    //Dar de baja a un hermano
    Router::add('GET', 'users/borrarHermano/:id', function($id){return (new UsersController())->borrarHermano($id);});
    Router::add('POST', 'users/borrarHermano/:id', function($id){return (new UsersController())->borrarHermano($id);});


    //Editar los datos de un hermano siendo administrador
    Router::add('GET', 'users/editarDatosHermano/:id', function($id){return (new UsersController())->editarDatos($id);});
    Router::add('POST','users/editarDatosHermano/:id', function($id){return (new UsersController())->editarDatos($id);});

    //Mostrar los datos de un hermano por su apellido
    Router::add('POST', 'users/mostrarHermano', function(){ return (new UsersController())->mostrarHermano();});

    //Mostrar listado hermanos
    Router::add('GET', 'users/mostrarTodosHermanos', function(){ return (new UsersController())->mostrarTodosHermanos();});

    //Cerrar sesion hermano
    Router::add('GET', 'hermano/logout', function(){(new HermanoController())->logout();});

    //Crear evento
    Router::add('GET', 'users/crearEvento', function(){ return (new UsersController())->crearEvento();});
    Router::add('POST', 'users/crearEvento', function(){ return (new UsersController())->crearEvento();});

    //Mostrar eventos para hermanos
    Router::add('GET', 'hermano/mostrarEventos', function(){ return (new HermanoController())->mostrarEventos();});

    //Mostrar eventos para administradores
    Router::add('GET', 'users/mostrarEventos', function(){ return (new UsersController())->mostrarEventos2();});

    //Sacar listado de participantes
    Router::add('GET', 'users/listado/:id', function($id){ return (new UsersController())->listado($id);});

    //Mostrar eventos en los que participo
    Router::add('GET', 'hermano/misEventos/:id', function($id){ return (new HermanoController())->misEventos($id);});
    Router::add('POST', 'hermano/misEventos/:id', function($id){ return (new HermanoController())->misEventos($id);});
    //Apuntarse a un evento
    Router::add('POST', 'hermano/apuntarseEvento', function(){ return (new HermanoController())->apuntarseEventos();});

    Router::dispatch();
?>
