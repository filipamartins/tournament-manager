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
            $query = sprintf(  "SELECT * 
                                FROM futebolamador.torneios 
                                WHERE torneios.Nome_torneio = \"%s\";", $tname  );

            $result_tournament = $connection->query($query);
            $tournament = mysqli_fetch_array($result_tournament);

		   
			$query = sprintf(  "SELECT * 
                                FROM futebolamador.equipas 
								WHERE equipas.Nome_torneio = \"%s\";", $tname  );

			
			$result_teams = $connection->query($query);


            //$connection->close();
		}
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$tournamentstart = test_input($_POST["tournamentstart"]);
			$tournamentend = test_input($_POST["tournamentend"]);

			$query = sprintf("  UPDATE futebolamador.torneios
								SET torneios.Data_inicio = '%s', torneios.Data_fim = '%s'
								WHERE torneios.Nome_torneio = '%s';", $tournamentstart, $tournamentend, $tname);
			if ($connection->query($query) === TRUE) {
				echo "Date updated successfully";
			}
			else {
				echo "Error: " . $query . "<br>" . $connection->error;
			}
		}

		function getSlots(){
			global $connection;
			global $tname;
			$query = sprintf(  "SELECT * from futebolamador.slot 
                                JOIN futebolamador.campos on slot.Nome_campo=campos.Nome_campo
                                WHERE slot.id_slot IN ( SELECT slot_torneios.id_slot from futebolamador.slot_torneios 
                                                        WHERE slot_torneios.Nome_torneio = \"%s\");", $tname  );

			$result_slots = $connection->query($query);
			return $result_slots;
		}
		
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
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
		<script src="js/tournament.js"></script>
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
                <h2><?php echo $tournament['Nome_torneio'];?></h2>
				<form action="tournament-detail.php?tname=<?php echo $tname?>" method="post">
					<div class="row">
						<div>
							<h5>Data de Inicio</h5>
							<input type=date name="tournamentstart" id ="start" disabled style="background: none;" value="<?php echo $tournament['Data_inicio']?>"><br><br>
						</div>
						<div>
							<h5>Data de Fim</h5>
							<input type=date name="tournamentend" id ="end" disabled style="background: none;" value="<?php echo $tournament['Data_fim']?>"><br><br>
						</div>
						<div>
							<br>
							<input type="submit" id ="submit" style="visibility:hidden;" value="Gravar">
						</div>
					</div>
					<input type="checkbox" name="change" value="true" id ="check" onclick="getSaveButton()">Alterar datas
					</form>
				
				<div class="row">
					<div>
						<h5>Dia</h5>	
						<?php
							$result_slots = getSlots();
							while($slot = mysqli_fetch_array($result_slots)){
								echo $slot['Dia_semana'];
								echo "<br>";
							}
						?>
					</div>
					<div>
						<h5>Horário</h5>
						<?php
							$result_slots = getSlots();
							while($slot = mysqli_fetch_array($result_slots)){
								echo $slot['Hora_inicio']." - ".$slot['Hora_fim'];
								echo "<br>";
							}
						?>	
					</div>
					<div>
						<h5>Local</h5>	
						<?php
							$result_slots = getSlots();
							while($slot = mysqli_fetch_array($result_slots)){
								echo $slot['Nome_campo']." - ".$slot['Cidade'];
								echo "<br>";
							}
						?>
					</div>
					<div>
						<h5>Custo campo</h5>	
						<?php
							$result_slots = getSlots();
							while($slot = mysqli_fetch_array($result_slots)){
								echo $slot['Custo'];
								echo "<br>";
							}
						?>
					</div>
				</div><br>
                <?php
					if(mysqli_num_rows($result_teams) !=0){
						echo "<table style=\"width:70%;\">";
						echo"<tr style=\"background: #afd2f0;\">";
						echo"<th>Equipas</th>";
						echo"<th>Capitão</th>";
						echo"<th>Estado</th>";
						echo"</tr>";
						
						while($team = mysqli_fetch_array($result_teams)){
							
							echo"<tr>";
							echo"<td>".$team['Nome_equipa']."</td>";

							$query = sprintf(  "SELECT utilizadores.Primeiro_nome, utilizadores.Ultimo_nome
												FROM futebolamador.utilizadores
												WHERE utilizadores.CC = '%s';", $team['CC']  );
							
							$result_captain = $connection->query($query);
							$captain = mysqli_fetch_array($result_captain);

							echo"<td>".$captain[0]." ".$captain[1]."</td>";
							if($team['Estado'] == 1){
								echo"<td style = \"color: rgb(0,200,0);\">Completa</td>";
							}else{
								echo"<td>Incompleta</td>";
							}
							echo"</tr>";
						}
						echo "</table>"; 
					}
                ?>
				<div class="row">
					<div>
						<h5>Nº de jogos entre pares de equipas:</h5>
						<input type="number" id="games" name="games" min="1" max="2" style="background: none;"><br><br>
					</div>
					<div>
					</div>
					<div>
						<div style="text-align:right">
						<input type="submit" id = "submit" value="Gerar Jogos"><br><br>
						</div>
					</div>
				</div>
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