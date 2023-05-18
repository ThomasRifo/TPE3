<?php

include_once 'Viajes.php';
include_once 'Pasajeros.php';
include_once 'ResponsableV.php';
include_once 'PasajerosVip.php';
include_once 'PasajerosNecesidades.php';



$listaViajes = array();

// Instancia de la clase Viaje, con los atributos 001, Bariloche, 24.
$objResponsable = new ResponsableV(110, 2000, "Raul", "Gonzalez");
$viaje = new Viajes("001", "Bariloche", 24, $objResponsable, 11500);
$listaViajes[$viaje->getCodigo()] = $viaje;
$listaPasajeros = array();

//print_r($listaViajes);
//Menú principal

$opcion = 0;
while ($opcion != 4) {
    echo "\n******Menú******\n";
    echo "1. Cargar información de un viaje\n";
    echo "2. Modificar Información de un viaje\n";
    echo "3. Vender pasaje\n";
    echo "4. Ver información de un viaje\n";
    echo "5. Salir\n";
    echo "Ingrese una opción: ";
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
            //Pide los datos del viaje que desea cargar al sistema y le deja como clave el código
            echo "\nIngrese el código del viaje: ";
            $codigo = trim(fgets(STDIN));
            if ($codigo == $viaje->getCodigo()) {
                do {
                    echo "\nYa hay un viaje registrado con el codigo: " . $codigo . ", por favor ingrese otro: ";
                    $codigo = trim(fgets(STDIN));
                } while ($codigo == $viaje->getCodigo());
            }
            echo "\nIngrese el destino del viaje: ";
            $destino = trim(fgets(STDIN));
            echo "\nIngrese capacidad maxíma de pasajeros: ";
            $maxPasajeros = trim(fgets(STDIN));
            echo "\nIngrese el número de legajo del responsable del viaje: ";
            $numResponsable = trim(fgets(STDIN));
            echo "\nIngrese el número de licencia del responsable: ";
            $licResponsable = trim(fgets(STDIN));
            echo "\nIngrese el nombre del responsable: ";
            $nombreResponsable = trim(fgets(STDIN));
            echo "\nIngrese el apellido del responsable: ";
            $apellidoResponsable = trim(fgets(STDIN));
            echo "\nIngrese el costo del viaje: ";
            $costo = trim(fgets(STDIN));
            $objResponsable = new ResponsableV($numResponsable, $licResponsable, $nombreResponsable, $apellidoResponsable);
            $viaje = new Viajes($codigo, $destino, $maxPasajeros, $objResponsable, $costo);
            $listaViajes[$codigo] = $viaje;
            echo "\nViaje cargado con éxito.\n";
            break;
        case 2:
            //Pide el código del viaje a modificar al principio y comprueba si existe el viaje que desea modificar.
            echo "\nIngresar el código del viaje a modificar: ";
            $codigo = trim(fgets(STDIN));
            $encontro = false;

            //Uso un foreach porque el while no sirve para mi caso en particular, ya que yo tengo como clave el codigo de viaje, no el orden en el que se encuentran dentro del array, por lo que $i = 0 con $listaViajes[$i] da undefined. No se me ocurrio una forma mejor de realizarlo.
            foreach ($listaViajes as $viaje) {
                if ($codigo == $viaje->getCodigo()) {
                    $encontro = true;
                    break;
                }
            }
            /*//Verifica que se pueda acceder al viaje con el código dado por el usuario y si es posible, cambia encontro a true y almacena el viaje. Es la forma alternativa por si el foreach está mal aplicado.
            if (isset($listaViajes[$codigo])) {
                $encontro = true;
                $viaje = $listaViajes[$codigo];
            }
*/
            do {

                if ($encontro) {
                    echo $viaje->__toString();
                    echo "\n1. Código del viaje. \n";
                    echo "2. Destino del viaje. \n";
                    echo "3. Capacidad máxima del viaje. \n";
                    echo "4. Eliminar pasajero del viaje. \n";
                    echo "5. Cambiar información de un pasajero. \n";
                    echo "6. Salir. \n";
                    echo "Ingrese una opción válida: ";
                    $opcionModificar = (int)trim(fgets(STDIN));
                    switch ($opcionModificar) {
                        case 1: //CAMBIAR CODIGO
                            echo "\nIngresar el nuevo código de viaje: \n";
                            $nuevoCodigo = trim(fgets(STDIN));
                            $viaje->setCodigo($nuevoCodigo);
                            echo "\nEl nuevo código de viaje es: " . $viaje->getCodigo() . "\n";
                            break;
                        case 2: //CAMBIAR DESTINO
                            echo "\nIngresar el nuevo destino: \n";
                            $destinoNuevo = trim(fgets(STDIN));
                            $listaViajes[$codigo]->setDestino($destinoNuevo);
                            echo "\nEl nuevo destino del viaje " . $codigo . " es: " . $viaje->getDestino() . "\n";
                            break;
                        case 3:  //CAMBIAR CAPACIDAD MAXIMA
                            echo "\nIngresar la nueva capacidad máxima: \n";
                            $nuevaCapacidad = trim(fgets(STDIN));
                            $listaViajes[$codigo]->setMaxPasajeros($nuevaCapacidad);
                            echo "\nLa nueva capacidad máxima del viaje " . $codigo . " es : " . $viaje->getMaxPasajeros() . "\n";
                            break;
                        case 4: //ELIMINAR PASAJERO
                            echo "\nIngresar el documento del pasajero que desea eliminar: \n";
                            $documento = trim(fgets(STDIN));
                            $pasajeroEncontrado = null;
                            $existePasajero = $viaje->existePasajero($documento, $pasajeroEncontrado);
                            //Verifica si el pasajero se encuentra en el viaje, si se encuentra procede a eliminarlo.
                            if ($existePasajero && $pasajeroEncontrado !== null) {
                                $listaViajes[$codigo]->eliminarPasajero($listaViajes[$codigo], $documento);
                                echo "\nEl pasajero fue eliminado del viaje correctamente.\n";
                            } else {
                                echo "\nEl pasajero no se encuentra dentro del viaje " . $codigo . "\n";
                            }
                            break;
                        case 5: //MODIFICAR PASAJERO
                            echo "\nIngresar el documento del pasajero registrado: \n";
                            $documento = trim(fgets(STDIN));
                            $pasajeroEncontrado = null;
                            $existePasajero = $viaje->existePasajero($documento, $pasajeroEncontrado);
                            //Verifica si el pasajero se encuentra en el viaje y pide los nuevos datos a registrar. Luego con la funcion modificarPasajero cambia los datos antiguos por los nuevos
                            if ($existePasajero && $pasajeroEncontrado !== null) {
                                do {
                                    echo "\nSe modificará el pasajero de documento: " . $documento . ". Desea modificar: \n";
                                    echo "\n1. Documento. \n";
                                    echo "2. Nombre. \n";
                                    echo "3. Apellido. \n";
                                    echo "4. Teléfono. \n";
                                    echo "5. Salir\n";
                                    echo "Ingrese una opción válida: ";
                                    $opcionModificarPasajero = (int)trim(fgets(STDIN));
                                } while ($opcionModificar < 6);
                                switch ($opcionModificarPasajero) {
                                    case 1:
                                        echo "\nIngrese el nuevo documento: ";
                                        $documentoNuevo = trim(fgets(STDIN));
                                        $pasajeroEncontrado->setDocumento($documentoNuevo);
                                        echo "El documento fue actualizado correctamente.";
                                        break;
                                    case 2:
                                        echo "\nIngrese el nuevo nombre: ";
                                        $nombreNuevo = trim(fgets(STDIN));
                                        $pasajeroEncontrado->setNombre($nombreNuevo);
                                        echo "El nombre fue actualizado correctamente.";
                                        break;
                                    case 3:
                                        echo "\nIngrese el nuevo apellido: ";
                                        $apellidoNuevo = trim(fgets(STDIN));
                                        $pasajeroEncontrado->setApellido($apellidoNuevo);
                                        echo "El apellido fue actualizado correctamente.";
                                        break;
                                    case 4:
                                        echo "\nIngrese el nuevo teléfono: ";
                                        $nuevoTelefono = trim(fgets(STDIN));
                                        $pasajeroEncontrado->setTelefono($nuevoTelefono);
                                        echo "El teléfono fue actualizado correctamente.";
                                }
                            } else {
                                echo "\nEl documento ingresado no corresponde a un pasajero de este viaje. \n";
                                break;
                            }
                        case 6:
                            break;
                    }
                }
                if (!$encontro) {
                    echo "\nEl código que ingreso no corresponde a un viaje activo\n";
                }
            } while ($opcionModificar !== 6);
            break;

        case 3:
            //Pide el código del viaje a vender al principio parasaber si es posible.
            echo "\nIngresar el código del viaje a vender: ";
            $codigo = trim(fgets(STDIN));
            $encontro = false;

            foreach ($listaViajes as $viaje) {
                if ($codigo == $viaje->getCodigo()) {
                    $encontro = true;
                    break;
                }
            }
            //Al igual que en la opcion modificar información, si el foreach está mal aplicado puedo utilizar el isset.

            $disponible = $viaje->hayPasajesDisponibles();

            if ($encontro) {
                if ($disponible) {
                    echo "\nIngresar los datos del pasajero que desea agregar al viaje: \n";
                    echo "Documento: ";
                    $documentoPasajero = trim(fgets(STDIN));
                    $pasajeroEncontrado = null;
                    $existePasajero = $viaje->existePasajero($documentoPasajero, $pasajeroEncontrado);
                    if ($existePasajero && $pasajeroEncontrado !== null) {
                        echo "\nEl pasajero ya se encuentra en el viaje " . $codigo . "\n";
                    } else {
                        echo "\nElija el tipo de pasajero correspondiente: \n";
                        echo "1. Pasajero común\n";
                        echo "2. Pasajero Vip\n";
                        echo "3. Pasajero con necesidades especiales\n";
                        echo "4. Salir \n";

                        $opcionPasajero = (int)trim(fgets(STDIN));

                        echo "Nombre: ";
                        $nombrePasajero = trim(fgets(STDIN));
                        echo "Apellido: ";
                        $apellidoPasajero = trim(fgets(STDIN));
                        echo "Telefono: ";
                        $telefonoPasajero = trim(fgets(STDIN));
                        echo "Num Asiento: ";
                        $numAsiento = trim(fgets(STDIN));
                        echo "Ticket: ";
                        $ticket = trim(fgets(STDIN));
                        switch ($opcionPasajero) {
                            case 1:
                                $objPasajero = new Pasajeros($nombrePasajero, $apellidoPasajero, $documentoPasajero, $telefonoPasajero, $numAsiento, $ticket);
                                $costoFinal = $viaje->venderPasaje($objPasajero);
                                echo "El pasaje fue vendido con éxito por un total de: $" . $costoFinal . ".";
                                break;
                            case 2:
                                echo "Número de viajero frecuente: ";
                                $numViajeroFrecuente = trim(fgets(STDIN));
                                echo "Cantidad de millas: ";
                                $cantMillas = trim(fgets(STDIN));
                                $objPasajero = new PasajerosVip($nombrePasajero, $apellidoPasajero, $documentoPasajero, $telefonoPasajero, $numAsiento, $ticket, $numViajeroFrecuente, $cantMillas);
                                $costoFinal = $viaje->venderPasaje($objPasajero);
                                echo "El pasaje fue vendido con éxito por un total de: $" . $costoFinal . ".";
                                break;
                            case 3:
                                echo "\n¿Necesita silla de ruedas?(s/n): \n";
                                $respuesta = trim(fgets(STDIN));
                                if ($respuesta == "s") {
                                    $necesidadesEspeciales[] = "Silla de ruedas";
                                }
                                echo "\n¿Necesita asistencia para el embarque o desembarque?(s/n): \n";
                                $respuesta = trim(fgets(STDIN));
                                if ($respuesta == "s") {
                                    $necesidadesEspeciales[] = "Asistencia para embarque/desembarque";
                                }
                                echo "\n¿Requiere de comida especial?(s/n): \n";
                                $respuesta = trim(fgets(STDIN));
                                if ($respuesta == "s") {
                                    $necesidadesEspeciales[] = "Comida especial";
                                }
                                $objPasajero = new PasajerosNecesidades($nombrePasajero, $apellidoPasajero, $documentoPasajero, $telefonoPasajero, $numAsiento, $ticket, $necesidadesEspeciales);
                                $costoFinal = $viaje->venderPasaje($objPasajero);
                                echo "El pasaje fue vendido con éxito por un total de: $" . $costoFinal . ".";
                                break;
                            case 4:
                                break;
                        }
                    }
                } else {
                    echo "\nEl viaje " . $codigo . " ha alcanzado su límite máximo de pasajeros.\n";
                }
            } else {
                echo "\nEl código que ingreso no corresponde a un viaje activo\n";
            }
            break;

        case 4:
            echo "\nIngrese el código del viaje para acceder a la información del mismo: ";
            $codigo = trim(fgets(STDIN));
            $encontrado = false;
            //Comprueba que exista el viaje del que se desea ver la información y luego retorna la información del viaje.
            foreach ($listaViajes as $viaje) {
                if ($codigo == $viaje->getCodigo()) {
                    $encontrado = true;
                    echo $viaje->__toString();
                }
            }
            if (!$encontrado) {
                echo "\nNo se encontró ningun viaje con el código " . $codigo . "\n ";
            }
            break;
        case 5:
            break;
    }
}
