<?php
header('Access-Control-Allow-Origin: *');
$resultado = "";
if (isset($_POST['token']) && isset($_POST['hdnOperation'])) {
	switch ($_POST['hdnOperation']) {

		case 'hdnClRegistro':
			$rut 		= ($_POST['rut']);
			$nombre 	= ($_POST['nombre']);
			$apellido 	= ($_POST['apellido']);
			$fechaNac 	= date("Y-m-d", strtotime($_POST['fechaNac']));
			$direccion 	= ($_POST['direccion']);
			$comuna 	= ($_POST['comuna']);
			$ciudad 	= ($_POST['ciudad']);
			$fono 		= ($_POST['fono']);
			$correo 	= ($_POST['correo']);
			$pass 		= ($_POST['pass']);
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
			$rut 			= ($_POST['rut']);
			$giro 			= ($_POST['giro']);
			$nombreLocal 	= ($_POST['nombreLocal']);
			$nomEncargado 	= ($_POST['nombre']);
			$apeEncargado 	= ($_POST['apellido']);
			$direccion 		= ($_POST['direccion']);
			$comuna 		= ($_POST['comuna']);
			$ciudad 		= ($_POST['ciudad']);
			$fono 			= ($_POST['fono']);
			$correo 		= ($_POST['correo']);
			$usuario 		= ($_POST['usuario']);
			$password 		= ($_POST['pass']);
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
			$correo 	= $_POST['correo'];
			$password 	= $_POST['pass'];
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
			$usuario 	= $_POST['usuario'];
			$password 	= $_POST['pass'];
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

			case 'hdnLoLoginWeb':
				$usuario 	= $_POST['usuario'];
				$password 	= $_POST['pass'];
				include("engine.php");
				$operation 	= New Local;
				$tarea 		= $operation->loginLocal($usuario,$password);
				if($tarea!=='none'){
					if(!isset($_SESSION)){
						session_start();
					}
					$_SESSION["italia"] 		= $tarea["ID_LOCAL"];
					$_SESSION["normandia"] 	= $tarea["NOMBRE_LOCAL"];
					$_SESSION["rumania"] 		= $tarea["RUT_LOCAL"];
					$_SESSION["colombia"] 	= $tarea["COMUNA_LOCAL"];
					$_SESSION["antartica"] 	= "pinguinos";
					echo "<script>window.localStorage.removeItem('fail');</script>";
					echo "<script> window.location = '../panel.php';</script>";
					exit;
				}else{
					echo "<script> window.localStorage.setItem('fail', 'log'); window.location = '../index.html';</script>";
				}
				break;


		case 'hdnLoCarga':
			$monto 	= $_POST['monto'];
			$rut 		= $_POST['rut'];
			$idLo 	= $_POST['id'];
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

		case 'hdnLoCargaWEB':
				$monto 	= $_POST['monto'];
				$rut 		= $_POST['rut'];
				$idLo 	= $_POST['token'];
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
							$objTransa = new Transaccion;
							$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Carga de Saldo',0,1);
							echo "<script>alert('Se han cargado: $".$monto." Exitosamente!'); window.location.href='../panel.php'</script>";
						}else{
							echo "<script>alert('Algo ha salido mal!, Carga fallida'); window.location.href='../panel.php'</script>";
						}
					}else{
						$tarea = $objSaldo->vincularCuentas($idLo,$idCl,$monto);
						if($tarea!==false){
							$objTransa = new Transaccion;
							$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Carga de Saldo',0,1);
							echo "<script>alert('Se han cargado: $".$monto." Exitosamente!'); window.location.href='../panel.php'</script>";
						}else{
							echo "<script>alert('Algo ha salido mal!, Carga fallida'); window.location.href='../panel.php'</script>";
						}
					}
				}else{
					echo "<script>alert('Rut no registrado en el sistema!'); window.location.href='../panel.php'</script>";
				}
				break;

				case 'hdnCWCC':
						$monto 		= $_POST['monto'];
						$idLo 		= $_POST['token'];
						$comuna 	= $_POST['comuna'];
						$contador = 0;
						$vandador = 0;
						include("engine.php");
						$objCl 		= new Cliente;
						$getData	= $objCl->mostrarPorComuna($comuna);
						if($getData!=='none'){
							for($c=0; $c<count($getData); $c++){
								$idCl 			= $getData[$c]['ID_CLIENTE'];
								$objSaldo 	= new Saldo;
								$getSaldo 	= $objSaldo->chequearSaldoVinculado($idLo,$idCl);
								if($getSaldo!=='none'){
									$saldo = $monto + $getSaldo;
									$tarea = $objSaldo->actualizarSaldo($idLo,$idCl,$saldo);
									if($tarea!==false){
										$objTransa = new Transaccion;
										$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Carga de Saldo',0,1);
										$contador++;
									}else{
										$vandador++;
									}
								}else{
									$tarea = $objSaldo->vincularCuentas($idLo,$idCl,$monto);
									if($tarea!==false){
										$objTransa = new Transaccion;
										$setTransa = $objTransa->nuevoResgistro($idCl,$idLo,$monto,'Carga de Saldo',0,1);
										$contador++;
									}else{
										$vandador++;
									}
								}
							}
							if($contador>$vandador){
								echo "<script>alert('Se han cargado: $".$monto." Exitosamente a sus clientes!'); window.location.href='../panel.php'</script>";
							}else{
								echo "<script>alert('Lo Sentimos: La operacion no pudo se completada...'); window.location.href='../panel.php'</script>";
							}
						}else{
							echo "<script>alert('Lo Sentimos: No aun usuarios en su comuna...'); window.location.href='../panel.php'</script>";
						}
						break;

		case 'hdnLoCobroCloud':
			$monto 	= $_POST['monto'];
			$rut 	= $_POST['rut'];
			$idLo 	= $_POST['id'];
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

		case 'hdnLoCobroCloudWeb':
				$monto 	= $_POST['monto'];
				$rut 		= $_POST['rut'];
				$idLo 	= $_POST['token'];
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
								echo "<script>alert('Cobro Exitoso!, Para ver el resultado de la operación vaya a Transacciones'); window.location.href='../panel.php'</script>";
							}else{
								echo "<script>alert('Algo ha salido mal, intentelo nuevamente!'); window.location.href='../panel.php'</script>";
							}
						}else{
							echo "<script>alert('Saldo de Cliente insuficiente: ".$getSaldo."'); window.location.href='../panel.php'</script>";
						}
					}else{
						echo "<script>alert('Error: Cliente No registra saldo con este Local'); window.location.href='../panel.php'</script>";
					}
				}else{
					echo "<script>alert('Rut no registrado en el sistema!'); window.location.href='../panel.php'</script>";
				}
				break;

		case 'hdnLoCobroPendiente':
			$idCl 	= $_POST['id'];
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
			$codigo 	= $_POST['codigo'];
			$estado 	= $_POST['estado'];
			$idCl 		= $_POST['idCl'];
			$idLo 		= $_POST['idLo'];
			$monto 		= $_POST['monto'];
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
			$codigo = $_POST['codigo'];
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
			$codigo = $_POST['codigo'];
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
			$idCl 		= $_POST['id'];
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

		case 'hdnClTransac':
			$idCl 		= $_POST['id'];
			$ar 			= "";
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
			$ar		 			= "";
			$idLo 			= $_POST["token"];
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
					if($tipo!=0){
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
				$ar 				= "";
				$idLo 			= $_POST["token"];
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
						if($tipo!=1){
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
				$idLo 	= $_POST["token"];
				include "engine.php";
				$objeto = new Saldo;
				$objCl 	= new Cliente;
				$conta  = 0;
				$caux 	= 0;
				$cant   = 0;
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
