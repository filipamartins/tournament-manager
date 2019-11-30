<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
	<html lang="en">


	<?php
		$tname = $_GET["tname"];

		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings

		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno != 0){
			throw new Exception(mysqli_connect_errno());
		} else{
			//echo "connected successfully";
			$query = sprintf(  "SELECT torneios.Numero_confrontos
                                FROM futebolamador.torneios 
                                WHERE torneios.Nome_torneio = \"%s\";", $tname  );

            $result_tournament = $connection->query($query);
			$nVoltas = mysqli_fetch_array($result_tournament);
			//$connection->close();
		}

		function getTournamentGames($tname){
			global $connection;
			$query = sprintf("  SELECT jogos.Data, jogos.Nome_equipa_visitante, jogos.Nome_equipa_visitada, jogos.Jornada, 
										jogos.Volta, slot.Hora_inicio, slot.Hora_fim, slot.Nome_campo 
								FROM futebolamador.jogos 
								JOIN futebolamador.slot on slot.id_slot = jogos.id_slot 
								WHERE jogos.Nome_torneio = '%s' 
								ORDER BY jogos.Data;", $tname); 
						
			$games = $connection->query($query);
			return $games;
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
						<li><a href="field-management.php"><strong>Gestão de Campos</a></strong></li>
						<li><a href="tournament-list.php"><strong style="color:#5c3ab7;">Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
				<h2>Tabela de Jogos: <?php echo $tname;?></h2>
				<?php echo "<h4>Volta 1:</h4>";?>
				<table style="width:100%">
				<tr style="background: #afd2f0;">
					<th>Jornada</th>
					<th>Data</th>
					<th>Equipa Visitada</th>
					<th>Equipa Visitante</th>
					<th>Horário</th>
					<th>Campo</th>
				</tr>
				<?php
					$games = getTournamentGames($tname);
					while($game = mysqli_fetch_array($games)){
						echo "<tr>";
						if($game['Volta'] == 1){
							echo "<td>" . $game['Jornada'] . "</td>";
							echo "<td>" . $game['Data'] . "</td>";
							echo "<td>" . $game['Nome_equipa_visitada'] . "</td>";
							echo "<td>" . $game['Nome_equipa_visitante'] . "</td>";
							echo "<td>" . $game['Hora_inicio'] . " - " . $game['Hora_fim'] . "</td>";
							echo "<td>" . $game['Nome_campo'] . "</td>";
						}
						echo "</tr>";
					}
				?>
				</table> 
				<?php 
					if($nVoltas[0] > 1){
						echo "<h4>Volta 2:</h4>";	
						echo "<table style=\"width:100%\">";
						echo "<tr style=\"background: #afd2f0;\">";
							echo "<th>Jornada</th>";
							echo "<th>Data</th>";
							echo "<th>Equipa Visitada</th>";
							echo "<th>Equipa Visitante</th>";
							echo "<th>Horário</th>";
							echo "<th>Campo</th>";
						echo"</tr>";
							
						$games = getTournamentGames($tname);
						while($game = mysqli_fetch_array($games)){
							echo "<tr>";
							if($game['Volta'] == 2){
								echo "<td>" . $game['Jornada'] . "</td>";
								echo "<td>" . $game['Data'] . "</td>";
								echo "<td>" . $game['Nome_equipa_visitante'] . "</td>";
								echo "<td>" . $game['Nome_equipa_visitada'] . "</td>";
								echo "<td>" . $game['Hora_inicio'] . " - " . $game['Hora_fim'] . "</td>";
								echo "<td>" . $game['Nome_campo'] . "</td>";
							}
							echo "</tr>";
						}
						echo "</table>"; 
						$connection->close();
					}
				?>
				<div style="text-align:left">
					<a href="tournament-detail.php?tname=<?php echo $tname;?>"><input type="button" value="<- Detalhes torneio"></a>
				</div><br>
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