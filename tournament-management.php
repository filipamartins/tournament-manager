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
						<li><a href="tournament-management.php"><strong style="color:#5c3ab7;">Gestão de Torneios</a></strong></li>
						<li><a href="field-management.php"><strong>Gestão de Campos</a></strong></li>
						<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
		
				<table style="width:100%">
				<h3>Gestão de Torneios</h3>
				<tr style="background: #afd2f0;">
					<th>Torneio</th>
					<th> </th>
					<th> </th>
					<th> </th>
				</tr>
				<?php
					require_once "connect.php";
					mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings
				
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
					if ($connection->connect_errno != 0){
						throw new Exception(mysqli_connect_errno());
					} else{
						//echo "connected successfully";
						$result = $connection->query("SELECT * FROM futebolamador.torneios;");
					
						while($row = mysqli_fetch_array($result)){
							echo "<tr>";
							echo "<td>" . $row['Nome_torneio'] . "</td>";
							echo "<td><a href=\"tournament-detail.php?tname=".$row['Nome_torneio']."\" style=\"color:#5c3ab7;\">ver detalhes</a></td>";
							
							$query = sprintf("  SELECT count(*) FROM futebolamador.equipas 
												WHERE equipas.Nome_torneio = \"%s\";", $row['Nome_torneio'] );
						
							$count = $connection->query($query);
							$row2 = mysqli_fetch_array($count);
						
							if($row2[0] >= 2){
								echo "<td style = \"color: rgb(0,200,0);\">Pronto a iniciar</td>";
							}else{
								echo "<td style = \"color: rgb(200,0,0);\">Não Pronto</td>";
							}
							echo "<td><a href=\"tournament-detail.php?tname=".$row['Nome_torneio']."\" style=\"color:#5c3ab7;\">Gerir Torneio</a></td>";
							echo "</tr>";
						}
						$connection->close();
					}
				?>
				</table> 
				
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