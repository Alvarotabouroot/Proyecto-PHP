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

    public function registrar(){
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

    public function registrarHermano(){
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

                if($edicion){
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
    public function mostrarTodosHermanos(){
        $hermanos = $this->apiHermano->buscarTodosHermanos();
        $hermanos = json_decode($hermanos);
        $this->pages->render('hermano/mostrarListadoHermanos', ['hermanos' => $hermanos]);
    }

    public function mostrarHermano(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['apellidos'])){
                $hermano = $this->apiHermano->buscarHermano($_POST['apellidos']);
                $hermano = json_decode($hermano);
                $this->pages->render('hermano/mostrarHermano', ['hermanos' => $hermano]);
            }
        }
    }

    public function logout(){
        if($_SESSION['admin']){
            unset($_SESSION['admin']);
            $this->pages->render('users/login');
        }
    }

    public function crearEvento(){
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
    
    public function listado($id){
        $id = json_encode($id);
        $lineasEvento = $this->apiAsistentesEvento->buscarEvento($id);
        $lineasEvento = json_decode($lineasEvento);
        if($lineasEvento){
            $arrayAux = [];
            foreach($lineasEvento as $linea){
                $hermano = $this->apiHermano->buscarHermanoID($linea->hermano_id);
                $hermano = json_decode($hermano);
                $arrayAux[] = $hermano;
            }
            $this->pages->render('evento/listado', ['listado' => $arrayAux]);
        }
    }

    public function borrarHermano($id){
        $eventos = $this->apiAsistentesEvento->misEventos($id);
        $eventos = json_decode($eventos); 
        
        if($eventos){
            foreach($eventos as $evento){
                $eventoid = $evento->evento_id;
                $eventoid = json_encode($eventoid);
                $hermanoid = $evento->hermano_id;
                $hermanoid = json_encode($hermanoid);
                $this->apiAsistentesEvento->borrarLinea($hermanoid, $eventoid);
            }
        }
        
        $numParticipantes = $this->apiAsistentesEvento->verNumParticipantes($eventoid);
        $numParticipantes = json_encode($numParticipantes);
        $this->apiEvento->actualizarNumParticipantes($numParticipantes, $eventoid);


        $id = json_encode($id);
        $this->apiHermano->borrarHermano($id);
        $this->home2();
    }
    public function home2(){
        $this->pages->render('users/opciones');
    }
}


