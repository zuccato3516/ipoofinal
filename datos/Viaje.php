<?php

class Viaje{
    private $idviaje;
    private $destino;
    private $cantMaxima;
    private $objResponsable; 
    private $objEmpresa;
    private $importe; 
    private $tipoAsiento;
    private $idayvuelta;
    private $mensajeoperacion;
    
    public function __construct(){
        $this->idviaje="";
        $this->destino="";
        $this->cantMaxima=0;
        $this->importe=0.00;
        $this->tipoAsiento="";
        $this->idayvuelta="";
    }

    public function cargar($id, $destino, $cantMax, $objResponsable,$objEmpresa,$importe,$tipoAsiento,$idayvuelta){
        $this->idviaje=$id;
        $this->destino=$destino;
        $this->cantMaxima=$cantMax;
        $this->objResponsable=$objResponsable;
        $this->objEmpresa=$objEmpresa;
        $this->importe=$importe;
        $this->tipoAsiento=$tipoAsiento;
        $this->idayvuelta=$idayvuelta;

    }
   
    public function getidviaje(){
        return $this->idviaje;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getCantMaxima(){
        return $this->cantMaxima;
    }
    public function getobjResponsable(){
        return $this->objResponsable;
    }
    public function getobjEmpresa(){
        return $this->objEmpresa;
    }
    public function setobjEmpresa($objEmpresa){
        $this->objEmpresa = $objEmpresa;
    }
    public function getImporte(){
        return $this->importe;
    }
    public function setImporte($importe){
        $this->importe = $importe;
    }
    
    public function getTipoAsiento(){
        return $this->tipoAsiento;
    }
    
    public function setTipoAsiento($tipoAsiento){
        $this->tipoAsiento = $tipoAsiento;
    }
    
    public function getIdayvuelta(){
        return $this->idayvuelta;
    }
    
    public function setIdayvuelta($idayvuelta){
        $this->idayvuelta = $idayvuelta;
    }
    public function setidviaje($id){
        $this->idviaje=$id;
    }
    public function setDestino($des){
        $this->destino=$des;
    }
    public function setcantMaxima($m){
        $this->cantMaxima=$m;
    }
       public function setobjResponsable($obj_responsablev){
        $this->objResponsable = $obj_responsablev;
    }
    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion=$mensajeoperacion;
     }

     public function getmensajeoperacion(){
		return $this->mensajeoperacion;
	} 
    // == FUNCTIONS ==
    
    /**
     * Arma un string con los datos del arreglo de pasajeros
     * @return string
     */
    public function datosPasajeros($idViaje){
        $aux = "";
        //llama ala base de datos para cargar los pasajeros
        $p = new Pasajero();
        $coleccion_pasajeros = $p->listar("idviaje=".$idViaje);

        if(count($coleccion_pasajeros)>0){
            foreach ($coleccion_pasajeros as $key => $p)
            {
                $aux = $aux." ".$p->__toString()."\n";
            }
            $aux = substr($aux,0,strlen($aux)-2);
            $aux  = $aux . "\n";
        }else{
            $aux ="No se han cargado pasajeros todavía.\n";
        }
        return $aux;
       }
    
      /**
     * Definicion de metodo string
     * @return string
     */
    
    public function __toString(){
        return 
        "Reporte: Viaje 
         \nidviaje del viaje: ".$this->getidviaje().
        "\nDestino: ".$this->getDestino().
        "\nCapacidad Máxima: ".$this->getCantMaxima().
        "\nImporte: ".$this->getImporte().
        "\nTipo Asiento:\n".$this->getTipoAsiento().
        "\nIda y Vuelta:\n".$this->getidviaje().
        "\nEmpresa:\n".$this->getobjEmpresa().
        "\nobj_Responsable: ".$this->getobjResponsable();
    }


    /** METODOS DE BASE DE DATOS */

   	
    public function Buscar($idViaje){
		$base = new BaseDatos();
		$cSql="Select * from viaje where idviaje =".$idViaje ;
		$resp= false;

		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){
				if($row2=$base->Registro()){					
				    $this->setidviaje($idViaje);
					$this->setDestino($row2['vdestino']);
					$this->setcantMaxima($row2['vcantmaxpasajeros']);
                    $this->setImporte($row2['vimporte']);
                    $this->setTipoAsiento($row2['tipoAsiento']);
                    $this->setIdayvuelta($row2['idayvuelta']);
					
					//cargar obj_
					$emp = new Empresa();
                    $idEmpresa = $row2['idempresa'];
					$emp->Buscar($idEmpresa);
               		$this->setobjEmpresa($emp);

                    //cargar obj_Responsable
					$empl = new ResponsableV();
                    $numEmpleado = $row2['rnumeroempleado'];
					$empl->Buscar($numEmpleado);
               		$this->setobjResponsable($empl);

					$resp= true;
				}				
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }		
		 return $resp;
	}	

	public function listar($condicion=""){
	     $datosViaje = null;
         $arregloDatos = [];
		$base = new BaseDatos();
		$cSql="Select * from viaje ";
		if ($condicion!=""){
		    $cSql=$cSql.' where '.$condicion;
		}
		$cSql.=" order by idempresa ";

		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){				
				$datosViaje= array();
				while($row2=$base->Registro()){
                    $idViaje = $row2['idviaje'];
					$destino=$row2['vdestino'];
					$cantPasajero=$row2['vcantmaxpasajeros'];
					
					$importe=$row2['vimporte'];
					$tipoAsiento=$row2['tipoAsiento'];
					$idayvuelta=$row2['idayvuelta'];

                    $obj_responsable = new ResponsableV();
                    $obj_responsable->Buscar($row2['rnumeroempleado']);

                    $obj_empresa= new Empresa();
					$obj_empresa->Buscar($row2['idempresa']);
                   
					$obj_viaje= new Viaje();
					$obj_viaje->cargar($idViaje,$destino,$cantPasajero,$obj_responsable,$obj_empresa,$importe,$tipoAsiento,$idayvuelta);
					array_push($datosViaje,$obj_viaje);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
        return $datosViaje;
	}	
	
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar =
        "INSERT INTO viaje(vdestino, vcantmaxpasajeros,idempresa,  rnumeroempleado, vimporte,tipoAsiento,idayvuelta) 
		VALUES ('".$this->getDestino()."',".$this->getCantMaxima().",".$this->getobjEmpresa()->getIdEmpresa().",".
        $this->getobjResponsable()->getnumEmpleado().",".$this->getImporte().",'".$this->getTipoAsiento()."','".$this->getIdayvuelta()."')";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaInsertar)){
                $this->setidviaje($base->DevolverID());
			    $resp=  true;
			}	else {
					$this->setmensajeoperacion($base->getError());
			}
		} else {
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	public function modificarTodo(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getDestino()."',vcantmaxpasajeros=".$this->getCantMaxima()."
                           ,idempresa =".$this->getObjEmpresa()->getIdEmpresa().",rnumeroempleado =".$this->getObjResponsable()->getnumEmpleado().
                          ", vimporte =".$this->getImporte().",tipoAsiento ='".$this->getTipoAsiento()."', idayvuelta='".$this->getIdayvuelta().
                           "' WHERE idviaje =". $this->getidviaje();

		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				echo $this->setmensajeoperacion($base->getError());
                
			}
		}else{
            echo $this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	public function modificarSinDelegados(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getDestino()."',
        vcantmaxpasajeros=".$this->getCantMaxima().",
        vimporte =".$this->getImporte().",
        tipoAsiento ='".$this->getTipoAsiento()."',
        idayvuelta='".$this->getIdayvuelta()."' WHERE idviaje =". $this->getidviaje();

        echo $consultaModifica."\n";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getidviaje();
				if($base->Ejecutar($consultaBorra)){
				    $resp =  true;
				}else{
						$this->setmensajeoperacion($base->getError());
				}
		}else{
				$this->setmensajeoperacion($base->getError());
		}
		return $resp; 
	}
    
}

