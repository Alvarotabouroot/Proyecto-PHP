<?php

namespace Controllers;
use Controllers\ApiEventoController;
use Controllers\ApiHermanoController;
use Controllers\ApiAsistentesEventoController;
use Lib\Pages;


class HermanoController{
    private ApiHermanoController $apiHermano;
    private ApiEventoController $apiEvento;
    private ApiAsistentesEventoController $apiAsistentesEvento;
    private Pages $pages;

    public function __construct(){
        $this->apiHermano = new ApiHermanoController();
        $this->apiEvento = new ApiEventoController();
        $this->apiAsistentesEvento = new ApiAsistentesEventoController();
        $this->pages = new Pages();
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                //Este fragmento de codigo se encarga de hacer el login con los datos obtenidos a traves del formulario
                $data = $_POST['data'];
                $data = json_encode($data);
                $hermano = $this->apiHermano->login($data);
                
                //------------------------------------------------------------------------------------------
                //Este fragmento de codigo se encarga de pasarle a la vista los datos del hermano
                if($hermano){
                    $this->pages->render('hermano/perfil', ['hermano' => $hermano]);
                //------------------------------------------------------------------------------------------
                //Este fragmento de codigo se produce cuando no se puede hacer el login del hermano y por tanto nos vuelve a sacar la vista de login
                }else{
                    $this->pages->render('home/index');
                }
                //------------------------------------------------------------------------------------------
            }
        //Se produce cuando el metodo es GET y nos saca la vista del login
        }else{
            $this->pages->render('hermano/login');
        }
    }

    public function logout(){ //Cerrar sesion del hermano
        if(isset($_SESSION['identity'])){
            unset($_SESSION['identity']);
            $this->pages->render('home/index');
        }

        if(isset($_SESSION['registrado'])){
            unset($_SESSION['registrado']);
        }
    }


    public function cambiarPassword($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['contraseña'])){
                //Este fragmento de codigo realiza la funcion de cambiar la contraseña que se ha obtenido por el formulario, ademas le pasa el id del hermano para poder cambiarsela a el.
                $id = json_encode($id);
                $contraseña = $_POST['contraseña'];
                $contraseña = json_encode($contraseña);
                if($contraseña != ''){
                    $cambioOK = $this->apiHermano->cambiarPassword($id, $contraseña);
                }
                
                //--------------------------------------------------------------------------------------------

                //Este fragmento de codigo se produce cuando se ha podido cambiar la contraseña y por tanto cargamos los datos del hermano y se los mandamos a la vista del perfil
                if($cambioOK){
                    $id = json_decode($id);
                    $hermano = $this->apiHermano->buscarHermanoID($id);
                    $hermano = json_decode($hermano);
                    $this->pages->render('hermano/perfil', ['hermano'=>$hermano]);
                //--------------------------------------------------------------------------------------------
                //Este fragmento de codigo se produce cuando no se ha podido cambiar la contraseña y por tanto nos devuelve al formulario de cambiar la contraseña
                }else{
                    $this->pages->render('hermano/cambiarPassword', ['id'=>$id]);
                }
                //---------------------------------------------------------------------------------------------
            }
        //Este fragmento de codigo se produce cuando el metodo es GET y por tanto nos envia al formulario de cambiar la contraseña
        }else{
            $this->pages->render('hermano/cambiarPassword', ['id'=>$id]);
        }
        //-----------------------------------------------------------------------------------------------------
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

                //Este fragmento de codigo se produce cuando se han editado correctamente los datos y nos devuelve los datos del hermano que serán pasados a la vista del perfil
                if($edicion){
                    $id = json_decode($id);
                    $hermano = $this->apiHermano->buscarHermanoID($id);
                    $hermano = json_decode($hermano);
                    $this->pages->render('hermano/perfil', ['hermano'=>$hermano]);
                //-----------------------------------------------------------------------------------------
                //Este fragmento de codigo se produce cuando no se ha podido editar correctamente los datos por alguna razón y por tanto nos vuelve a sacar el formulario de edicion con los datos del hermano
                }else{
                    $id = json_decode($id);
                    $hermano = $this->apiHermano->buscarHermanoID($id);
                    $hermano = json_decode($hermano);
                    $this->pages->render('hermano/editarDatos', ['hermano'=>$hermano]);
                }
                //-------------------------------------------------------------------------------------------
            }
        //Este fragmento de codigo se produce cuando el metodo es GET y lo que hace es cargar los datos del hermano para pasarselo a la vista de edicion
        }else{
            $id = json_decode($id);
            $hermano = $this->apiHermano->buscarHermanoID($id);
            $hermano = json_decode($hermano);
            $this->pages->render('hermano/editarDatos', ['hermano'=>$hermano]);
        }
        //----------------------------------------------------------------------------------------------------
    }


    public function mostrarEventos(){
        //Este codigo se encarga de obtener todos los eventos disponibles y pasarselos a la vista para mostrarlos
        $eventos = $this->apiEvento->mostrarEventos();
        $eventos = json_decode($eventos);
        $this->pages->render('evento/mostrarEventos', ['eventos' => $eventos]);
    }


    public function apuntarseEventos(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['data'])){
                //Este fragmento de codigo realiza la funcion de crear una fila en la tabla asistentesEventos usando el id del hermano y del evento que viene en data. Antes de apuntarlo al evento comprueba si ya está registrado para que no pueda 
                $data = $_POST['data'];
                $data = json_encode($data);
                $registrado = $this->apiAsistentesEvento->buscarParticipante($data);
                $registrado = json_decode($registrado);

                if($registrado == false){
                    $_SESSION['registrado'] = 'Te has registrado correctamente';
                    $this->apiAsistentesEvento->apuntarseEvento($data);
                //--------------------------------------------------------------------------------------------
                    //Este fragmento de codigo realiza la funcion de buscar el numero de participantes que tiene un evento para así poder actualizar los datos de participantes del evento
                    $data = json_decode($data); 
                    $eventoid = $data->idevento;
                    $eventoid = json_encode($eventoid);
                    $numParticipantes = $this->apiAsistentesEvento->verNumParticipantes($eventoid);
                    $numParticipantes = json_encode($numParticipantes);
                    $this->apiEvento->actualizarNumParticipantes($numParticipantes, $eventoid);

                    //----------------------------------------------------------------------------------------

                    //Este fragmento de codigo realiza la funcion de cargar los datos del hermano para pasarselo a la vista del perfil
                    $hermano = $this->apiHermano->buscarHermanoID($data->idhermano);
                    $hermano = json_decode($hermano);
                    $this->pages->render('hermano/perfil', ['hermano'=>$hermano]);
                    //---------------------------------------------------------------------------------------
                }else{
                    $_SESSION['registrado'] = 'No te puedes registrar al estar ya registrado';
                    $data = json_decode($data);
                    $hermano = $this->apiHermano->buscarHermanoID($data->idhermano);
                    $hermano = json_decode($hermano);
                    $this->pages->render('hermano/perfil', ['hermano'=>$hermano]);
                }
            }
        }
    }

    public function misEventos($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $hermano = $this->apiHermano->buscarHermanoID($id);
            $hermano = json_decode($hermano);
            $this->pages->render('hermano/perfil', ['hermano'=>$hermano]);
        }else{
            $eventos = $this->apiAsistentesEvento->misEventos($id);
            $eventos = json_decode($eventos); 
            if($eventos){
                $arrayAux = [];
                foreach($eventos as $evento){
                    $evento = $this->apiEvento->buscarEvento($evento->evento_id);
                    $evento = json_decode($evento);
                    $arrayAux[] = $evento;
                }
                
                $this->pages->render('hermano/misEventos', ['eventos' => $arrayAux]);
            }
        }
    }
}
