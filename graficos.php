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
				<li><a href="#">Graficos</a></li>
			</ul>
			<!--	contenido-->
			<input type="hidden" id="token" name="Lorem" value="<?php echo $_SESSION['italia'];?>">
			<div class="row-fluid">
				<div class="row-fluid">

					<div class="widget span6" onTablet="span6" onDesktop="span6">
						<div class="content">
							<div id="facebookChart" style="height:300px" ></div>
						</div>
					</div><!--/span-->

					<div class="widget span6" onTablet="span6" onDesktop="span6">
						<div class="content">
							<div id="twitterChart" style="height:300px" ></div>
						</div>
					</div><!--/span-->

				</div>
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon list-alt"></i><span class="break"></span>Porcentaje de edades</h2>
					</div>
					<div class="box-content">
							<div id="piechart" style="height:300px"></div>
					</div>
				</div>

				<!--GENEROS PENDIENTE
				<div class="box span6">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon list-alt"></i><span class="break"></span>Donut</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						 <div id="donutchart" style="height: 300px;"></div>
					</div>
				</div>-->

			</div><!--/row-->


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

		$(document).ready(function(){
			var code = $("#token").val();
			var come = [];
			$.ajax({
					url: 'data/middle.php',
					type: 'POST',
					data: {
							'token': code,
							'hdnOperation': "hdnLoDXCWeb"
					},
					dataType: 'json',
					success: function (data) {
							if(data.length>=1){
								for (var i = data.length - 1; i >= 0; i--) {
									come[i] = [data[i]['Day'],data[i]['Monto']];
								}
							}

						graficoCobro(come);
					}
				});
		});

		function graficoCobro(cometa){

			if($("#facebookChart").length)
			{
				var likes = cometa;
				console.log(likes);
				var plot = $.plot($("#facebookChart"),
						 [ { data: likes, label: "Montos Cobrados en el Mes"} ], {
							 series: {
								 lines: { show: true,
										lineWidth: 2,
										fill: true, fillColor: { colors: [ { opacity: 0.5 }, { opacity: 0.2 } ] }
									 },
								 points: { show: true,
										 lineWidth: 2
									 },
								 shadowSize: 0
							 },
							 grid: { hoverable: true,
									 clickable: true,
									 tickColor: "#f9f9f9",
									 borderWidth: 0
								 },
							 colors: ["#3B5998"],
							xaxis: {ticks:6, tickDecimals: 0},
							yaxis: {ticks:3, tickDecimals: 0},
						 });

				function showTooltip(x, y, contents) {
					$('<div id="tooltip">' + contents + '</div>').css( {
						position: 'absolute',
						display: 'none',
						top: y + 5,
						left: x + 5,
						border: '1px solid #fdd',
						padding: '2px',
						'background-color': '#dfeffc',
						opacity: 0.80
					}).appendTo("body").fadeIn(200);
				}

				var previousPoint = null;
				$("#facebookChart").bind("plothover", function (event, pos, item) {
					$("#x").text(pos.x.toFixed(2));
					$("#y").text(pos.y.toFixed(2));

						if (item) {
							if (previousPoint != item.dataIndex) {
								previousPoint = item.dataIndex;

								$("#tooltip").remove();
								var x = item.datapoint[0].toFixed(2),
									y = item.datapoint[1].toFixed(2);

								showTooltip(item.pageX, item.pageY,
											item.series.label + " of " + x + " = " + y);
							}
						}
						else {
							$("#tooltip").remove();
							previousPoint = null;
						}
				});

			}
		}

		$(document).ready(function(){
			var code = $("#token").val();
			var come = [];
			$.ajax({
					url: 'data/middle.php',
					type: 'POST',
					data: {
							'token': code,
							'hdnOperation': "hdnLoDXcaWeb"
					},
					dataType: 'json',
					success: function (data) {
							if(data.length>=1){
								for (var i = data.length - 1; i >= 0; i--) {
									come[i] = [data[i]['Day'],data[i]['Monto']];
								}
							}
						graficoCarga(come);
					}
				});
		});

		function graficoCarga(cometa){
			if($("#twitterChart").length)
			{
				var followers = cometa;
				var plot = $.plot($("#twitterChart"),
					   [ { data: followers, label: "Montos Cargados en el Mes"} ], {
						   series: {
							   lines: { show: true,
										lineWidth: 2,
										fill: true, fillColor: { colors: [ { opacity: 0.5 }, { opacity: 0.2 } ] }
									 },
							   points: { show: true,
										 lineWidth: 2
									 },
							   shadowSize: 0
						   },
						   grid: { hoverable: true,
								   clickable: true,
								   tickColor: "#f9f9f9",
								   borderWidth: 0
								 },
						   colors: ["#1BB2E9"],
							xaxis: {ticks:6, tickDecimals: 0},
							yaxis: {ticks:3, tickDecimals: 0},
						 });

				function showTooltip(x, y, contents) {
					$('<div id="tooltip">' + contents + '</div>').css( {
						position: 'absolute',
						display: 'none',
						top: y + 5,
						left: x + 5,
						border: '1px solid #fdd',
						padding: '2px',
						'background-color': '#dfeffc',
						opacity: 0.80
					}).appendTo("body").fadeIn(200);
				}

				var previousPoint = null;
				$("#twitterChart").bind("plothover", function (event, pos, item) {
					$("#x").text(pos.x.toFixed(2));
					$("#y").text(pos.y.toFixed(2));

						if (item) {
							if (previousPoint != item.dataIndex) {
								previousPoint = item.dataIndex;

								$("#tooltip").remove();
								var x = item.datapoint[0].toFixed(2),
									y = item.datapoint[1].toFixed(2);

								showTooltip(item.pageX, item.pageY,
											item.series.label + " of " + x + " = " + y);
							}
						}
						else {
							$("#tooltip").remove();
							previousPoint = null;
						}
				});

			}
		}

		/* ---------- Pie chart ---------- */
		$(document).ready(function(){
			var code = $("#token").val();
			var come = [];
			var bata = [{ label: "Sin Clientes",  data: 100}];
			$.ajax({
					url: 'data/middle.php',
					type: 'POST',
					data: {
							'token': code,
							'hdnOperation': "hdnClporLo"
					},
					dataType: 'json',
					success: function (data) {
							if(data.length>=1){
								for (var i = 0; i < data.length; i++) {
									come[i] = {label: data[i]['Age'],data: data[i]['Cantidad']};
								}
								graficoEdad(come);
							}else{
								graficoEdad(bata);
							}
					}
				});
		});

		function graficoEdad(data){
			if($("#piechart").length)
			{
				$.plot($("#piechart"), data,
				{
					series: {
							pie: {
									show: true
							}
					},
					grid: {
							hoverable: true,
							clickable: true
					},
					legend: {
						show: false
					},
					colors: ["#FA5833", "#2FABE9", "#FABB3D", "#78CD51"]
				});

				function pieHover(event, pos, obj)
				{
					if (!obj)
							return;
					percent = parseFloat(obj.series.percent).toFixed(2);
					$("#hover").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
				}
				$("#piechart").bind("plothover", pieHover);
			}
		}
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
