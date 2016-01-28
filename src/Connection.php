<?php
class Connection{
	private $conn;
	public function __construct(){
		$this->conn = new PDO('sqlite:gendata.db');
	}
	public function __destruct(){}
	
	public function selectNombreHombre(){
 		$query = "SELECT nom_h FROM nombre_hombre";
 		
		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectNombreMujer(){
 		$query = "SELECT nom_m FROM nombre_mujer";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectApp(){
 		$query = "SELECT app FROM apellido";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectLocalidad(){
 		$query = "SELECT nom_loc FROM localidad";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
 	public function selectMunicipio(){
 		$query = "SELECT nom_mun FROM municipio";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
 	public function selectEstado(){
 		$query = "SELECT nom_estado FROM estado";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectPais(){
 		$query = "SELECT nom_pais FROM pais";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectTipoAl(){
 		$query = "SELECT tipoAl FROM tipoAl";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectTrabajo(){
 		$query = "SELECT nomTra FROM trabajos";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectGrupo(){
 		$query = "SELECT nomGrup FROM grupos";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectPeriodo(){
 		$query = "SELECT nomPer FROM periodo";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectParcial(){
 		$query = "SELECT nomPar FROM parcial";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectCalif(){
 		$query = "SELECT nomCal FROM calific";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectEsc(){
 		$query = "SELECT nomEsc FROM escuela";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectAsis(){
 		$query = "SELECT nomAsist FROM asisten";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectSalon(){
 		$query = "SELECT nomSal FROM salon";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	/*
	 * Obtencion de total de elementos en las tablas de datos
	 */
	
	public function countNh(){
 		$query = "SELECT count(id_nh)nh FROM nombre_hombre";
 		
		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countNm(){
 		$query = "SELECT count(id_nm)nm FROM nombre_mujer";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countApp(){
 		$query = "SELECT count(id_app)ape FROM apellido";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countLoc(){
 		$query = "SELECT count(id_loc)loc FROM localidad";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
 	public function countMun(){
 		$query = "SELECT count(id_municipio)mun FROM municipio";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
 	public function countEst(){
 		$query = "SELECT count(id_estado)est FROM estado";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countPais(){
 		$query = "SELECT count(id_pais)pai FROM pais";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countTipo(){
 		$query = "SELECT count(id_ta)ta FROM tipoAl";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countTrab(){
 		$query = "SELECT count(id_trab)trab FROM trabajos";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countGrupo(){
 		$query = "SELECT count(id_grupo)grup FROM grupos";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countPer(){
 		$query = "SELECT count(id_per)per FROM periodo";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countPar(){
 		$query = "SELECT count(id_par)par FROM parcial";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countCal(){
 		$query = "SELECT count(id_cal)cal FROM calific";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countEsc(){
 		$query = "SELECT count(id_esc)esc FROM escuela";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countAsis(){
 		$query = "SELECT count(id_asis)asis FROM asisten";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function countSal(){
 		$query = "SELECT count(id_sal)sal FROM salon";
 		$result = $this->conn->prepare($query);
		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
}