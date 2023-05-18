<?php

include_once 'Pasajeros.php';

class PasajerosNecesidades extends Pasajeros{

    private $necesidadesEspeciales;

    public function __construct($nombre, $apellido, $documento, $telefono, $numAsiento, $ticket, $necesidadesEspeciales)
    {
        parent::__construct($nombre, $apellido, $documento, $telefono, $numAsiento, $ticket);
        $this->necesidadesEspeciales = $necesidadesEspeciales;
    }

    public function getNecesidadesEspeciales(){
        return $this->necesidadesEspeciales;
    }
    public function setNecesidadesEspeciales($necesidadesEspeciales){
        $this->necesidadesEspeciales = $necesidadesEspeciales;
    }

    public function darPorcentajeIncremento(){
        if(count($this->getNecesidadesEspeciales()) > 1){
            $incremento = 1.3;
        } else {
            $incremento = 1.15;
        }
        return $incremento;
    }

    public function __toString()
    {
        return parent::__toString() . " - Necesidades especiales: " . implode(", ", $this->getNecesidadesEspeciales());
    }

}