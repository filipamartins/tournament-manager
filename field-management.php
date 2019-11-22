<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Futebol Amador</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
		 <!--	<link rel="stylesheet" href="css/skel.css" /> -->
			<link rel="stylesheet" href="css/style.css"/>
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body>
		<!-- Header -->
		<header id="header">
			<h1><a href="index.html">Futebol Amador</a></h1>
			<nav id="nav">
				<ul>
					<li><a href="tournament.php">Torneios</a></li>
					<li><a href="#">Equipas</a></li>
					<li>
						<a href="#" class="icon rounded fa-bell"></a>
						<!--<button class="notification">
							<a class="icon rounded fa-bell">
							<img src="images/bell_notification.png" style="width:auto;height:25px;">
						</button>-->
					</li>
					<li>
						<div class="dropdown">
						    <button class="dropbtn">
								
						      <img src="images/foto.jpg" onerror = "this.src= 'images/user.png';" style="width:auto;height:50px; border-radius:50%">
						      <br><a>Inês Moreira</a>
						    </button>
						    <div class="dropdown-content">
						      <a href="#">Ver perfil</a>
						      <a href="#">Editar perfil</a>
						      <a href="#">Terminar sessão</a> 	
						    </div>
						</div>
					</li>
					
					<!-- <li><a href="help.html">Ajuda</a></li>-->
				</ul>
				
			</nav>

		</header>
		

		<!-- Colocar conteudo do ecra -->
		<div class="row">
			<div class="3u">
				<section class="sidebar">
					<ul class="default" style="padding-left: 40px;">
						<li><a href="tournament-create.php"><strong>Criar Novo Torneio</a></strong></li>
						<li><a href="tournament-management.php"><strong>Gestão de Torneios</a></strong></li>
						<li><a href="field-management.php"><strong style="color:#5c3ab7;">Gestão de Campos</a></strong></li>
						<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
				
				<img src="images/camp3.jpg" onerror = "this.src= 'images/camp1.jpg';" style="max-width:100%;">
				<h2>Campos de Futebol</h2>
				<table style="width:100%">
				<tr>
					<th>Nome</th>
					<th>Rua</th>
					<th>Numero</th>
					<th>Cidade</th>
					<th>Coordenadas</th>
					<th>Custo</th>
				</tr>
				<?php
					require_once "connect.php";
					mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings
				
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
					if ($connection->connect_errno != 0){
						throw new Exception(mysqli_connect_errno());
					} else{
						//echo "connected successfully";
						$query = "SELECT * FROM futebolamador.campos;";
						$result = $connection->query($query);
					
						while($row = mysqli_fetch_array($result)){
							echo "<tr>";
							echo "<td>" . $row['Nome_campo'] . "</td>";
							echo "<td>" . $row['Rua'] . "</td>";
							echo "<td>" . $row['Numero'] . "</td>";
							echo "<td>" . $row['Cidade'] . "</td>";
							echo "<td>" . $row['GPS'] . "</td>";
							echo "<td>" . $row['Custo'] . "</td>";
							echo "</tr>";
						}
						$connection->close();
					}
				?>
				</table> 
				
				<a href="field-create.php">
					<input type="button" value ="Adicionar Campo"> <br>
				</a><br>
			</div>
		</div>
	</body>

	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="8u 12u$(medium)">
					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li>
						<li>Design: <a href="http://templated.co">TEMPLATED</a></li>
						<li>Images: <a href="http://unsplash.com">Unsplash</a></li>
					</ul>
				</div>
				<div class="4u$ 12u$(medium)">
					<ul class="icons">
						<li>
							<a class="icon rounded fa-facebook"><span class="label">Facebook</span></a>
						</li>
						<li>
							<a class="icon rounded fa-twitter"><span class="label">Twitter</span></a>
						</li>
						<li>
							<a class="icon rounded fa-google-plus"><span class="label">Google+</span></a>
						</li>
						<li>
							<a class="icon rounded fa-linkedin"><span class="label">LinkedIn</span></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
</html>