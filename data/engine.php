<?php
Class Cliente
{
	var $id;
	var $rut;
	var $nombre;
	var $apellido;
	var $fechaNac;
	var $direccion;
	var $comuna;
	var $ciudad;
	var $fono;
	var $correo;
	var $pass;
	var $query;
	var $go;
	var $results;
	var $contador;

	function nuevoCliente($rut,$nombre,$apellido,$fechaNac,$direccion,$comuna,$ciudad,$fono,$correo,$pass){
		$this->rut 			= $rut;
		$this->nombre 		= $nombre;
		$this->apellido 	= $apellido;
		$this->fechaNac 	= $fechaNac;
		$this->direccion	= $direccion;
		$this->comuna		= $comuna;
		$this->ciudad 		= $ciudad;
		$this->fono 		= $fono;
		$this->correo 		= $correo;
		$this->pass 		= md5($pass);

		$this->query 		= 'INSERT INTO `CLIENTE`(`RUT_CLIENTE`, `NOMBRE_CLIENTE`, `APELLIDO_CLIENTE`, `FECHANAC_CLIENTE`, `DIRECCION_CLIENTE`, `COMUNA_CLIENTE`, `CIUDAD_CLIENTE`, `FONO_CLIENTE`, `CORRE_CLIENTE`, `PASS_CLIENTE`) VALUES ("'.$this->rut.'","'.$this->nombre.'","'.$this->apellido.'","'.$this->fechaNac.'","'.$this->direccion.'","'.$this->comuna.'","'.$this->ciudad.'","'.$this->fono.'","'.$this->correo.'","'.$this->pass.'")';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function modificarCliente($id,$rut,$nombre,$apellido,$fechaNac,$direccion,$comuna,$ciudad,$fono,$correo,$pass){
		$this->id 				= $id;
		$this->rut 				= $rut;
		$this->nombre 		= $nombre;
		$this->apellido 	= $apellido;
		$this->fechaNac 	= $fechaNac;
		$this->direccion	= $direccion;
		$this->comuna			= $comuna;
		$this->ciudad 		= $ciudad;
		$this->fono 			= $fono;
		$this->correo 		= $correo;
		$this->pass 			= md5($pass);

		$this->query 		= 'UPDATE `CLIENTE` SET `RUT_CLIENTE`="'.$this->rut .'",`NOMBRE_CLIENTE`="'.$this->nombre.'",`APELLIDO_CLIENTE`="'.$this->apellido.'",`FECHANAC_CLIENTE`="'.$this->fechaNac.'",`DIRECCION_CLIENTE`="'.$this->direccion.'",`COMUNA_CLIENTE`="'.$this->comuna.'",`CIUDAD_CLIENTE`="'.$this->ciudad.'",`FONO_CLIENTE`="'.$this->fono .'",`CORRE_CLIENTE`="'.$this->correo.'",`PASS_CLIENTE`="'.$this->pass.'" WHERE `ID_CLIENTE`="'.$this->id.'"';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function borrarCliente($id){
		$this->id 			= $id;
		$this->query 		= 'DELETE FROM `CLIENTE` WHERE `ID_CLIENTE`="'.$this->id.'"';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function loginCliente($correo,$password){
		$this->correo 	= $correo;
		$this->pass 	= md5($password);
		$this->query 	= 'SELECT `ID_CLIENTE`, `RUT_CLIENTE`, `NOMBRE_CLIENTE`, `APELLIDO_CLIENTE`, `FECHANAC_CLIENTE`, `DIRECCION_CLIENTE`, `COMUNA_CLIENTE`, `CIUDAD_CLIENTE`, `FONO_CLIENTE`, `CORRE_CLIENTE` FROM `CLIENTE` WHERE  `CORRE_CLIENTE`="'.$this->correo.'" AND`PASS_CLIENTE`="'.$this->pass.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row;
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function mostrarClientePorId($id){
		$this->id 		= $id;
		$this->query 	= 'SELECT `ID_CLIENTE`, `RUT_CLIENTE`, `NOMBRE_CLIENTE`, `APELLIDO_CLIENTE`, `FECHANAC_CLIENTE`, `DIRECCION_CLIENTE`, `COMUNA_CLIENTE`, `CIUDAD_CLIENTE`, `FONO_CLIENTE`, `CORRE_CLIENTE` FROM `CLIENTE` WHERE `ID_CLIENTE`="'.$this->id.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row;
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);

	}

	function mostrarClientePorRut($rut){
		$this->rut 		= $rut;
		$this->query 	= 'SELECT `ID_CLIENTE`, `RUT_CLIENTE`, `NOMBRE_CLIENTE`, `APELLIDO_CLIENTE`, `FECHANAC_CLIENTE`, `DIRECCION_CLIENTE`, `COMUNA_CLIENTE`, `CIUDAD_CLIENTE`, `FONO_CLIENTE`, `CORRE_CLIENTE` FROM `CLIENTE` WHERE `RUT_CLIENTE`="'.$this->rut.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row;
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);

	}

	function mostrarTodos(){
		$this->contador = 0;
		$this->query 	= 'SELECT `ID_CLIENTE`, `RUT_CLIENTE`, `NOMBRE_CLIENTE`, `APELLIDO_CLIENTE`, `FECHANAC_CLIENTE`, `DIRECCION_CLIENTE`, `COMUNA_CLIENTE`, `CIUDAD_CLIENTE`, `FONO_CLIENTE`, `CORRE_CLIENTE` FROM `CLIENTE`';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function mostrarPorComuna($comuna){
		$this->comuna 	= $comuna;
		$this->contador = 0;
		$this->query 	= 'SELECT `ID_CLIENTE`, `RUT_CLIENTE`, `NOMBRE_CLIENTE`, `APELLIDO_CLIENTE`, `FECHANAC_CLIENTE`, `DIRECCION_CLIENTE`, `COMUNA_CLIENTE`, `CIUDAD_CLIENTE`, `FONO_CLIENTE`, `CORRE_CLIENTE` FROM `CLIENTE` WHERE `COMUNA_CLIENTE` = "'.$this->comuna.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}
}
Class Local
{
	var $id;
	var $nomEncargado;
	var $apeEncargado;
	var $nombreLocal;
	var $fono;
	var $direccion;
	var $comuna;
	var $ciudad;
	var $rut;
	var $giro;
	var $correo;
	var $usuario;
	var $password;
	var $query;
	var $go;
	var $results;
	var $contador;

	function nuevoLocal($nomEncargado,$apeEncargado,$nombreLocal,$fono,$direccion,$comuna,$ciudad,$rut,$giro,$correo,$usuario,$password){
		$this->nomEncargado 	= $nomEncargado;
		$this->apeEncargado		= $apeEncargado;
		$this->nombreLocal		= $nombreLocal;
		$this->fono 			= $fono;
		$this->direccion 		= $direccion;
		$this->comuna 			= $comuna;
		$this->ciudad 			= $ciudad;
		$this->rut 				= $rut;
		$this->correo 			= $correo;
		$this->usuario 			= $usuario;
		$this->password 		= md5($password);
		$this->giro 			= $giro;

		$this->query 			= 'INSERT INTO `LOCAL`(`NOM_ENCARGADO_LOCAL`, `APE_ENCARGADO_LOCAL`, `NOMBRE_LOCAL`, `FONO_LOCAL`, `DIRECCION_LOCAL`, `COMUNA_LOCAL`, `CIUDAD_LOCAL`, `RUT_LOCAL`, `CORREO_LOCAL`, `USUARIO_LOCAL`, `PASS_LOCAL`, `GIRO_LOCAL`) VALUES ("'.$this->nomEncargado.'","'.$this->apeEncargado.'","'.$this->nombreLocal.'","'.$this->fono.'","'.$this->direccion.'","'.$this->comuna.'","'.$this->ciudad.'","'.$this->rut.'","'.$this->correo.'","'.$this->usuario.'","'.$this->password.'","'.$this->giro.'")';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);

	}

	function modificarLocal($id,$nomEncargado,$apeEncargado,$nombreLocal,$fono,$direccion,$comuna,$ciudad,$rut,$giro,$correo,$usuario,$password){
		$this->id 				= $id;
		$this->nomEncargado 	= $nomEncargado;
		$this->apeEncargado		= $apeEncargado;
		$this->nombreLocal		= $nombreLocal;
		$this->fono 			= $fono;
		$this->direccion 		= $direccion;
		$this->comuna 			= $comuna;
		$this->ciudad 			= $ciudad;
		$this->rut 				= $rut;
		$this->giro 			= $giro;
		$this->correo 			= $correo;
		$this->usuario 			= $usuario;
		$this->password 		= md5($password);

		$this->query 		= 'UPDATE `LOCAL` SET `NOM_ENCARGADO_LOCAL`="'.$this->nomEncargado.'",`APE_ENCARGADO_LOCAL`="'.$this->apeEncargado.'",`NOMBRE_LOCAL`="'.$this->nombreLocal.'",`FONO_LOCAL`="'.$this->fono.'",`DIRECCION_LOCAL`="'.$this->direccion.'",`COMUNA_LOCAL`="'.$this->comuna.'",`CIUDAD_LOCAL`="'.$this->ciudad.'",`RUT_LOCAL`="'.$this->rut.'",`CORREO_LOCAL`="'.$this->correo.'",`USUARIO_LOCAL`="'.$this->usuario.'",`PASS_LOCAL`="'.$this->password.'",`GIRO_LOCAL`="'.$this->giro.'" WHERE `ID_LOCAL`="'.$this->id.'"';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function borrarLocal($id){
		$this->id 			= $id;
		$this->query 		= 'DELETE FROM `LOCAL` WHERE `ID_LOCAL`="'.$this->id.'"';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function loginLocal($usuario,$password){
		$this->usuario 		= $usuario;
		$this->password 	= md5($password);
		$this->query 	= 'SELECT `ID_LOCAL`, `NOM_ENCARGADO_LOCAL`, `APE_ENCARGADO_LOCAL`, `NOMBRE_LOCAL`, `FONO_LOCAL`, `DIRECCION_LOCAL`, `COMUNA_LOCAL`, `CIUDAD_LOCAL`, `RUT_LOCAL`, `CORREO_LOCAL`, `USUARIO_LOCAL`, `PASS_LOCAL`, `GIRO_LOCAL` FROM `LOCAL` WHERE `USUARIO_LOCAL`="'.$this->usuario.'" AND `PASS_LOCAL`="'.$this->password.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row;
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function mostrarLocalPorId($id){
		$this->id 		= $id;
		$this->query 	= 'SELECT `ID_LOCAL`, `NOM_ENCARGADO_LOCAL`, `APE_ENCARGADO_LOCAL`, `NOMBRE_LOCAL`, `FONO_LOCAL`, `DIRECCION_LOCAL`, `COMUNA_LOCAL`, `CIUDAD_LOCAL`, `RUT_LOCAL`, `CORREO_LOCAL`, `USUARIO_LOCAL`, `PASS_LOCAL`, `GIRO_LOCAL` FROM `LOCAL` WHERE `ID_LOCAL`="'.$this->id.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row;
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);

	}

	function mostrarLocalPorRut($rut){
		$this->rut 		= $rut;
		$this->contador = 0;
		$this->query 	= 'SELECT `ID_LOCAL`, `NOM_ENCARGADO_LOCAL`, `APE_ENCARGADO_LOCAL`, `NOMBRE_LOCAL`, `FONO_LOCAL`, `DIRECCION_LOCAL`, `COMUNA_LOCAL`, `CIUDAD_LOCAL`, `RUT_LOCAL`, `CORREO_LOCAL`, `USUARIO_LOCAL`, `PASS_LOCAL`, `GIRO_LOCAL` FROM `LOCAL` WHERE `RUT_LOCAL`="'.$this->rut.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);

	}

	function mostrarTodos(){
		$this->contador = 0;
		$this->query 	= 'SELECT `ID_LOCAL`, `NOM_ENCARGADO_LOCAL`, `APE_ENCARGADO_LOCAL`, `NOMBRE_LOCAL`, `FONO_LOCAL`, `DIRECCION_LOCAL`, `COMUNA_LOCAL`, `CIUDAD_LOCAL`, `RUT_LOCAL`, `CORREO_LOCAL`, `USUARIO_LOCAL`, `PASS_LOCAL`, `GIRO_LOCAL` FROM `LOCAL`';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}
}
Class Transaccion
{
	var $codigo;
	var $idCl;
	var $idLo;
	var $fecha;
	var $monto;
	var $descripcion;
	var $estado;	// 0 = PENDIENTE; 1 = LISTO; 2 = CANCELADO POR EL CLIENTE; 3 = CANCELADO POR EL LOCAL PARA CANCELADO
	var $tipo; 		// 0 PARA SALDO 1 PARA COBRO
	var $query;
	var $go;
	var $results;
	var $contador;

	function nuevoResgistro($idCl,$idLo,$monto,$descripcion,$tipo,$estado){
		date_default_timezone_set("America/Santiago");
		$this->idCl 		= $idCl;
		$this->idLo 		= $idLo;
		$this->fecha 		= date('Y-m-d H:i:s');
		$this->monto 		= $monto;
		$this->descripcion	= $descripcion;
		$this->tipo			= $tipo;
		$this->estado		= $estado;
		$this->query 		= 'INSERT INTO `TRANSACCION`(`ID_CLIENTE`, `ID_LOCAL`, `FECHA_TRANSACCION`, `MONTO_TRANSACCION`, `DESCRIP_TRANSACCION`, `TIPO_TRANSACCION`, `ESTADO_TRANSACCION`) VALUES ("'.$this->idCl.'","'.$this->idLo.'","'.$this->fecha.'","'.$this->monto.'","'.$this->descripcion.'","'.$this->tipo.'","'.$this->estado.'")';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = mysqli_insert_id($connection);
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function pendienteCliente($idCl){
		$this->idCl 	= $idCl;
		$this->query 	='SELECT `CODIGO_TRANSACCION`, `ID_LOCAL`, `FECHA_TRANSACCION`, `MONTO_TRANSACCION`, `DESCRIP_TRANSACCION` FROM `TRANSACCION` WHERE `ID_CLIENTE`="'.$this->idCl.'" AND `ESTADO_TRANSACCION`=0';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row;
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function procesarTransaccion($codigo,$estado){
		$this->codigo 	= $codigo;
		$this->estado 	= $estado;
		$this->query 	='UPDATE `TRANSACCION` SET `ESTADO_TRANSACCION`="'.$this->estado.'"  WHERE `CODIGO_TRANSACCION`="'.$this->codigo.'"';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}
	function chequearTransaccion($codigo){
		$this->codigo 	= $codigo;
		$this->query 	='SELECT `ESTADO_TRANSACCION` FROM `TRANSACCION` WHERE `CODIGO_TRANSACCION`="'.$this->codigo.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row['ESTADO_TRANSACCION'];
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function historialTransaccionCl($idCl){
		$this->contador = 0;
		$this->idCl 	= $idCl;
		$this->query 	='SELECT `CODIGO_TRANSACCION`, `ID_LOCAL`, `FECHA_TRANSACCION`, `MONTO_TRANSACCION`, `DESCRIP_TRANSACCION`, `TIPO_TRANSACCION`, `ESTADO_TRANSACCION` FROM TRANSACCION WHERE `ID_CLIENTE`="'.$this->idCl.'" ORDER BY  `TRANSACCION`.`FECHA_TRANSACCION` DESC';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function historialTransaccionLo($idLo){
		$this->contador = 0;
		$this->idLo 	= $idLo;
		$this->query 	='SELECT `CODIGO_TRANSACCION`, `ID_CLIENTE`, `FECHA_TRANSACCION`, `MONTO_TRANSACCION`, `DESCRIP_TRANSACCION`, `TIPO_TRANSACCION`, `ESTADO_TRANSACCION` FROM TRANSACCION WHERE `ID_LOCAL`="'.$this->idLo.'" ORDER BY  `TRANSACCION`.`FECHA_TRANSACCION` DESC';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}
}
Class Saldo
{
	var $contador;
	var $id;
	var $idLo;
	var $idCl;
	var $monto;
	var $query;
	var $go;
	var $results;

	function vincularCuentas($idLo,$idCl,$monto){
		$this->idLo 	= $idLo;
		$this->idCl 	= $idCl;
		$this->monto 	= $monto;
		$this->query 	= 'INSERT INTO `SALDO`(`ID_CLIENTE`, `ID_LOCAL`, `MONTO_SALDO`) VALUES ("'.$this->idCl.'","'.$this->idLo.'","'.$this->monto.'")';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function actualizarSaldo($idLo,$idCl,$monto){
		$this->idLo 	= $idLo;
		$this->idCl 	= $idCl;
		$this->monto 	= $monto;
		$this->query 	= 'UPDATE `SALDO` SET `MONTO_SALDO`="'.$this->monto.'" WHERE `ID_CLIENTE`="'.$this->idCl.'" AND `ID_LOCAL`="'.$this->idLo.'"';
		require "connection/sqli.php";
		$this->go 		= mysqli_query($connection,$this->query);
		if($this->go)
			$this->results = true;
		else
			$this->results = false;
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function chequearSaldoVinculado($idLo,$idCl){
		$this->idLo 	= $idLo;
		$this->idCl 	= $idCl;
		$this->query 	= 'SELECT `MONTO_SALDO` FROM `SALDO` WHERE `ID_CLIENTE`="'.$this->idCl.'" AND `ID_LOCAL`="'.$this->idLo.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		if($row = mysqli_fetch_array($this->go)){
			$this->results = $row['MONTO_SALDO'];
		}
		else
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function saldosLocal($idLo){
		$this->idLo 	= $idLo;
		$this->contador = 0;
		$this->query 	= 'SELECT `ID_CLIENTE`, `MONTO_SALDO` FROM `SALDO` WHERE `ID_LOCAL`="'.$this->idLo.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function saldosCliente($idCl){
		$this->idCl 	= $idCl;
		$this->contador = 0;
		$this->query 	= 'SELECT `ID_LOCAL`, `MONTO_SALDO` FROM `SALDO` WHERE `ID_CLIENTE`="'.$this->idCl.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}

	function clientesPorLocal($idLo){
		$this->idLo 	= $idLo;
		$this->query 	= 'SELECT `ID_CLIENTE` FROM SALDO WHERE ID_LOCAL = "'.$this->idLo.'"';
		require "connection/sqli.php";
		$this->go = mysqli_query($connection,$this->query);
		while($row = mysqli_fetch_array($this->go)){
			$this->results[] = $row;
			$this->contador++;
		}
		if($this->contador==0)
			$this->results = 'none';
		return $this->results;
		if (gettype($this->go)==="object") mysqli_free_result($this->go);
		mysqli_close($connection);
	}
}
?>
