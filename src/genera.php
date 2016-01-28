<?php
		set_time_limit(0);
		ini_set('memory_limit', '-1');

	function generateMail($length = 5) {
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	if (isset($_POST)) {
		header("Content-type: text/plain; charset=utf-8");
		header("Content-Disposition: attachment; filename=\"".$_POST['nom_archivo'].".sql\"");
		require_once('Connection.php');

		/** Variables fijas **/
		$cdb = "CREATE DATABASE ";
		$auto_i = "AUTO_INCREMENT";
		$PK = "PRIMARY KEY ";
		/** Fin variables fijas */

		// Creacion de la conexion a la base de datos
		$dbverf = new Connection();
		
		/*
		 * Obtencion del tamaño de cada tabla
		 */
		$nomHom = $dbverf->countNh();
		$nomMuj = $dbverf->countNm();
		$apel = $dbverf->countApp();
		$loca = $dbverf->countLoc();
		$munic = $dbverf->countMun();
		$esta = $dbverf->countEst();
		$pais = $dbverf->countPais();
		
		// Obtenemos los valores
		$tnh = $dbverf->selectNombreHombre();
		$tnm = $dbverf->selectNombreMujer();
		$tapp = $dbverf->selectApp();
		$tloc = $dbverf->selectLocalidad();
		$tmun = $dbverf->selectMunicipio();
		$test = $dbverf->selectEstado();
		$tpa = $dbverf->selectPais();
		
		// clonamos el array para manipularlo
		$clonePOST = $_POST;
		
		// quitamos elementos del array para solo quedarnos con los 'input' y los 'select'
		unset($_POST['nom_archivo']);
		unset($_POST['cantidad']);
		unset($_POST['nom_tabla']);
		unset($_POST['inc_ct']);
		unset($_POST['inc_cdb']);
		unset($_POST['pk_opc']);
		unset($_POST['num_filas']);
		unset($_POST['generar']);
		
		// calculamos el tamaño del array de solo inputs y selects
		$taman = count($_POST);
		
		$arrayID = array_keys($_POST);
		
		$numero = ""; // variable para los telefonos

		// Validaciones para las opciones del usuario
		/**
		 * Si se ha elegido incluir CREATE DATABASE
		 */
		if ($clonePOST['inc_cdb']=="on") {
			$sintaxis = $cdb.$clonePOST['nom_archivo'].";\nUSE ".$clonePOST['nom_archivo'].";\n\n";
		}
		/**
		 * Si se ha elegido incluir CREATE TABLE
		 */
		if($clonePOST['inc_ct']=="on"){
			if ($clonePOST['pk_opc']=="default") {
				$sintaxis .= "DROP TABLE ".$clonePOST['nom_tabla'].";\nCREATE TABLE ".$clonePOST['nom_tabla']."(id int ".$PK.$auto_i;
			} else {
				$sintaxis .= "DROP TABLE ".$clonePOST['nom_tabla'].";\nCREATE TABLE ".$clonePOST['nom_tabla']."(id int NOT NULL";
			}
			// obtenemos solo los nombres escritos en los input, el if es para obtener los pares 
			for ($i=0; $i <= $taman-1; $i++) { 
				if ($i%2==0) 
				{ 
					$sintaxis .= ", \n\t".$_POST[$arrayID[$i]]." varchar(255) NOT NULL";
				}
			}
			$sintaxis .=")ENGINE=MyISAM DEFAULT CHARSET=utf8;\n\n";
		}
		/**
		 * Aqui comienzan las consultas
		 */
		
		$sintaxis .= "INSERT INTO ".$clonePOST['nom_tabla']." (";
		for ($i=0; $i <= $taman-1; $i++) { 
			if ($i%2==0) 
			{ 
				$sintaxis .= $_POST[$arrayID[$i]].", "; 
			}
		}
		$sintaxis .= ") VALUES ";
		
		for ($k=1; $k <= $clonePOST['num_filas']; $k++) {
			$sintaxis .= "(";
			for ($i=0; $i <= $taman-1; $i++) {
				// Switch que gestiona el tipo de dato a generar segun lo escogido por el usuario
				switch ($_POST[$arrayID[$i]]) {
					case 'nom_h':
						$res = $tnh[mt_rand(1, $nomHom[0]['nh'])]['nom_h'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'nom_m':
						$res = $tnm[mt_rand(1, $nomMuj[0]['nm'])]['nom_m'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'app_pat':
						$res = $tapp[mt_rand(1, $apel[0]['ape'])]['app'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'app_mat':
						$res = $tapp[mt_rand(1, $apel[0]['ape'])]['app'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'email':
						$sintaxis .= "\"".generateMail()."@hotmail.com\",";
					break;
					case 'telefono':
						// Se genera un numero de 10 cifras aleatorias para el telefono usando la funcion rand()
						for ($tel = 0; $tel < 10; $tel++) { 
							$numero .= mt_rand(0, 9);
						}
						$sintaxis .= "\"".$numero."\",";
						$numero = "";
					break;
					case 'password':
						// generacion de una cadena de numeros y letras para la contraseña
						$sintaxis .= "\"".generateMail(8)."\","; 
					break;
					case 'localidad':
						$res = $tloc[mt_rand(1, $loca[0]['loc'])]['nom_loc'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'municipio':
						$res = $tmun[mt_rand(1, $munic[0]['mun'])]['nom_mun'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'estado':
						$res = $test[mt_rand(1, $esta[0]['est'])]['nom_estado'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'pais':
						$res = $tpa[mt_rand(1, $pais[0]['pai'])]['nom_pais'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'ai':
						$sintaxis .= "\"".($k)."\",";
					break;
					case 'dal':
						$sintaxis .= "\"".(mt_rand(1*100, 10000*100)/100)."\",";
					break;
					case 'dinero':
						$sintaxis .= "\"$".(mt_rand(1*100, 10000*100)/100)."\",";
					break;
				}
			}
			if($k == $clonePOST['num_filas']){
				$sintaxis .= " );\n";
			}else{
				$sintaxis .= " ),\n";
			}
		}
		echo str_replace(", )",")", $sintaxis);
	}
 ?>