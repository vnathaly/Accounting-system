<?php
session_start();
if (empty($_SESSION["ID"])) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/estilo.css">	
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="bd-example mb-0" style="height: 80vh">
		<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
				<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active" style="height: 80vh">
					<img src="img/1.jpg" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block">
						<h5 class="display-4 mb-4 font-weight-bold">Sistema de ContabilidadS</h5>
						<p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
					</div>
				</div>
				<div class="carousel-item" style="height: 80vh">
					<img src="img/1.jpg" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block">
						<h5 class="display-4 mb-4 font-weight-bold">Sistema Contable</h5>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					</div>
				</div>
				<div class="carousel-item" style="height: 80vh">
					<img src="img/1.jpg" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block">
						<h5 class="display-4 mb-4 font-weight-bold">Aquí tienes todo lo necesario</h5>
						<p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
					</div>
				</div>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
	<nav class="navbar navbar-dark bg-dark  navbar-expand-md navbar-light bg-light fixed-top">
		<div class="text-white bg-success p-2">
			<?php
       echo $_SESSION["nombre"]." ".$_SESSION["apellidos_usuarios"]; //preguntar a Crhistopher
			?>
		</div>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01"> 
    <div class="navbar-nav ml-auto">
        <div class="offset-md-1 text-center"></div>
				<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-justify ml-3" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Mantenimientos
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="http://127.0.0.1/Yovanny/mantenimientos/usuario/usuario.php" onclick="cargarMantenimiento('usuario')">Usuarios</a>
        <a class="dropdown-item" href="http://127.0.0.1/Yovanny/mantenimientos/catalogo/catalogo.php" onclick="cargarMantenimiento('catalogo')">Catálogo de cuenta</a>
        <a class="dropdown-item" href="http://127.0.0.1/Yovanny/mantenimientos/entrada_diario/entrada_diario.php" onclick="cargarMantenimiento('tipo_entrada')">Tipo Entrada de Diario</a>
    </div>
    </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-justify ml-3" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Consultas
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Catálogo de cuenta</a>
                <a class="dropdown-item" href="http://127.0.0.1/Yovanny/consultas/transacciones/transaccion.php">Transacciones</a>
                <!-- <a class="dropdown-item" href="servicios.html">Transacciones por rango de fechas</a> -->
                <a class="dropdown-item" href="servicios.html">Balanza General (Activos, pasivo y Capital)</a>
                <a class="dropdown-item" href="#">Balanza de Comprobación</a>
                <a class="dropdown-item" href="#">Resumen de Gastos Generales</a>
                <a class="dropdown-item" href="servicios.html">Estado de Ganancias y Pérdidas</a>
            </div>
        </li>
				<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-justify ml-3" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Procesos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="http://127.0.0.1/Yovanny/proceso/formulario_cierre.php">Cierre de Diario por fechas</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-justify ml-3" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Movimiento
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="http://127.0.0.1/Yovanny/movimiento/index.html"> Transacciones</a>
            </div>
        </li>
        <a class="nav-item nav-link text-justify ml-3 hover-primary" href="controlador_cerrar_seccion.php">Salir</a>
    </div>
		</div>
	</nav>	
	<div class="">
		<div class="jumbotron bg-dark text-light rounded-0">
			<h1 class="display-4">Hello, world!</h1>
			<p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
			<hr class="my-4 bg-light">
			<div class="d-flex justify-content-between align-items-center flex-wrap">
				<p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
			</div>
		</div>
	</div>
	</form>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis aperiam molestias, sint totam dolorum laudantium deleniti obcaecati minima odio provident, optio consectetur quas velit est amet a facere accusantium necessitatibus ea, officiis? Obcaecati harum eligendi incidunt ipsam alias maiores accusamus dicta quia velit molestias, placeat ullam vel corporis explicabo. Porro minus facere quos illum tenetur odit temporibus voluptate a perferendis magni dolorum laudantium molestiae veniam mollitia, illo harum unde, error repellat rem repellendus in, earum ipsum sequi! Explicabo delectus ipsum maxime id vitae, quod necessitatibus voluptates magnam blanditiis et rem enim at voluptatem quisquam inventore est, voluptate aut animi modi consectetur reiciendis molestias ullam repellat sapiente. Vel cupiditate ipsum delectus quod voluptatibus, consectetur omnis numquam ipsa tempora culpa eligendi officiis! Neque explicabo eos fugiat nisi, tenetur modi optio, dolore placeat molestias iste odit, velit rerum aperiam nihil laborum suscipit molestiae. Assumenda cumque, molestiae sed aliquid corrupti praesentium possimus soluta ex delectus est, debitis hic voluptatem natus labore nulla suscipit reprehenderit dignissimos ipsa quae doloribus eum, aperiam totam iure temporibus doloremque. Nesciunt quibusdam aut, vitae ipsam saepe deserunt eius amet alias natus facere asperiores laudantium, cumque temporibus sunt perferendis dolore ducimus velit soluta modi repellat autem eligendi omnis dolorem! Excepturi, iusto.</p>


	<script src="js/jquery-3.3.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>