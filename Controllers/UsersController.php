<?php 

namespace Controllers;
use Controllers\ApiUsersController;
use Controllers\ApiHermanoController;
use Controllers\ApiEventoController;
use Controllers\ApiAsistentesEventoController;
use Lib\Pages;

class UsersController{
    private ApiUsersController $apiUsers;
    private ApiHermanoController $apiHermano;
    private ApiEventoController $apiEvento;
    private ApiAsistentesEventoController $apiAsistentesEvento;
    private Pages $pages;

    public function __construct(){
        $this->apiUsers = new ApiUsersController();
        $this->apiHermano = new ApiHermanoController();
        $this->apiEvento = new ApiEventoController();
        $this->apiAsistentesEvento = new ApiAsistentesEventoController();
        $this->pages = new Pages();
    }

    /*-------------------------------- FUNCIONES BASICAS ADMINISTRADOR ---------------------------------*/

    
    public function login(){ //Login de administradores
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data'];
                $data = json_encode($data);
                $logueado = $this->apiUsers->login($data); //Devuelve true si se hace el login
                //Estructura de control para el login
                if($logueado){
                    $this->home2(); //Carga la vista de las opciones del administrador
                }else{
                    $this->pages->render('users/login'); //Sino se hace el login te vuelve a pedir el login
                }
                //------------------------------------------------------------------------------  
            }
        }else{
            $this->pages->render('users/login');
        }
    }

    public function registrar(){ //Registro de un administrador
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data'];
                $data = json_encode($data);
                $this->apiUsers->registrar($data); 
                $this->home2();
            }
        }else{
            $this->pages->render('users/registrar');
        }
    }

    public function logout(){ //Cerrar sesion de un administrador
        if($_SESSION['admin']){
            unset($_SESSION['admin']);
            $this->pages->render('home/index');
        }
    }

    /*------------------------ FUNCIONES ADMINISTRADOR SOBRE LA TABLA HERMANOS-------------------------*/ 


    public function registrarHermano(){ //Registro de un hermano
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data'];
                $data = json_encode($data);
                $this->apiHermano->registrar($data); 
                $this->home2();
                
            }
        }
    }

    public function editarDatos($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                //Este fragmento de codigo se encarga de recibir todos los datos que hayan sido modificados (o no) del formulario y editarlos
                $data = $_POST['data'];
                $data = json_encode($data);
                $id = json_encode($id);
                $edicion = $this->apiHermano->editarDatos($id, $data);
                //---------------------------------------------------------------------------------------------
                if($edicion){ //Si$edicion devuelve true nos vuelve a la pagina de opciones del administrador
                    $this->pages->render('users/opciones');
                }
            }
        //Este fragmento de codigo se produce cuando el metodo es GET y lo que hace es cargar los datos del hermano para pasarselo a la vista de edicion
        }else{
            $id = json_decode($id);
            $hermano = $this->apiHermano->buscarHermanoID($id);
            $hermano = json_decode($hermano);
            $this->pages->render('users/editarDatosHermano', ['hermano'=>$hermano]);
        }
        //----------------------------------------------------------------------------------------------------
    }

    public function mostrarTodosHermanos(){ //Funcion para cargar todos los hermanos y pasarselos a la vista
        $hermanos = $this->apiHermano->buscarTodosHermanos();
        $hermanos = json_decode($hermanos);
        $this->pages->render('hermano/mostrarListadoHermanos', ['hermanos' => $hermanos]);
    }

    public function mostrarHermano(){ //Funcion para mostrar un hermano a través de su apellido
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['apellidos'])){
                $hermano = $this->apiHermano->buscarHermano($_POST['apellidos']);
                $hermano = json_decode($hermano);
                $this->pages->render('hermano/mostrarHermano', ['hermanos' => $hermano]);
            }
        }
    }

    public function borrarHermano($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
        }
        //Este fragmento de codigo se encarga de buscar todos lso eventos donde estoy apuntado
        $eventos = $this->apiAsistentesEvento->misEventos($id);
        $eventos = json_decode($eventos); 
        //------------------------------------------------------------------------------------
        //Este fragmento de codigo se encarga de eliminar el registro en el evento
        if($eventos){
            foreach($eventos as $evento){
                $eventoid = $evento->evento_id;
                $eventoid = json_encode($eventoid);
                $hermanoid = $evento->hermano_id;
                $hermanoid = json_encode($hermanoid);
                $this->apiAsistentesEvento->borrarLinea($hermanoid, $eventoid);
            }
        }
        //-------------------------------------------------------------------------------------
        //Este fragmento de codigo se encarga de actualizar el numero de participantes del evento
        $numParticipantes = $this->apiAsistentesEvento->verNumParticipantes($eventoid);
        $numParticipantes = json_encode($numParticipantes);
        $this->apiEvento->actualizarNumParticipantes($numParticipantes, $eventoid);
        //--------------------------------------------------------------------------------------
        //Este fragmento de codigo se encarga de borrar al hermano
        $id = json_encode($id);
        $this->apiHermano->borrarHermano($id);
        $this->home2();
        //---------------------------------------------------------------------------------------
    }

    /*------------------------- FUNCIONES DEL ADMINISTRADOR SOBRE LOS EVENTOS ----------------------------*/


    public function crearEvento(){ //Funcion para crear un evento
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                $data = $_POST['data'];
                $data = json_encode($data);
                $this->apiEvento->crearEvento($data); 
                $this->home2();
            }
        }else{
            $this->pages->render('evento/crearEvento');
        }
    }

    public function mostrarEventos2(){
        //Este codigo se encarga de obtener todos los eventos disponibles y pasarselos a la vista para mostrarlos
        $eventos = $this->apiEvento->mostrarEventos();
        $eventos = json_decode($eventos);
        $this->pages->render('evento/mostrarEventos2', ['eventos' => $eventos]);
    }
    
    public function listado($id){ //Funcion para sacar el listado de participantes de un evento
        //Este fragmento de codigo sirve para obtener todas las filas que haya donde el id sea el del evento
        $id = json_encode($id);
        $lineasEvento = $this->apiAsistentesEvento->buscarEvento($id);
        $lineasEvento = json_decode($lineasEvento);
        //---------------------------------------------------------------------------------------------------
        //Este fragmento de codigo nos sirve para a traves del id del hermano que hay en la fila, poder buscar y obtener los datos del hermano. Todos los hermanos que participen en este evento se guardan en un array auxiliar el cual es pasado a la vista.
        if($lineasEvento){
            $arrayAux = [];
            foreach($lineasEvento as $linea){
                $hermano = $this->apiHermano->buscarHermanoID($linea->hermano_id);
                $hermano = json_decode($hermano);
                $arrayAux[] = $hermano;
            }
            $this->pages->render('evento/listado', ['listado' => $arrayAux]);
        }
        //----------------------------------------------------------------------------------------------------
    }

    /*------------------------------------- FUNCIONES AUXILIARES --------------------------------------*/


    public function home2(){
        $this->pages->render('users/opciones');
    }
}


