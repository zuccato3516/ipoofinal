<?php
//---------------TP FINAL IPOO----------------//
//----------Alumno: Stefano Zuccato-----------//
//---------------Legajo: FI3517---------------//

//------------------INCLUDES------------------//
include '../datos/BaseDatos.php';
include '../datos/Responsable.php';
include '../datos/Empresa.php';
include '../datos/Viaje.php';
include '../datos/Pasajero.php';

precarga();
menu();

//------------------FUNCIONES AUXILIARES------------------//

// Función que imprime cada toString de un arreglo de objetos en orden.
function imprimir($arreglo){
    $largo=count($arreglo);
    for ($i=0; $i<$largo; $i++){
      $objeto=$arreglo[$i];
      echo $objeto;
    }
    }

// Función que usa is_numeric para pedir una entrada numérica.
function esNumero($entrada)
{
    $esNum = false;
    $numero=0;
    while (!$esNum) {
        $numero=readline($entrada);
        if (is_numeric($numero)) {
            $esNum=true;
        } else {
            echo "Ingrese un número por favor. \n";
        }
    }
    return $numero;
}

// Precarga.
function precarga()
{
    $obj_Responsable = new ResponsableV();
    $obj_Empresa = new Empresa();
    $obj_Viaje = new Viaje();
    $obj_Pasajero = new Pasajero();

    $obj_Responsable->cargar(1, "Juan", "Perez", 813932);
    $obj_Empresa->cargar(1, "ProTravel", "Rosario 375");
    $obj_Responsable->insertar();
    $obj_Empresa->insertar();

    $obj_Viaje->cargar(0, "San Juan", 5, $obj_Responsable, $obj_Empresa, 13000, "segunda clase cama","si");
    $obj_Viaje->insertar();
    $obj_Pasajero->cargar(35431523, "Roberto", "Dominguez", 4425634, $obj_Viaje);
    $obj_Pasajero->insertar();
    $obj_Pasajero->cargar(34125123, "Maria", "Rosas", 4437645, $obj_Viaje);
    $obj_Pasajero->insertar();
    $obj_Pasajero->cargar(36541253, "Juana", "Mendez", 4474312, $obj_Viaje);
    $obj_Pasajero->insertar();
    $obj_Pasajero->cargar(32415234, "Luis", "Ochoa", 4476342, $obj_Viaje);
    $obj_Pasajero->insertar();
}
 

//------------------MENÚ PRINCIPAL------------------//
function menuPrincipal()
{
    echo "
/------------------------------------------/
        MENÚ PRINCIPAL
/------------------------------------------/
1. Menú empresa
2. Menú responsable
3. Menú viaje
4. Menú pasajero
/------------------------------------------/
        \n";
}

// Acto seguido, listo los cuatro menúes en orden.
//Menú empresa
function menuEmpresa()
{
    $opcion=1;
    while ($opcion!=0) {
        echo "
/------------------------------------------/
        MENÚ EMPRESA
/------------------------------------------/
    1. Dar de alta una empresa
    2. Dar de baja una empresa
    3. Modificar una empresa existente
    4. Listar empresas existentes
    5. Volver al menú principal
/------------------------------------------/
            \n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0: break;
            case 1 :
                echo "Ingresar número del responsable: \n";
                $r = new ResponsableV();
                $arre = $r->listar("");
                if (count($arre)>0) {
                    echo "-------------------------------------------------------------------------------------------\n";
                    echo "Ingrese el numero de empleado\n";
                    $rdocumento = trim(fgets(STDIN));
                    $r->Buscar($rdocumento);
                    if ($r->getnumEmpleado()!="") {
                        agregarEmpresa($r);
                    } else {
                        echo "No existe el empleado con numero ".$rdocumento."\n";
                    }
                } else {
                    echo "No hay responsables cargado\n";
                }
              
                 break;
            case 2 :
                $empresa = new Empresa();
                $aux = $empresa->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay empresas.\n";
                    }
                echo "Ingrese el ID de la empresa: \n";
                    $id = trim(fgets(STDIN));
                    $empresa->Buscar($id);
                    if ($empresa->getIdEmpresa() != "") {
                        $empresa->eliminar();
                        if ($empresa->eliminar() == false){
                        echo "La empresa no pudo ser eliminada, por estar asociada a un viaje.\n";
                        }else {
                        echo "La empresa fue eliminada.\n";
                        }
                    } else {
                        echo "La empresa no existe.\n";
                    }

                break;
            case 3 :
                $empresa = new Empresa();
                $aux = $empresa->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay empresas.\n";
                    }
                echo "Ingrese el ID de la empresa: \n";
                $e = trim(fgets(STDIN));
                $em = new Empresa();
               
                $em->Buscar($e);
                if ($em->getIdEmpresa()!="") {
                    modificarEmpresa($em);
                } else {
                    echo "No existe la empresa con el identificador ".$e;
                }
                break;
            case 4 :
                $empresa = new Empresa();
                $aux = $empresa->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay empresas.\n";
                    }
             break;
             
            case 5: break;
            default: echo "Opción incorrecta.";
        }
    }
}

//Menú responsable
function menuResponsable()
{
    $opcion=1;
    while ($opcion!=0) {
        echo"
    /------------------------------------------/
            MENÚ RESPONSABLE
    /------------------------------------------/
        1. Dar de alta un responsable
        2. Dar de baja un responsable
        3. Modificar un responsable existente
        4. Listar responsables existentes
        5. Volver al menú principal
    /------------------------------------------/
                \n"; 
        
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0: break;
            case 1 :
                agregarResponsable();
                break;
            case 2 :
                echo "Ingrese el ID del responsable: \n";
                $e = trim(fgets(STDIN));
                $em = new ResponsableV();
                $em->Buscar($e);
                if ($em->getnumEmpleado()!="") {
                    borrarResponsable($em);
                } else {
                    echo "No existe un responsable con ese nombre.\n";
                }
                break;
            case 3 :
                $responsable = new ResponsableV();
                $aux = $responsable->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay responsables.\n";
                    }
                echo "Ingrese el ID del responsable: \n";
                $id = trim(fgets(STDIN));
                $responsable->Buscar($id);
                if ($responsable->getnumEmpleado()!="") {
                    modificarResponsable($responsable);
                } else {
                    echo "No existe un responsable con ese número.\n";
                }
               
                break;
            case 4 :
                $responsable = new ResponsableV();
                $aux = $responsable->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay responsables.\n";
                    }
             break;
            default: echo "Opción incorrecta.\n";
        }
    }
}

//Menú viaje.
function menuViaje()
{
    $opcion=1;
    while ($opcion!=0) {
        echo "
        /------------------------------------------/
                MENÚ VIAJE
        /------------------------------------------/
            1. Dar de alta un viaje
            2. Dar de baja un viaje
            3. Modificar un viaje existente
            4. Listar viajes existentes
            5. Volver al menú principal
        /------------------------------------------/
                    \n";  
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0: break;
            case 1 :
                echo "Ingrese el número de empleado: \n";
                $r = trim(fgets(STDIN));
                $responsable = new ResponsableV();
                $responsable->Buscar($r);
                if ($responsable->getnumEmpleado()!="") {
                    echo "Ingrese el identificador de la empresa: \n";
                    $e = trim(fgets(STDIN));
                    $Empresa = new Empresa();
                    $Empresa->Buscar($e);
                    if ($Empresa->getIdEmpresa()!="") {
                        agregarViaje($responsable, $Empresa);
                    } else {
                        echo "No existe una empresa con ese número. \n ";
                    }
                } else {
                        echo "No existe un responsable con ese número de empleado. \n ";
                    }
                
                 break;
            case 2 :
                $viaje = new Viaje();
                $aux = $viaje->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay viajes.\n";
                    }
                echo "Ingrese el ID del viaje: \n";
                    $id = trim(fgets(STDIN));
                    $viaje->Buscar($id);
                    if ($viaje->getidviaje() != "") {
                        $viaje->eliminar();
                        if ($viaje->eliminar() == false){
                        echo "No se puede eliminar; está asociado a pasajeros.\n";
                        }else {
                        echo "Viaje eliminado satisfactoriamente.";
                        }
                    } else {
                        echo "No existe el viaje con el identificador ingresado.\n";
                    }
                break;
            case 3:
                $viaje = new Viaje();
                $aux = $viaje->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay viajes cargados\n";
                    }
                echo "*A continuacion ingrese el identificador\n";
                $id = trim(fgets(STDIN));
                $viaje->Buscar($id);
                if ($viaje->getidviaje()!="") {
                    modificarViaje($viaje);
                } else {
                    echo "No existe un viaje con ese identificador\n";
                }
                break;
            case 4:
                $viaje = new Viaje();
                $aux = $viaje->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay viajes cargados\n";
                    }
             break;
            default: echo "Opción incorrecta.";
        }
    }
}

//Menú pasajero
function menuPasajero()
{
    $opcion=1;
    while ($opcion!=0) {
        echo "
    /------------------------------------------/
            MENÚ PASAJERO
    /------------------------------------------/
        1. Dar de alta un pasajero
        2. Dar de baja un pasajero
        3. Modificar un pasajero existente
        4. Listar viajes existentes
        5. Volver al menú principal
    /------------------------------------------/
                \n";  
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0: break;
        case 1 :
            agregarPasajero();
             break;
        case 2 :
            borrarPasajero();
            break;
        case 3 :
             modificarPasajero();
            break;
        case 4 :
            echo "Ingrese ID del viaje: ";
            $id = trim(fgets(STDIN));
            $viaje = new Viaje();
            $DatosViaje = $viaje->listar("idviaje =".$id);

            if (count($DatosViaje)==1) {
                $pasajero = new Pasajero();
                imprimir($pasajero->listar("idviaje=".$DatosViaje[0]->getidviaje()));
            } else {
                echo "No hay un viaje con ese destino.";
            }
         break;
        default: echo "Opción incorrecta.";
    }
    }
}

// Finalmente, defino el menú que es llamado al llamar la función menú.
function menu()
{
    $opcion = 1;
    while ($opcion != 0) {
        menuPrincipal();
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 1 : menuEmpresa(); break;
            case 2 : menuResponsable(); break;
            case 3 : menuViaje(); break;
            case 4 : menuPasajero(); break;
            default: echo "Opción incorrecta.";break;
        }
    }
}

//------------------EMPRESA------------------//
// A continuación desarrollo cada función usada por la clase Empresa.
function agregarEmpresa($numeroEmpleado)
{
    $IdEmpresa="";
    echo "Ingrese Nombre de la Empresa: ";
    $nombreEmpresa = trim(fgets(STDIN));
    echo "La direccion De la empresa: ";
    $direccionEmpresa =  trim(fgets(STDIN));
    $nuevaEmpresa= new Empresa();
    $nuevaEmpresa->cargar($IdEmpresa, $nombreEmpresa, $direccionEmpresa, $numeroEmpleado);
    $nuevaEmpresa->insertar();
}

function modificarEmpresa($soyEmpresa)
{
    echo "Ingrese Nombre de la Empresa: ";
    $nombreEmpresa = trim(fgets(STDIN));
    echo "La direccion De la empresa: ";
    $direccionEmpresa = trim(fgets(STDIN));
    $soyEmpresa->setEnombre($nombreEmpresa);
    $soyEmpresa->setEdireccion($direccionEmpresa);
    $soyEmpresa->modificar();
}
function borrarEmpresa($soyEmpresa)
{
    $soyEmpresa->eliminar();
}


//------------------RESPONSABLE------------------//
// A continuación desarrollo cada función usada por la clase ResponsableV.
function agregarResponsable()
{
    echo "Ingrese Nombre del Responsable: ";
    $nombreResponsable = trim(fgets(STDIN));
    echo "Ingrese Apellido del Responsable: ";
    $apellidoResponsable =trim(fgets(STDIN));
    echo "Ingrese numero de licencia del responsable: ";
    $numeroLicencia= trim(fgets(STDIN));
    $nuevoResponsable= new ResponsableV();
    $nuevoResponsable->cargar(0, $nombreResponsable, $apellidoResponsable, $numeroLicencia);
    $nuevoResponsable->insertar();
}
function modificarResponsable($responsable)
{
    echo "Ingrese Nombre del Responsable: ";
    $nombreResponsable =trim(fgets(STDIN));
    echo "Ingrese Apellido del Responsable: ";
    $apellidoResponsable =trim(fgets(STDIN));
    echo "Ingrese numero de licencia del responsable: ";
    $numeroLicencia= trim(fgets(STDIN));
    $responsable->setNombre($nombreResponsable);
    $responsable->setApellido($apellidoResponsable);
    $responsable->setnumLicencia($numeroLicencia);
    $responsable->modificar();
}
function borrarResponsable($responsable)
{
    $responsable->eliminar();
    if ($responsable->eliminar() == false){
        echo "No se pudo eliminar el responsable, está asociado a empresa.";
    }else{
        echo "Responsable eliminado.";
    };
}

//------------------VIAJE------------------//
// A continuación desarrollo cada función usada por la clase Viaje.
 function agregarViaje($responsable, $Empresa)
 {
     $nuevoViaje = new Viaje();
     echo "Ingrese el destino: ";
     $destino = trim(fgets(STDIN));
     $ID= $Empresa->getIdEmpresa();
   
     $listaDestino = $nuevoViaje->listar("vdestino='".$destino."'");

     $totalViajes=count($listaDestino);
     if ($totalViajes!=0) {
             echo "Ya existe un viaje de esta empresa con ese destino.\n";
         } else {
         echo "Ingrese la capacidad del viaje: ";
         $capacidad = trim(fgets(STDIN));
         echo "Ingrese el precio del viaje: ";
         $importe=trim(fgets(STDIN));
         echo "Ingrese si el viaje es  ida y vuelta: SI/NO ";
         $idayvuelta =  trim(fgets(STDIN));
         echo "Ingrese categoria de Asientos del viaje: ";
         $tipoAsiento =trim(fgets(STDIN));
        
         $nuevoViaje->cargar(0, $destino, $capacidad, $responsable, $Empresa, $importe, $tipoAsiento, $idayvuelta);
         $nuevoViaje->insertar();
     }
 }

 function modificarViaje($viaje)
 {
     $id = $viaje->getidviaje();
     $pas= new pasajero();
     $a = $pas->listar(("idviaje='".$id."'"));
     $totalPasajeros= count($a);
     $viaje = new Viaje;
     echo "Ingrese el destino: ";
     $destino = trim(fgets(STDIN));
     $lista = $viaje->listar("vdestino='".$destino."'");
     $viajeAMod = $viaje->Buscar("vdestino='".$destino."'");
     echo "Ingrese la capacidad del viaje: ";
     $capacidad = trim(fgets(STDIN));
     if ($capacidad<$totalPasajeros) {
         echo "la cantidad de pasajeros ya en el viaje, supera a la cantidad ingresada";
     } else {
         echo "Ingrese el precio del viaje: ";
         $importe=trim(fgets(STDIN));
         echo "Ingrese si el viaje es  ida y vuelta: SI/NO ";
         $idayvuelta =  trim(fgets(STDIN));
         echo "Ingrese categoria de Asientos del viaje: ";
         $tipoAsiento =trim(fgets(STDIN));
         $empresa = $viaje->getObjEmpresa();
         $responsable = $viaje->getObjResponsable();
         $viaje->cargar($id, $destino, $capacidad, $responsable, $empresa, $importe, $tipoAsiento, $idayvuelta);
         $viaje->modificarTodo();
     }
 }
function borrarViaje($viaje)
{
    $viaje->eliminar();
}

//------------------PASAJERO------------------//
// A continuación desarrollo cada función usada por la clase Pasajero.
function agregarPasajero()
{
    $destino = readline("Ingrese Destino del pasajero:\n");
    $viaje = new Viaje();
    $consulta = "vdestino ='".$destino."'";

    $DatosViaje = $viaje->listar($consulta);
    if (count($DatosViaje) == 1) {
        $nuevoPasajero= new Pasajero();
        $viaje = $DatosViaje[0];
        $idViaje = $viaje->getidviaje();
        $cantAsientosTotal = $viaje->getCantMaxima();
        $condicion = "idviaje=".$idViaje;
        $asientos = $nuevoPasajero->listar($condicion);
        $cantAsientosOcupados = count($asientos);
        if (($cantAsientosTotal - $cantAsientosOcupados) > 0) {
            $nombrePasajero = readline("Ingrese Nombre del Pasajero: \n");
            $apellidoPasajero = readline("Ingrese Apellido del pasajero: \n");
            $dniPasajero= readline("Ingrese Dni del pasajero: \n");
            $telefonoPasajero=esNumero("Ingrese el telefono del pasajero:\n");

            $nuevoPasajero->cargar($dniPasajero, $nombrePasajero, $apellidoPasajero, $telefonoPasajero, $viaje);
            if ($nuevoPasajero->insertar()) {
                echo "Se inserto correctamente el pasajero en la BD\n";
            } else {
                echo "Error no se inserto el pasajero en la BD. \n";
            }
        } else {
            echo "No hay lugar en el viaje (Total Asientos:".$cantAsientosTotal.", Asientos Vendidos:".$cantAsientosOcupados.")\n";
        }
    } else {
        echo "No existe el viaje con destino ese destino.\n";
    }
}

function modificarPasajero()
{
    echo "Ingrese ID del viaje: ";
    $id = trim(fgets(STDIN));
    $viaje = new Viaje();
    $DatosViaje = $viaje->listar("idviaje =".$id);
    $pasajero = new Pasajero();

    if (count($DatosViaje)==1) {
        imprimir($pasajero->listar("idviaje=".$DatosViaje[0]->getidviaje()));
    } else {
        echo "No hay un viaje con ese destino.";
    }

    $pasajero = new Pasajero();
    echo "Ingrese Dni del pasajero: ";
    $dni = trim(fgets(STDIN));
    $pasajero->Buscar($dni);
    $aux = $pasajero;

    if ($pasajero->getNumDoc()!= "") {
        echo "Ingrese Nombre del Pasajero: ";
        $nombrePasajero = trim(fgets(STDIN));
        echo "Ingrese Apellido del pasajero: ";
        $apellidoPasajero = trim(fgets(STDIN));
        echo "Ingrese el telefono del pasajero:";
        $telefonoPasajero=trim(fgets(STDIN));
        $pasajero->setNumDoc($aux->getNumDoc());
        $pasajero->setNombre($nombrePasajero);
        $pasajero->setApellido($apellidoPasajero);
        $pasajero->setTelefono($telefonoPasajero);
        $pasajero->setViaje($aux->getViaje());

        echo "Desea tamesNum cambiarlo de viaje? Pulse S para SI sino otra tecla.";
        $r = trim(fgets(STDIN));
        if ($r=='S' or $r=='s') {
            echo "Ingrese nuevo destino: ";
            $destino = trim(fgets(STDIN));
            $viaje = new Viaje();
            $DatosViaje = $viaje->listar("destino =".$destino);
            if (count($DatosViaje) == 1) {
                $idviaje = $DatosViaje[0]['idviaje'];
                $viaje->Buscar($idviaje);
                $pasajero->setViaje($viaje);
                $pasajero->modificar();
            }
        }
    } else {
        echo "No existe ese dni:".$dni;
    }
}

function borrarPasajero()
{
    $pasajero = new Pasajero();
    echo "Ingrese Dni del pasajero a eliminar ";
    $dni = trim(fgets(STDIN));
    $pasajero->Buscar($dni);
    if ($pasajero->getNumDoc() != "") {
        $pasajero->eliminar();
    } else {
        echo "No existe ese pasajero dni:".$dni."\n";
    }
}
