<?php
class Connection{
	private $conn;
	public function __construct(){
		$this->conn = new PDO('sqlite:gendata.db');
	}
	public function __destruct(){}
	
	public function selectNombreHombre($id){
 		$query = "SELECT nom_h FROM nombre_hombre WHERE id_nh=$id";
 		
		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectNombreMujer($id){
 		$query = "SELECT nom_m FROM nombre_mujer WHERE id_nm=$id";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectApp($id){
 		$query = "SELECT app FROM apellido WHERE id_app=$id";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectLocalidad($id){
 		$query = "SELECT nom_loc FROM localidad WHERE id_loc=$id";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
 	public function selectMunicipio($id){
 		$query = "SELECT nom_mun FROM municipio WHERE id_municipio=$id";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
 	public function selectEstado($id){
 		$query = "SELECT nom_estado FROM estado WHERE id_estado=$id";
 		$result = $this->conn->prepare($query);

		$result->execute();
		return $result->fetchAll(PDO::FETCH_ASSOC);
 	}
	
	public function selectPais($id){
 		$query = "SELECT nom_pais FROM pais WHERE id_pais=$id";
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
}