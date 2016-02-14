<?php
		set_time_limit(0);
		ini_set('memory_limit', '-1');

	function generateMail($length = 5) {
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
	function random_date($from = 0, $to = null) {
		if (!$to) {
			$to = date('U');
		}
		if (!ctype_digit($from)) {
			$from = strtotime($from);
		}
		if (!ctype_digit($to)) {
			$to = strtotime($to);
		}
		return date('Y-m-d', rand($from, $to));
	}
	function random_hour($from = 0, $to = null) {
		if (!$to) {
			$to = date('U');
		}
		if (!ctype_digit($from)) {
			$from = strtotime($from);
		}
		if (!ctype_digit($to)) {
			$to = strtotime($to);
		}
		return date('H:i:s', rand($from, $to));
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
		
		$tipo = $dbverf->countTipo();
		$trabajo = $dbverf->countTrab();
		$grupo = $dbverf->countGrupo();
		$periodo = $dbverf->countPer();
		$parcial = $dbverf->countPar();
		$calif = $dbverf->countCal();
		$escuela = $dbverf->countEsc();
		$asitencia = $dbverf->countAsis();
		$salon = $dbverf->countSal();
		$materia = $dbverf->countMat();
		$prof = $dbverf->countPr();
		
		// Obtenemos los valores
		$tnh = $dbverf->selectNombreHombre();
		$tnm = $dbverf->selectNombreMujer();
		$tapp = $dbverf->selectApp();
		$tloc = $dbverf->selectLocalidad();
		$tmun = $dbverf->selectMunicipio();
		$test = $dbverf->selectEstado();
		$tpa = $dbverf->selectPais();
		
		$ttal = $dbverf->selectTipoAl();
		$ttrab = $dbverf->selectTrabajo();
		$tgrup = $dbverf->selectGrupo();
		$tper = $dbverf->selectPeriodo();
		$tpar = $dbverf->selectParcial();
		$tcalif = $dbverf->selectCalif();
		$tesc = $dbverf->selectEsc();
		$tasis = $dbverf->selectAsis();
		$tsal = $dbverf->selectSalon();
		$tmat = $dbverf->selectMateria();
		$tprof = $dbverf->selectProf();
		
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
			$sintaxis = $cdb.$clonePOST['nom_archivo']." DEFAULT CHARACTER SET utf8;\nUSE ".$clonePOST['nom_archivo'].";\n\n";
		}
		/**
		 * Si se ha elegido incluir CREATE TABLE
		 */
		if($clonePOST['inc_ct']=="on"){
			if ($clonePOST['pk_opc']=="default") {
				$sintaxis .= "DROP TABLE IF EXISTS ".$clonePOST['nom_tabla'].";\nCREATE TABLE ".$clonePOST['nom_tabla']."(id int ".$PK.$auto_i;
			} else {
				$sintaxis .= "DROP TABLE IF EXISTS ".$clonePOST['nom_tabla'].";\nCREATE TABLE ".$clonePOST['nom_tabla']."(";
			}
			// obtenemos solo los nombres escritos en los input, el if es para obtener los pares 
			for ($i=0; $i <= $taman-1; $i++) { 
				if ($i%2==0) {
					$sintaxis .= ", \n\t".$_POST[$arrayID[$i]];
				}
				if ($i%2!=0) {
					switch($_POST[$arrayID[$i]]){
						case 'telefon': case 'matric':
							$sintaxis .= " bigint NOT NULL";
						break;
						case 'dal':
						case 'calif':
							$sintaxis .= " double NOT NULL";
						break;
						case 'ai': case 'intale':
							$sintaxis .= " int NOT NULL";
						break;
						case 'fecDate':
							$sintaxis .= " DATE NOT NULL";
						break;
						case 'houDate':
							$sintaxis .= " TIME NOT NULL";
						break;
						default:
							$sintaxis .= " VARCHAR(255) NOT NULL";
						break;
					}
				}
				
			}
			$sintaxis = str_replace("(,","(", $sintaxis);
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
						$res = $tnh[mt_rand(0, $nomHom[0]['nh'])]['nom_h'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'nom_m':
						$res = $tnm[mt_rand(0, $nomMuj[0]['nm'])]['nom_m'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'app_pat':
						$res = $tapp[mt_rand(0, $apel[0]['ape'])]['app'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'app_mat':
						$res = $tapp[mt_rand(0, $apel[0]['ape'])]['app'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'emai':
						$sintaxis .= "\"".generateMail()."@hotmail.com\",";
					break;
					case 'telefon':
						// Se genera un numero de 10 cifras aleatorias para el telefono usando la funcion rand()
						for ($tel = 0; $tel < 10; $tel++) { 
							$numero .= mt_rand(0, 9);
						}
						$sintaxis .= "\"".$numero."\",";
						$numero = "";
					break;
					case 'passwd':
						// generacion de una cadena de numeros y letras para la contraseña
						$sintaxis .= "\"".generateMail(8)."\","; 
					break;
					case 'lcld':
						$res = $tloc[mt_rand(0, $loca[0]['loc'])]['nom_loc'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'munic':
						$res = $tmun[mt_rand(0, $munic[0]['mun'])]['nom_mun'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'estd':
						$res = $test[mt_rand(0, $esta[0]['est'])]['nom_estado'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'paisW':
						$res = $tpa[mt_rand(0, $pais[0]['pai'])]['nom_pais'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'ai':
						$sintaxis .= "\"".($k)."\",";
					break;
					case 'intale':
						$sintaxis .= "\"".(mt_rand(1, $clonePOST['num_filas']))."\",";
					break;
					case 'dal':
						$sintaxis .= "\"".(mt_rand(1*100, 10000*100)/100)."\",";
					break;
					case 'mondin':
						$sintaxis .= "\"$".(mt_rand(1*100, 10000*100)/100)."\",";
					break;
					case 'matric':
						$sintaxis .= "\"".(mt_rand(1, 10000000))."\",";
					break;
					case 'calif':
						$sintaxis .= "\"".(mt_rand(1, 100)/10)."\",";
					break;
					case 'fecDate':
						$sintaxis .= "\"".random_date('2000-01-01', '2016-12-31')."\",";
					break;
					case 'houDate':
						$sintaxis .= "\"".random_hour('00:00:00','24:60:60')."\",";
					break;
						
					case 'tipoal':
						$res = $ttal[mt_rand(0, ($tipo[0]['ta']-1))]['tipoAl'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'profr':
						$res = $tprof[mt_rand(0, ($prof[0]['prf']-1))]['nomProf'];
						$sintaxis .= "\"".$res."\",";
					break;
					case 'mat':
						$res = $tmat[mt_rand(0, ($materia[0]['mate']-1))]['nomMat'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'trabEsc':
						$res = $ttrab[mt_rand(0, ($trabajo[0]['trab']-1))]['nomTra'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'groupEsc':
						$res = $tgrup[mt_rand(0, ($grupo[0]['grup']-1))]['nomGrup'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'perEsc':
						$res = $tper[mt_rand(0, ($periodo[0]['per']-1))]['nomPer'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'parcEsc':
						$res = $tpar[mt_rand(0, ($parcial[0]['par']-1))]['nomPar'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'clf':
						$res = $tcalif[mt_rand(0, ($calif[0]['cal']-1))]['nomCal'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'escEsc':
						$res = $tesc[mt_rand(0, ($escuela[0]['esc']-1))]['nomEsc'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'asis':
						$res = $tasis[mt_rand(0, ($asitencia[0]['asis']-1))]['nomAsist'];
						$sintaxis .= "\"".$res."\",";
					break;	
					case 'salonEsc':
						$res = $tsal[mt_rand(0, ($salon[0]['sal']-1))]['nomSal'];
						$sintaxis .= "\"".$res."\",";
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