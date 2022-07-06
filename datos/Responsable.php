<?php


    class ResponsableV{
        private $nombre;
        private $apellido;
        private $numEmpleado;
        private $numLicencia;
        private $mensajeoperacion;
        
        public function __construct(){
           $this->nombre="";
           $this->apellido="";
           $this->numEmpleado="";
           $this->numLicencia=""; 
        }
       
        public function cargar($NroE,$Nom,$Ape,$NroL){
         $this->setnumEmpleado($NroE);
         $this->setNombre($Nom);
         $this->setApellido($Ape);
         $this->setnumLicencia($NroL);
        }
        public function getNombre()
        {
           return $this->nombre;
        }
        public function setNombre($nombre)
        {
           $this->nombre = $nombre;
        }
        public function getApellido()
        {
           return $this->apellido;
        }
        public function setApellido($apellido)
        {
           $this->apellido = $apellido;
        }
        public function getnumEmpleado()
        {
                return $this->numEmpleado;
        }
        public function setnumEmpleado($numEmpleado)
        {
                $this->numEmpleado = $numEmpleado;
        }
        public function getnumLicencia()
        {
                return $this->numLicencia;
        }

        public function setnumLicencia($numLicencia)
        {
                $this->numLicencia = $numLicencia;
        }

        public function __toString()
        {
             return "Responsable: Apellido: ".$this->getApellido().", Nombre:".$this->getNombre().", núm Empleado:".$this->getnumEmpleado().", num Licencia:".$this->getnumLicencia()."\n";
        }
        public function setmensajeoperacion($mensajeoperacion){
         $this->mensajeoperacion=$mensajeoperacion;
      }

	  public function getmensajeoperacion(){
		return $this->mensajeoperacion;
	 }
        
	/**
	 * Recupera los datos de un responsable por número de empleado
	 * @param int $numEmpleado
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($numEmpleado){
		$base = new BaseDatos();
		$cSql="Select * from responsable where rnumeroempleado=".$numEmpleado;
		$resp= false;

		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){
				if($row2=$base->Registro()){					
				    $this->setnumEmpleado($numEmpleado);
					$this->setNombre($row2['rnombre']);
					$this->setApellido($row2['rapellido']);
					$this->setnumLicencia($row2['rnumerolicencia']);
					
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
	    $arregloResponsable = null;
		$base = new BaseDatos();
		$cSql="Select * from responsable ";
		if ($condicion!=""){
		    $cSql=$cSql.' where '.$condicion;
		}
		$cSql.=" order by rapellido ";
		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){				
				$array= array();
				while($row2=$base->Registro()){
					
					$NroE=$row2['rnumeroempleado'];
					$Nombre=$row2['rnombre'];
					$Apellido=$row2['rapellido'];
					$numLicencia=$row2['rnumerolicencia'];
					$responsable = new ResponsableV();
					$responsable->cargar($NroE,$Nombre,$Apellido,$numLicencia);
					array_push($array,$responsable);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $array;
	}	

	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar="INSERT INTO responsable( rnombre, rapellido,  rnumerolicencia) 
				VALUES ('".$this->getNombre()."','".$this->getApellido()."',".$this->getnumLicencia().")";
		
		if($base->Iniciar()){
			if($base->Ejecutar($consultaInsertar)){
				$this->setnumEmpleado($base->DevolverID());
			    $resp=  true;
			}	else {
					$this->setmensajeoperacion($base->getError());
			}
		} else {
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	public function modificar(){
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica="UPDATE responsable SET rapellido='".$this->getApellido()."',rnombre='".$this->getNombre()."'
                           ,rnumerolicencia=".$this->getnumLicencia()." WHERE rnumeroempleado=". $this->getnumEmpleado();
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
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->getnumEmpleado();
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
?>