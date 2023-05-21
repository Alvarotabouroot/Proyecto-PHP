<?php 

namespace Controllers;
use Models\Evento;
use Lib\ResponseHttp;
use Lib\Pages;
use Lib\Security;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiEventoController{
    
    private Evento $evento;

    public function __construct()
    {
        $this->evento = new Evento();
    }

    public function crearEvento($data){
        $data = json_decode($data);
        $this->evento->setNombre($data->nombre);
        $this->evento->setFecha($data->fecha);
        $this->evento->setNumParticipantes(0);
        
        $result = $this->evento->crearEvento();
        
        if($result){
            ResponseHttp::statusMessage(202,'Evento registrado');
            
        }else{
            ResponseHttp::statusMessage(400,'No se ha podido registrar el evento');
        }
    }

    public function mostrarEventos(){
        $eventos = $this->evento->mostrarEventos();
        
        if($eventos){
            ResponseHttp::statusMessage(202,'Todos los eventos han sido cargados');
            
        }else{
            ResponseHttp::statusMessage(206,'No se han podido cargar todos los eventos');
        }
        
        $eventos = json_encode($eventos);
        return $eventos;
    }

    public function actualizarNumParticipantes($num, $eventoid){
        $num = json_decode($num); 
        $eventoid = json_decode($eventoid);
        $actualizacion = $this->evento->actualizarNumParticipantes($num, $eventoid);
        if($actualizacion){
            ResponseHttp::statusMessage(202,'Actualizado');
            
        }else{
            ResponseHttp::statusMessage(400,'No se han podido actualizar');
        }
    }

    public function buscarEvento($id){
        $id = json_decode($id);
        $eventos = $this->evento->buscarEvento($id);

        if($eventos){
            ResponseHttp::statusMessage(202,'Evento cargado');
            
        }else{
            ResponseHttp::statusMessage(400,'No se han podido actualizar');
        }
        $eventos = json_encode($eventos);
        return $eventos;
    }

    
    
}