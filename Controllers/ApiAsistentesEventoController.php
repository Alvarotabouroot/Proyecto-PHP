<?php 

namespace Controllers;
use Models\AsistentesEventos;
use Lib\ResponseHttp;

class ApiAsistentesEventoController{
    
    private AsistentesEventos $asistentesevento;

    public function __construct()
    {
        $this->asistentesevento = new AsistentesEventos();
    }

    public function apuntarseEvento($data){
        
        $data = json_decode($data);
        $result = $this->asistentesevento->apuntarseEvento($data);
        
        if($result){
            ResponseHttp::statusMessage(202,'Linea creada');
            
        }else{
            ResponseHttp::statusMessage(400,'No se ha podido crear la linea');
        }
        return $result;
    }

    public function verNumParticipantes($eventoid){
        $eventoid = json_decode($eventoid);
        $numParticipantes = $this->asistentesevento->verNumParticipantes($eventoid);

        if($numParticipantes >= 0){
            ResponseHttp::statusMessage(202, 'OK');
        }else{
            ResponseHttp::statusMessage(204, 'No hay participantes');
        }

        $numParticipantes = json_encode($numParticipantes);
        return $numParticipantes;
    }

    public function buscarParticipante($data){
        $data = json_decode($data);
        $registrado = $this->asistentesevento->buscarParticipante($data);

        if($registrado){
            ResponseHttp::statusMessage(202, 'Está registrado');
        }else{
            ResponseHttp::statusMessage(204, 'No está registrado');
        }

        $registrado = json_encode($registrado);
        return $registrado;
    }

    public function buscarEvento($id){
        $id = json_decode($id);
        $evento = $this->asistentesevento->buscarEvento($id);
        
        if($evento){
            ResponseHttp::statusMessage(202, 'Se ha cargado el evento');
        }else{
            ResponseHttp::statusMessage(204, 'No se ha podido cargar');
        }
        $evento = json_encode($evento);
        return $evento;
    }

    public function misEventos($id){
        $id = json_decode($id);
        $eventos = $this->asistentesevento->misEventos($id);

        if($eventos){
            ResponseHttp::statusMessage(202, 'Se han cargado los eventos');
        }else{
            ResponseHttp::statusMessage(204, 'No se han podido cargar los eventos');
        }
        $eventos = json_encode($eventos);
        return $eventos;
    }

    public function borrarLinea($hermanoid, $eventoid){
        $hermanoid = json_decode($hermanoid);
        $eventoid = json_decode($eventoid); 

        $result = $this->asistentesevento->borrarLinea($hermanoid, $eventoid);
        if($result){
            ResponseHttp::statusMessage(202, 'Se ha eliminado la linea');
        }else{
            ResponseHttp::statusMessage(304, 'No se ha podido eliminar la linea');
        }
        $result = json_encode($result);
        return $result;
    }
}