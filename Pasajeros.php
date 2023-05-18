<?php

class Pasajeros
{
    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;
    private $numAsiento;
    private $ticket;

    public function __construct($nombre, $apellido, $documento, $telefono, $numAsiento, $ticket)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->documento = $documento;
        $this->telefono = $telefono;
        $this->numAsiento = $numAsiento;
        $this->ticket = $ticket;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getNumAsiento(){
        return $this->numAsiento;
    }
    public function getTicket(){
        return $this->ticket;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setNumAsiento($numAsiento){
        $this->numAsiento = $numAsiento;
    }
    public function setTicket($ticket){
        $this->ticket = $ticket;
    }

    public function darPorcentajeIncremento(){
        $incremento = 1.10;
        return $incremento;
    }

    public function __toString() {
        return "\nDNI: {$this->getDocumento()} - Apellido y nombre: {$this->getApellido()} {$this->getNombre()} - Teléfono: {$this->getTelefono()} - Asiento: {$this->getNumAsiento()} - Ticket: {$this->getTicket()}";
        }
    
}
