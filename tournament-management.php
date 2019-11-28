<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">


<?php
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings

	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0){
		throw new Exception(mysqli_connect_errno());
	} else{
		//echo "connected successfully";
		$tournaments = $connection->query("SELECT * FROM futebolamador.torneios;");
	}


	function getNumberGames($tname){
		global $connection;
		$query = sprintf("  SELECT count(*) FROM futebolamador.jogos 
							WHERE jogos.Nome_torneio = \"%s\";", $tname );

		$result = $connection->query($query);
		$number_games = mysqli_fetch_array($result);
		return $number_games;
	}

	function getTournamentState($tname){
		global $connection;
		$ready = false;

		$query = sprintf("  SELECT count(*), equipas.estado FROM futebolamador.equipas 
							WHERE equipas.Nome_torneio = \"%s\"
							GROUP BY equipas.estado;", $tname );

		$result = $connection->query($query);
		
		while($row = mysqli_fetch_array($result)){
			if($row[0] >= 2 and $row[1] == 1)
				$ready = true;
		}
		$number_games = getNumberGames($tname);
		if($ready and $number_games[0] != 0 ){
			return 2; //A decorrer
		}
		else if($ready){
			return 1; //Pronto a iniciar
		}
		else{
			return 0; //Não pronto
		}
	}
?>

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
								
							<img src="images/user.png" onerror = "this.src= 'images/foto.jpg';" style="width:auto;height:50px; border-radius:50%">
						    <br><a>Filipa Martins</a>
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
				<img src="images/tournament4.jpg" onerror = "this.src= 'images/tournament11.jpg';" style="max-width:100%;">
				<table style="width:100%">
				<h2>Gestão de Torneios</h2>
				<tr style="background: #afd2f0;">
					<th>Torneio</th>
					<th> </th>
					
					<th> </th>
				</tr>
				<?php

					while($tournament = mysqli_fetch_array($tournaments)){
						echo "<tr>";
						echo "<td>" . $tournament['Nome_torneio'] . "</td>";
						
						$state = getTournamentState($tournament['Nome_torneio']);
						if($state == 2){
							echo "<td style = \"color: rgb(250,150,0);\">A decorrer</td>";
						}
						else if($state == 1){
							echo "<td style = \"color: rgb(0,200,0);\">Pronto a iniciar</td>";
						}else{
							echo "<td style = \"color: rgb(200,0,0);\">Não Pronto</td>";
						}
						echo "<td><a href=\"tournament-management2.php?tname=".$tournament['Nome_torneio']."\" style=\"color:#5c3ab7;\">Gerir Torneio</a></td>";
						echo "</tr>";
					}
					$connection->close();
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