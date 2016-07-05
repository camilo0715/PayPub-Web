<?php
header('Access-Control-Allow-Origin: *');
$resultado = "";
if (isset($_GET['token']) && isset($_GET['hdnOperation'])) {
	switch ($_GET['hdnOperation']) {

		case 'hdnClRegistro':
			$rut 		= ($_GET['rut']);
			$nombre 	= ($_GET['nombre']);
			$apellido 	= ($_GET['apellido']);
			$fechaNac 	= date("Y-m-d", strtotime($_GET['fechaNac']));
			$direccion 	= ($_GET['direccion']);
			$comuna 	= ($_GET['comuna']);
			$ciudad 	= ($_GET['ciudad']);
			$fono 		= ($_GET['fono']);
			$correo 	= ($_GET['correo']);
			$pass 		= ($_GET['pass']);
			include("engine.php");
			$operation 	= New Cliente;
			$tarea 		= $operation->nuevoCliente($rut,$nombre,$apellido,$fechaNac,$direccion,$comuna,$ciudad,$fono,$correo,$pass);
			if($tarea!=false){
				$resultado = json_encode(array('Codigo'=>777,'Mensaje'=>'Registro Exitoso'));
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Registro Fallido'));
			}
			echo $resultado;
			break;

		case 'hdnLoRegistro':
			$rut 			= ($_GET['rut']);
			$giro 			= ($_GET['giro']);
			$nombreLocal 	= ($_GET['nombreLocal']);
			$nomEncargado 	= ($_GET['nombre']);
			$apeEncargado 	= ($_GET['apellido']);
			$direccion 		= ($_GET['direccion']);
			$comuna 		= ($_GET['comuna']);
			$ciudad 		= ($_GET['ciudad']);
			$fono 			= ($_GET['fono']);
			$correo 		= ($_GET['correo']);
			$usuario 		= ($_GET['usuario']);
			$password 		= ($_GET['pass']);
			include("engine.php");
			$operation 	= New Local;
			$tarea 		= $operation->nuevoLocal($nomEncargado,$apeEncargado,$nombreLocal,$fono,$direccion,$comuna,$ciudad,$rut,$giro,$correo,$usuario,$password);
			if($tarea!=false){
				$resultado = json_encode(array('Codigo'=>777,'Mensaje'=>'Registro de Local Exitoso'));
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Registro de Local Fallido'));
			}
			echo $resultado;
			break;

		case 'hdnClLogin':
			$correo 	= $_GET['correo'];
			$password 	= $_GET['pass'];
			include("engine.php");
			$operation 	= New Cliente;
			$tarea 		= $operation->loginCliente($correo,$password);
			if($tarea!='none'){
				$resultado = json_encode($tarea);
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Login Fallido'));
			}
			echo $resultado;
			break;

		case 'hdnLoLogin':
			$usuario 	= $_GET['usuario'];
			$password 	= $_GET['pass'];
			include("engine.php");
			$operation 	= New Local;
			$tarea 		= $operation->loginLocal($usuario,$password);
			if($tarea!=='none'){
				$resultado = json_encode($tarea);
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Login Fallido'));
			}
			echo $resultado;
			break;

		case 'hdnLoCarga':
			$monto 	= $_GET['monto'];
			$rut 	= $_GET['rut'];
			$idLo 	= $_GET['id'];
			include("engine.php");
			$objCl 	= new Cliente;
			$getRut = $objCl->mostrarClientePorRut($rut);
			if($getRut!=='none'){
				$idCl 		= $getRut['ID_CLIENTE'];
				$objSaldo 	= new Saldo;
				$getSaldo 	= $objSaldo->chequearSaldoVinculado($idLo,$idCl);
				if($getSaldo!=='none'){
					$saldo = $monto + $getSaldo;
					$tarea = $objSaldo->actualizarSaldo($idLo,$idCl,$saldo);
					if($tarea!==false){
						$resultado = json_encode(array('Codigo'=>777,'Mensaje'=>'Se han cargado: $'.$monto.' Exitosamente!'));
						$objTransa = new Transaccion;
						$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Carga de Saldo',0,1);
					}else{
						$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Carga Fallida'));
					}
				}else{
					$tarea = $objSaldo->vincularCuentas($idLo,$idCl,$monto);
					if($tarea!==false){
						$resultado = json_encode(array('Codigo'=>777,'Mensaje'=>'Se han cargado: $'.$monto.' Exitosamente!'));
						$objTransa = new Transaccion;
						$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Carga de Saldo',0,1);
					}else{
						$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Carga Fallida'));
					}
				}
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Rut no registrado en el sistema'));
			}
			echo $resultado;
			break;

		case 'hdnLoCobroCloud':
			$monto 	= $_GET['monto'];
			$rut 	= $_GET['rut'];
			$idLo 	= $_GET['id'];
			include("engine.php");
			$objCl 	= new Cliente;
			$getRut = $objCl->mostrarClientePorRut($rut);
			if($getRut!=='none'){
				$idCl 		= $getRut['ID_CLIENTE'];
				$objSaldo 	= new Saldo;
				$getSaldo 	= $objSaldo->chequearSaldoVinculado($idLo,$idCl);
				if($getSaldo!=='none'){
					if($monto<=$getSaldo){
						$objTransa = new Transaccion;
						$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Cobro por servicios',1,0);
						if($setTransa!==false){
							$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Esperando Cliente','Valor'=>$setTransa));
						}else{
							$resultado = json_encode(array('Codigo'=>208,'Mensaje'=>'Task Failure'));
						}
					}else{
						$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Saldo de Cliente insuficiente: '.$getSaldo.''));
					}
				}else{
					$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Cliente No registra saldo con nosotros'));
				}
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Rut no registrado en el sistema'));
			}
			echo $resultado;
			break;

		case 'hdnLoCobroPendiente':
			$idCl 	= $_GET['id'];
			include("engine.php");
			$objTr 		= new Transaccion;
			$getData 	= $objTr->pendienteCliente($idCl);
			if($getData!=='none'){
				$resultado = json_encode($getData);
			}else{
				$resultado = json_encode(array('Codigo'=>101,'Mensaje'=>'Sin cobros pendientes'));
			}
			echo $resultado;
			break;

		case 'hdnLoCobroProcesar':
			$codigo 	= $_GET['codigo'];
			$estado 	= $_GET['estado'];
			$idCl 		= $_GET['idCl'];
			$idLo 		= $_GET['idLo'];
			$monto 		= $_GET['monto'];
			include("engine.php");
			$objTr 		= new Transaccion;
			$getData 	= $objTr->procesarTransaccion($codigo,$estado);
			if($getData!==false){
				if($estado==1){
					$objSaldo 	= new Saldo;
					$getSaldo 	= $objSaldo->chequearSaldoVinculado($idLo,$idCl);
					if($getSaldo!=='none'){
						$saldo = $getSaldo - $monto;
						$tarea = $objSaldo->actualizarSaldo($idLo,$idCl,$saldo);
						if($tarea!==false){
							$resultado = json_encode(array('Codigo'=>777,'Mensaje'=>'Operation Completed Successfully!'));
						}else{
							$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Task Failure'));
						}
					}else{
						$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Task Failure'));
					}
				}else{
					$resultado = json_encode(array('Codigo'=>209,'Mensaje'=>'Pago interrumpido por el Cliente'));
				}
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Task Failure'));
			}
			echo $resultado;
			break;

		case 'hdnLoCobroCheck':
			$codigo = $_GET['codigo'];
			include("engine.php");
			$objTr 	= new Transaccion;
			$tarea 	= $objTr->chequearTransaccion($codigo);
			if($tarea!=='none'){
				$resultado = json_encode(array('Codigo'=>777,'Mensaje'=>'Task Completed','Valor'=>$tarea));
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Task Failure'));
			}
			echo $resultado;
			break;

		case 'hdnLoCobroCancel':
			$codigo = $_GET['codigo'];
			include("engine.php");
			$objTr 	= new Transaccion;
			$tarea 	= $objTr->procesarTransaccion($codigo,3);
			if($tarea!==false){
				$resultado = json_encode(array('Codigo'=>777,'Mensaje'=>'Task Completed'));
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Task Failure'));
			}
			echo $resultado;
			break;

		case 'hdnClSaldo':
			$idCl 		= $_GET['id'];
			$ar 		= "";
			include("engine.php");
			$objSaldo 	= new Saldo;
			$getData 	= $objSaldo->saldosCliente($idCl);
			if($getData!=='none'){
				for ($i=0; $i < count($getData); $i++) {
					$saldo 	= $getData[$i]['MONTO_SALDO'];
					$idLo 	= $getData[$i]['ID_LOCAL'];
					$objLo 	= new Local;
					$dataLo = $objLo->mostrarLocalPorId($idLo);
					$nomLo 	= $dataLo['NOMBRE_LOCAL'];
					$ar[] 	= array('Local'=>$nomLo,'Saldo'=>$saldo,'Valor'=>$idLo);
				}
				$resultado = json_encode($ar);
			}else{
				$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Saldos Vinculados'));
			}
			echo $resultado;
			break;

		case 'hdnCobroNFC':
			$monto 	= $_GET['monto'];
			$idCl 	= $_GET['idCl'];
			$idLo 	= $_GET['idLo'];
			include("engine.php");
			$objSaldo 	= new Saldo;
			$getSaldo 	= $objSaldo->chequearSaldoVinculado($idLo,$idCl);
			if($getSaldo!=='none'){
				if($monto<=$getSaldo){
					$saldos    = $getSaldo - $monto;
					$doTheRoll = $objSaldo->actualizarSaldo($idLo,$idCl,$saldos);
					$objTransa = new Transaccion;
					$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Cobro por servicios',1,1);
					if($setTransa!==false){
						$resultado = json_encode(array('Codigo'=>$setTransa,'Mensaje'=>'Cobro Completo','Valor'=>$monto));
					}else{
						$resultado = json_encode(array('Codigo'=>208,'Mensaje'=>'Task Failure'));
					}
				}else{
					$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Saldo de Cliente insuficiente: '.$getSaldo.''));
				}
			}else{
				$resultado = json_encode(array('Codigo'=>202,'Mensaje'=>'Cliente No registra saldo con nosotros'));
			}

			echo $resultado;
			break;

		case 'hdnClTransac':
			$idCl 		= $_GET['id'];
			$ar 		= "";
			include("engine.php");
			$objTransa = new Transaccion;
			$getData   = $objTransa->historialTransaccionCl($idCl);
			if ($getData!=='none') {
				for ($i=0; $i < count($getData) ; $i++) {
					$codigo = $getData[$i]['CODIGO_TRANSACCION'];
					$fecha  = $getData[$i]['FECHA_TRANSACCION'];
					$monto  = $getData[$i]['MONTO_TRANSACCION'];
					$desc   = $getData[$i]['DESCRIP_TRANSACCION'];
					$tipo 	= $getData[$i]['TIPO_TRANSACCION'];
					$idLo   = $getData[$i]['ID_LOCAL'];
					$objLo  = new Local;
					$getNom = $objLo->mostrarLocalPorId($idLo);
					if($getNom!=='none'){
						$nomLo 	= $getNom['NOMBRE_LOCAL'];
						$ar[] = (array('Codigo'=>$codigo,'Fecha'=>$fecha,'Monto'=>$monto,'Descripcion'=>$desc,'Tipo'=>$tipo,'Local'=>$nomLo));
					}else{
						$ar[] = (array('Codigo'=>$codigo,'Fecha'=>$fecha,'Monto'=>$monto,'Descripcion'=>$desc,'Tipo'=>$tipo,'Local'=>$idLo));
					}
				}
				$resultado = json_encode($ar);
			}else{
				$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Transacciones'));
			}
			echo $resultado;
			break;

			case 'hdnLoDXCWeb':
				$ar = "";
				$idLo 			= $_GET["token"];
				$contador 	= 0;
				$conta 			= 0;
				$daux       = 0;
				$maux       = 0;
				include("engine.php");
				$objTransa 	= new Transaccion;
				$getData   	= $objTransa->historialTransaccionLo($idLo);
				if ($getData!=='none') {
					for($i=0;$i<count($getData);$i++){
						$fecha  = $getData[$i]['FECHA_TRANSACCION'];
						$timestamp = strtotime($fecha);
						$date 	= date("d", $timestamp);
						$monto  = $getData[$i]['MONTO_TRANSACCION'];
						$tipo 	= $getData[$i]['TIPO_TRANSACCION'];
						if ($conta==0) {
							$daux = $date;
						}
						if($tipo==1){
							$ar[] = (array('Day'=>(int)$date,'Monto'=>$monto,'Valor'=>1));
							$contador++;
						}
					}
					if($contador!==0){
						$resultado = json_encode($ar);
					}else{
							$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Transacciones', 'Valor'=>0));
						}
				}else{
					$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Transacciones', 'Valor'=>0));
				}
				echo $resultado;
				break;

		case 'hdnLoDXcaWeb':
					$ar 		= "";
					$idLo 			= $_GET["token"];
					$contador 	= 0;
					$daux       = 0;
					$maux       = 0;
					include("engine.php");
					$objTransa 	= new Transaccion;
					$getData   	= $objTransa->historialTransaccionLo($idLo);
					if ($getData!=='none') {
						for($i=0;$i<count($getData);$i++){
							$fecha  = $getData[$i]['FECHA_TRANSACCION'];
							$timestamp = strtotime($fecha);
							$date 	= date("d", $timestamp);
							$monto  = $getData[$i]['MONTO_TRANSACCION'];
							$tipo 	= $getData[$i]['TIPO_TRANSACCION'];
							if ($contador==0) {
								$daux = $date;
							}
							if($tipo==0){
								$ar[] = (array('Day'=>(int)$date,'Monto'=>$monto,'Valor'=>1));
								$contador++;
							}
						}
						if($contador!==0){
							$resultado = json_encode($ar);
						}else{
								$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Transacciones', 'Valor'=>0));
							}
					}else{
						$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Transacciones', 'Valor'=>0));
					}
					echo $resultado;
					break;
			case 'hdnClporLo':
							$ar 		= "";
							$idLo 	= $_GET["token"];
							include "engine.php";
							$objeto = new Saldo;
							$objCl 	= new Cliente;
							$conta  = 0;
							$caux 	= 0;
							$cant   = 0;
							$oldata = 0;
			        $tarea  = $objeto->clientesPorLocal($idLo);
			        if($tarea!=="none"){
								for($i=0;$i<count($tarea);$i++){
									$idCl 	= $tarea[$i]["ID_CLIENTE"];
									$getData= $objCl->mostrarClientePorId($idCl);
									if($getData!=="none"){
				            $date1 	= $getData["FECHANAC_CLIENTE"];
										$ts1 		= $date1;
										$ts2 		= date('Y-m-d');
										$seconds_diff = $ts2 - $ts1;
										$cant++;
										if($caux!=$seconds_diff){
											$ar[] = (array('Age'=>$seconds_diff,'Cantidad'=>$cant,'Valor'=>1));
											$caux = $seconds_diff;
											$cant = 0;
										}
										$conta++;
									}
			          }
								if($conta!==0){
										$resultado = json_encode($ar);
								}else{
											$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Resultados', 'Valor'=>0));
								}
							}else {
								$resultado = json_encode(array('Codigo'=>192,'Mensaje'=>'Sin Resultados', 'Valor'=>0));
							}
							echo $resultado;
							break;
		default:
			$resultado = json_encode(array('Codigo'=>204,'Mensaje'=>'No existen peticiones'));
			echo $resultado;
			break;
	}
}else{
	$resultado = json_encode(array('Codigo'=>205,'Mensaje'=>'Ingreso no autorizado'));
	echo $resultado;
}
?>
