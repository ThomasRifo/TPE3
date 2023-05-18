<?php

include_once 'Pasajeros.php';

class PasajerosVip extends Pasajeros {

    private $numViajeroFrecuente;
    private $cantMillas;

    public function __construct($nombre, $apellido, $documento, $telefono, $numAsiento, $ticket, $numViajeroFrecuente, $cantMillas)
    {
        parent::__construct($nombre, $apellido, $documento, $telefono, $numAsiento, $ticket);
        $this->numViajeroFrecuente = $numViajeroFrecuente;
        $this->cantMillas = $cantMillas;
    }

    public function getViajeroFrecuente(){
        return $this->numViajeroFrecuente;
    }
    public function getCantMillas(){
        return $this->cantMillas;
    }

    public function setViajeroFrecuente($viajeroFrecuente){
        $this->numViajeroFrecuente = $viajeroFrecuente;
    }
    public function setCantMillas($cantMillas){
        $this->cantMillas = $cantMillas;
    }

    public function darPorcentajeIncremento(){
        $incremento = 1.35;
        if($this->getCantMillas() > 300){
            $incremento = 1.30;
        }
        return $incremento;
    }

    public function __toString()
    {
        return parent::__toString() . " - Nro. de viajero frecuente: {$this->getViajeroFrecuente()} - Cant. millas: {$this->getCantMillas()}";
    }

}