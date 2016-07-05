<?php
	include "data/session/session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>PayPub</title>
	<meta name="description" content="Bootstrap Metro Inicio">
	<meta name="author" content="Geodathor">
	<meta name="keyword" content="Pagos, Pub, Carrete, Party, Pay, WebPay,Transefer">
	<!-- end: Meta -->

	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->

	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<style type="text/css">
		.loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url('img/preloader.gif') 50% 50% no-repeat rgb(249,249,249);
		}
	</style>
	<!-- end: CSS -->


	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->

	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->

	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
</head>

<body>
	<div class="loader"></div>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="panel.php"><span>PAYPUB</span></a>

				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="halflings-icon white user"></i> <?php echo $_SESSION["normandia"]; ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li class="dropdown-menu-title">
 									<span>Account Settings</span>
								</li>
								<li><a href="#"><i class="halflings-icon user"></i> Profile</a></li>
								<li><a href="#" id="logout"><i class="halflings-icon off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->

			</div>
		</div>
	</div>
	<!-- start: Header -->

		<div class="container-fluid-full">
		<div class="row-fluid">

			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="panel.php"><i class="icon-home"></i><span class="hidden-tablet"> Inicio</span></a></li>
						<li><a href="clientes.php"><i class="icon-group"></i><span class="hidden-tablet"> Clientes</span></a></li>
						<li><a href="marketing.php"><i class="icon-gift"></i><span class="hidden-tablet"> Campañas</span></a></li>
						<li><a href="transacciones.php"><i class="icon-money"></i><span class="hidden-tablet"> Transacciones</span></a></li>
						<li><a href="graficos.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Graficos</span></a></li>
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->

			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>

			<!-- start: Content -->
			<div id="content" class="span10">


			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="panel.php">Inicio</a>
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Clientes</a></li>
			</ul>
			<!--	contenido-->
      <?php
        $idLo = $_SESSION["italia"];
        include "data/engine.php";
        $objeto = new Saldo;
				$objCl 	= new Cliente;
        $tarea  = $objeto->clientesPorLocal($idLo);
        if($tarea!=="none"){
				echo '<div class="row-fluid">
									<div class="box span12">
										<div class="box-header">
											<h2><i class="icon-group"></i><span class="break"></span>Sus Clientes</h2>
										</div>
										<div class="box-content">
											<table class="table table-bordered table-striped table-condensed">
													<thead>
														<tr>
															<th>Cliente</th>
															<th>Rut</th>
															<th>Edad</th>
															<th>Ciudad</th>
															<th>Comuna</th>
															<th>Correo</th>
															<th>Saldo</th>
														</tr>
													</thead>
													<tbody>';
          for($i=0;$i<count($tarea);$i++){
						$idCl 	= $tarea[$i]["ID_CLIENTE"];
						$getData= $objCl->mostrarClientePorId($idCl);
						if($getData!=="none"){
							$nombre = $getData["NOMBRE_CLIENTE"]." ".$getData["APELLIDO_CLIENTE"];
							$rutCl 	= $getData["RUT_CLIENTE"];
	            $date1 	= $getData["FECHANAC_CLIENTE"];
							$ts1 		= $date1;
							$ts2 		= date('Y-m-d');
							$seconds_diff = $ts2 - $ts1;
	            $ciudad = $getData["CIUDAD_CLIENTE"];
	            $comuna = $getData["COMUNA_CLIENTE"];
	            $correo = $getData["CORRE_CLIENTE"];
							$getSal = $objeto->chequearSaldoVinculado($idLo,$idCl);
							echo '<tr><td>'.$nombre.'</td><td class="center">'.$rutCl.'</td><td class="center">'.$seconds_diff.'</td><td class="center">'.$ciudad.'</td><td class="center">'.$comuna.'</td><td class="center">'.$correo.'</td><td class="center">'.$getSal.'</td></tr>';
						}
          }
					echo 			'</tbody>
									 </table>
								</div>
							</div><!--/span-->
						</div>';
        }else{
          echo "<p>Sin Clientes Asignados</p>";
        }
      ?>
	</div><!--/.fluid-container-->

			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->

	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>

	<div class="clearfix"></div>

	<footer>

		<p>
			<span style="text-align:left;float:left">&copy;PayPub 2015 <a href="#" alt="PayPub">Best FinTech Award 2015</a></span>

		</p>

	</footer>

	<!-- start: JavaScript-->

		<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>

		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>

		<script src="js/jquery.ui.touch-punch.js"></script>

		<script src="js/modernizr.js"></script>

		<script src="js/bootstrap.min.js"></script>

		<script src="js/jquery.cookie.js"></script>

		<script src='js/fullcalendar.min.js'></script>

		<script src='js/jquery.dataTables.min.js'></script>

		<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.js"></script>
	<script src="js/jquery.flot.pie.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>

		<script src="js/jquery.chosen.min.js"></script>

		<script src="js/jquery.uniform.min.js"></script>

		<script src="js/jquery.cleditor.min.js"></script>

		<script src="js/jquery.noty.js"></script>

		<script src="js/jquery.elfinder.min.js"></script>

		<script src="js/jquery.raty.min.js"></script>

		<script src="js/jquery.iphone.toggle.js"></script>

		<script src="js/jquery.uploadify-3.1.min.js"></script>

		<script src="js/jquery.gritter.min.js"></script>

		<script src="js/jquery.imagesloaded.js"></script>

		<script src="js/jquery.masonry.min.js"></script>

		<script src="js/jquery.knob.modified.js"></script>

		<script src="js/jquery.sparkline.min.js"></script>

		<script src="js/counter.js"></script>

		<script src="js/retina.js"></script>

		<script src="js/custom.js"></script>
		<script>
		$("#logout").click(function(){
			window.localStorage.clear();
      window.location.href = 'data/session/salir.php';
		});
		</script>
		<script type="text/javascript">
    $(window).load(function() {
      $(".loader").fadeOut("slow");
    })
    </script>
    <script type="text/javascript">
    $('#formu').submit(function() {
      $(".loader").fadeIn("slow");
    });
    </script>
	<!-- end: JavaScript-->

</body>
</html>
