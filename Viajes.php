<?php


class Viajes
{
    private $codigo;
    private $destino;
    private $maxPasajeros;
    private $pasajeros; //Colección de objetos pasajero
    private $responsable; //objeto ResponsableV
    private $costo; 
    private $totalAbonado;

    public function __construct($codigo, $destino, $maxPasajeros, $responsable, $costo)
    {
        $this->codigo = $codigo;
        $this->destino = $destino;
        $this->maxPasajeros = $maxPasajeros;
        $this->responsable = $responsable;
        $this->costo = $costo;
        $this->pasajeros = array();
        $this->totalAbonado = 0;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }
    public function getDestino()
    {
        return $this->destino;
    }

    public function getMaxPasajeros()
    {
        return $this->maxPasajeros;
    }

    public function getPasajeros()
    {
        return $this->pasajeros;
    }
    public function getResponsable(){
        return $this->responsable;
    }
    public function getCosto(){
        return $this->costo;
    }
    public function getTotalAbonado(){
        return $this->totalAbonado;
    }

    public function setPasajeros($listaPasajeros)
    {
        $this->pasajeros = $listaPasajeros;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }
    public function setMaxPasajeros($maximo)
    {
        $this->maxPasajeros = $maximo;
    }
    public function setResponsable($responsable){
        $this->responsable = $responsable;
    }
    public function setCosto($costo){
        $this->costo = $costo;
    }
    public function setTotalAbonado($totalAbonado){
        $this->totalAbonado = $totalAbonado;
    }
//Verifica si el viaje tiene disponibilidad
    public function hayPasajesDisponibles()
    {
        $pasajesDisponible = true;
        if (count($this->getPasajeros()) >= $this->getMaxPasajeros()) {
            $pasajesDisponible = false;
        }
        return $pasajesDisponible;
    }


    //Elimina al pasajero indicado con el documento. 
    public function eliminarPasajero($array, $documento)
    {
        $pasajeroExiste = false;
        $i = 0;
        while ($i < count($array->pasajeros)) {
            $pasajeroEncontrado = null;
            //if($array->pasajeros[$i]["documento"] == $documento){ FORMA ANTERIOR DE LA CONDICION
            if ($array->existePasajero($documento, $pasajeroEncontrado)) {
                array_splice($array->pasajeros, $i, 1);
                $pasajeroExiste = true;
            }
            $i++;
        }
    }

//Esta funcion tiene como parámetro &$pasajeroEncontrado, & adelante del parametro sirve para usarlo de referencia, y cuando se ejecute la funcion si este valor cambia, se verá reflejado en el programa donde fue pasado como argumento
    public function existePasajero($documento, &$pasajeroEncontrado)
    {
        $pasajeros = $this->getPasajeros();
        $existePasajero = false;
        $i = 0;
        $cantidadPasajeros = count($this->pasajeros);
        while (!$existePasajero && $i < $cantidadPasajeros) {
            if ($pasajeros[$i]->getDocumento() == $documento) {
                $existePasajero = true;
                $pasajeroEncontrado = $pasajeros[$i];
            } else {
                $i++;
            }
        }
        return $existePasajero;
    }

    public function venderPasaje($objPasajero){
        $costoPasaje = 0;
        if($this->hayPasajesDisponibles()){ //Este if está de más en mi código porque en el test verifico esto antes de pedir los datos del pasajero. Pero lo dejo en la función porque es lo que pide el enunciado.
            $costoPasaje = $this->getCosto() * $objPasajero->darPorcentajeIncremento();
            $pasajeros = $this->getPasajeros();
            $pasajeros[] = $objPasajero;
            $this->setPasajeros($pasajeros);
            $sumarTotalAbonado = $this->getTotalAbonado() + $costoPasaje;
            $this->setTotalAbonado($sumarTotalAbonado);
        }
        return $costoPasaje;
    }

    public function __toString()
    {
        $texto = '';
        foreach ($this->pasajeros as $pasajero) {
            $texto .= $pasajero->__toString();
        }

        return "Código: {$this->getCodigo()}\nDestino: {$this->getDestino()}\nResponsable: {$this->getResponsable()->__toString()}\nMáx. Pasajeros: {$this->getMaxPasajeros()}\nPasajeros:\n{$texto}";
    }
}
