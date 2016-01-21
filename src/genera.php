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
		$create = "CREATE TABLE ";
		$drop = "DROP TABLE ";
		$auto_i = "auto_increment";
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
		
		// clonamos el array para manipularlo
		$clonePOST = $_POST;
		//var_dump($clonePOST);
		
		// quitamos elementos del array para solo quedarnos con los 'input' y los 'select'
		unset($_POST['nom_archivo']);
		unset($_POST['cantidad']);
		unset($_POST['nom_tabla']);
		unset($_POST['inc_ct']);
		unset($_POST['inc_dt']);
		unset($_POST['pk_opc']);
		unset($_POST['num_filas']);
		unset($_POST['generar']);
		
		// calculamos el tamaño del array de solo inputs y selects (RELACION[input,select]) es decir va uno y uno
		$taman = count($_POST);
		
		$arrayID = array_keys($_POST);
		//var_dump($arrayID);
		$numero = ""; // variable para los telefonos

		// Validaciones para las opciones del usuario
		/**
		 * Si se ha elegido incluir DROP TABLE
		 */
		if ($clonePOST['inc_dt']=="on") {
			$sintaxis = $drop.$clonePOST['nom_tabla'].";\n\n";
		}
		/**
		 * Si se ha elegido incluir CREATE TABLE
		 */
		if($clonePOST['inc_ct']=="on"){
			if ($clonePOST['pk_opc']=="default") {
				$sintaxis .= $create.$clonePOST['nom_tabla']."(id int ".$PK.$auto_i;
			} else {
				$sintaxis .= $create.$clonePOST['nom_tabla']."(id int NOT NULL";
			}
			// obtenemos solo los nombres escritos en los input, el if es para obtener los pares 
			for ($i=0; $i <= $taman-1; $i++) { 
				if ($i%2==0) 
				{ 
					$sintaxis .= ", \n".$_POST[$arrayID[$i]]." varchar(255) NOT NULL";
				}
			}
			$sintaxis .=");\n\n";
		}
		/**
		 * Aqui comienzan las consultas
		 */
		if ($clonePOST['pk_opc']=="default") {
			for ($k=1; $k <= $clonePOST['num_filas']; $k++) {
				$sintaxis .= "INSERT INTO ".$clonePOST['nom_tabla']." (";
				for ($i=0; $i <= $taman-1; $i++) { 
					if ($i%2==0) 
					{ 
						$sintaxis .= $_POST[$arrayID[$i]].", "; 
					}
				}
				$sintaxis .= ") VALUES (";
				for ($i=0; $i <= $taman-1; $i++) { 
					if ($i%2!=0) 
					{ 
						// Switch que gestiona el tipo de dato a generar segun lo escogido por el usuario
						switch ($_POST[$arrayID[$i]]) {
							case 'nom_h':
								$res = $dbverf->selectNombreHombre(rand(1, $nomHom[0]['nh']));
								$sintaxis .= "\"".$res[0]['nom_h']."\",";
							break;
							case 'nom_m':
								$res = $dbverf->selectNombreMujer(rand(1, $nomMuj[0]['nm']));
								$sintaxis .= "\"".$res[0]['nom_m']."\",";
							break;
							case 'app_pat':
								$res = $dbverf->selectApp(rand(1, $apel[0]['ape']));
								$sintaxis .= "\"".$res[0]['app']."\",";
							break;
							case 'app_mat':
								$res = $dbverf->selectApp(rand(1, $apel[0]['ape']));
								$sintaxis .= "\"".$res[0]['app']."\",";
							break;
							case 'email':
								$sintaxis .= "\"".generateMail()."@hotmail.com\",";
							break;
							case 'telefono':
								// Se genera un numero de 10 cifras aleatorias para el telefono usando la funcion rand()
								for ($tel = 0; $tel < 10; $tel++) { 
									$numero .= rand(0, 9);
								}
								$sintaxis .= "\"".$numero."\",";
								$numero = "";
							break;
							case 'password':
								// generacion de una cadena de numeros y letras para la contraseña
								$sintaxis .= "\"".generateMail(8)."\","; 
							break;
							case 'localidad':
								$res = $dbverf->selectLocalidad(rand(1, $loca[0]['loc']));
								$sintaxis .= "\"".$res[0]['nom_loc']."\",";
							break;
							case 'municipio':
								$res = $dbverf->selectMunicipio(rand(1, $munic[0]['mun']));
								$sintaxis .= "\"".$res[0]['nom_mun']."\",";
							break;
							case 'estado':
								$res = $dbverf->selectEstado(rand(1, $esta[0]['est']));
								$sintaxis .= "\"".$res[0]['nom_estado']."\",";
							break;
						}
					}
				}
				$sintaxis .= " );\n";
            }
		} else {

            for ($k=1; $k <= $clonePOST['num_filas']; $k++) {
                $sintaxis .= "INSERT INTO ".$clonePOST['nom_tabla']." VALUES('".$k."',";
                for ($i=0; $i <= $taman-1; $i++) {
                    if ($i%2!=0)
                    {
                    	// Switch que gestiona el tipo de dato a generar segun lo escogido por el usuario
                        switch ($_POST[$arrayID[$i]]) {
							case 'nom_h':
								$res = $dbverf->selectNombreHombre(rand(1, $nomHom[0]['nh']));
								$sintaxis .= "\"".$res[0]['nom_h']."\",";
							break;
							case 'nom_m':
								$res = $dbverf->selectNombreMujer(rand(1, $nomMuj[0]['nm']));
								$sintaxis .= "\"".$res[0]['nom_m']."\",";
							break;
							case 'app_pat':
								$res = $dbverf->selectApp(rand(1, $apel[0]['ape']));
								$sintaxis .= "\"".$res[0]['app']."\",";
							break;
							case 'app_mat':
								$res = $dbverf->selectApp(rand(1, $apel[0]['ape']));
								$sintaxis .= "\"".$res[0]['app']."\",";
							break;
							case 'email':
								$sintaxis .= "\"".generateMail()."@gmail.com\",";
							break;
							case 'telefono':
								// Se genera un numero de 10 cifras aleatorias para el telefono usando la funcion rand()
								for ($tel=0; $tel < 10; $tel++) { 
									$numero .= rand(0, 9);
								}
								$sintaxis .= "\"".$numero."\",";
								$numero = "";
							break;
							case 'password':
								// generacion de una cadena de numeros y letras para la contraseña
								$sintaxis .= "\"".generateMail(8)."\","; 
							break;
							case 'localidad':
								$res = $dbverf->selectLocalidad(rand(1, $loca[0]['loc']));
								$sintaxis .= "\"".$res[0]['nom_loc']."\",";
							break;
							case 'municipio':
								$res = $dbverf->selectMunicipio(rand(1, $munic[0]['mun']));
								$sintaxis .= "\"".$res[0]['nom_mun']."\",";
							break;
							case 'estado':
								$res = $dbverf->selectEstado(rand(1, $esta[0]['est']));
								$sintaxis .= "\"".$res[0]['nom_estado']."\",";
							break;
                        }
                    }
                }
                $sintaxis .= " );\n";
            }
		}
		echo str_replace(", )",")", $sintaxis);
	}
 ?>