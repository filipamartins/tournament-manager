<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">

<?php

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0){
		throw new Exception(mysqli_connect_errno());
	} else{
		$tournaments = $connection->query("SELECT * FROM futebolamador.torneios ORDER BY torneios.Nome_torneio;");
		//echo "connected successfully";
	}

	function tournamentState($tname){
		global $connection;
		$query = sprintf("  SELECT torneios.Estado FROM futebolamador.torneios 
							WHERE torneios.Nome_torneio = \"%s\";", $tname );

		$result = $connection->query($query);
		$ongoing = mysqli_fetch_array($result);
		return $ongoing;
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
		$ongoing = tournamentState($tname);
		if($ready and $ongoing[0] == 1 ){
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
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/style.css"/>
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body>
		<!-- Header -->
		<header id="header">
			<h1><a href="">Futebol Amador</a></h1>
			<nav id="nav">
				<ul>
					<li><a href="tournament.php">Torneios</a></li>
					<li><a href="#">Equipas</a></li>
					<li>
						<a href="#" class="icon rounded fa-bell"></a>
					</li>
					<li>
						<div class="dropdown">
						    <button class="dropbtn">
							  <img src="images/player.jpg" onerror = "this.src= 'images/usr.png';" style="width:auto;height:50px; border-radius:30%;">
						      <br><a>Filipa Martins</a>
						    </button>
						    <div class="dropdown-content">
							  <a href="user-profile.php">Ver perfil</a>
						      <a href="user-profile-edit.php">Editar perfil</a>
						      <a href="#">Terminar sessão</a> 	
						    </div>
						</div>
					</li>
				</ul>
			</nav>
		</header>
		
		<!-- Colocar conteudo do ecra -->
		<div class="row">
			<div class="3u">
				<section class="sidebar">
					<ul class="default" style="padding-left: 40px;">
						<li><a href="tournament-create.php"><strong>Criar Novo Torneio</a></strong></li>
						<li><a href="tournament-management.php"><strong >Gestão de Torneios</a></strong></li>
						<li><a href="field-management.php"><strong>Gestão de Campos</a></strong></li>
						<li><a href="tournament-list.php"><strong style="color:#5c3ab7;">Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
				<img src="images/list_t1.jpg" onerror = "this.src= 'images/list_t2.jpg';" style="max-width:100%;">
				<h2>Lista de Torneios</h2>

				<table style="width:100%">
				<tr style="background: #afd2f0;">
					<th>Torneio</th>
					<th>Nº de Equipas</th>
					<th>Estado</th>
					<th></th>			
				</tr>
				<?php
		
					while($tournament = mysqli_fetch_array($tournaments)){
						echo "<tr>";
						echo "<td>" . $tournament['Nome_torneio'] . "</td>";

						$query = sprintf("  SELECT count(*) FROM futebolamador.equipas 
											WHERE equipas.Nome_torneio = \"%s\";", $tournament['Nome_torneio'] );

						$result2 = $connection->query($query);
						$count = mysqli_fetch_array($result2);
						echo "<td>" . $count[0] . "</td>";
					
						$state = getTournamentState($tournament['Nome_torneio']);
						if($state == 2){
							echo "<td style = \"color: rgb(250,150,0);\">A decorrer</td>";
						}
						else if($state == 1){
							echo "<td style = \"color: rgb(0,200,0);\">Pronto a iniciar</td>";
						}else{
							echo "<td>Não Pronto</td>";
						}

						echo "<td><a href=\"tournament-detail.php?tname=".$tournament['Nome_torneio']."\" style=\"color:#5c3ab7;\">ver detalhes</a></td>";
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