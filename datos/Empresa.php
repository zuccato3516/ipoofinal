<?php
    class Empresa{
        private $idempresa;
        private $enombre;
        private $edireccion;
      
        
        public function __construct(){
           $this->idempresa="";
           $this->enombre="";
           $this->edireccion="";
           
        }
       
        public function cargar($IdEmpresa,$Enom,$Edir){
         $this->setIdEmpresa($IdEmpresa);
         $this->setENombre($Enom);
         $this->setEdireccion($Edir);
       
        }
        public function getIdEmpresa()
        {
           return $this->idempresa;
        }
        public function setIdEmpresa($Idempresa)
        {
           $this->idempresa = $Idempresa;
        }
        public function getEnombre()
        {
           return $this->enombre;
        }
        public function setEnombre($Enombre)
        {
           $this->enombre = $Enombre;
        }
        public function getEdireccion()
        {
                return $this->edireccion;
        }
        public function setEdireccion($edireccion)
        {
                $this->edireccion = $edireccion;
        }
   
        public function __toString()
        {
             return "Empresa: ENombre: ".$this->getEnombre().", ID:".$this->getIdEmpresa().", Direccion:".$this->getEdireccion()."\n";
        }
        public function setmensajeoperacion($mensajeoperacion){
         $this->mensajeoperacion=$mensajeoperacion;
      }
        
	  public function getmensajeoperacion(){
		return $this->mensajeoperacion;
	 }
	   

	/**
	 * Recupera los de la Empresa, Por ID
	 * @param int $IdEmpresa
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($ID){
		$base = new BaseDatos();
		$cSql="Select * from empresa where idempresa=".$ID;
		$resp= false;

		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){
				if($row2=$base->Registro()){					
				    $this->setIdEmpresa($ID);
					$this->setEnombre($row2['enombre']);
					$this->setEdireccion($row2['edireccion']);
					
	
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
	    $arregloEmpresa = null;
		$base = new BaseDatos();
		$cSql="Select * from empresa ";
		if ($condicion!=""){
		    $cSql=$cSql.' where '.$condicion;
		}
		$cSql.=" order by enombre ";
		
		if($base->Iniciar()){
			if($base->Ejecutar($cSql)){				
				$arregloEmpresa= array();
				while($row2=$base->Registro()){
					
					$IdEmpresa=$row2['idempresa'];
					$ENombre=$row2['enombre'];
					$EDireccion=$row2['edireccion'];
				
					
					$p = new Empresa();
					$p->cargar($IdEmpresa,$ENombre,$EDireccion);
					array_push($arregloEmpresa,$p);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arregloEmpresa;
	}	
	
	public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar="INSERT INTO empresa( enombre, edireccion) 
				VALUES ('".$this->getEnombre()."','".$this->getEdireccion()."')";

if($base->Iniciar()){
	if($base->Ejecutar($consultaInsertar)){
		$this->setIdEmpresa($base->DevolverID());
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
		$consultaModifica="UPDATE empresa SET enombre='".$this->getEnombre()."',edireccion='".$this->getEdireccion()."'"."WHERE idempresa=".$this->getIdEmpresa();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				$base->getError();
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
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
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