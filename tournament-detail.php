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
            $query = sprintf(  "SELECT * 
                                FROM futebolamador.torneios 
                                WHERE torneios.Nome_torneio = \"%s\";", $_GET["tname"]  );

            $result_tournament = $connection->query($query);
            $tournament = mysqli_fetch_array($result_tournament);

            $query = sprintf(  "SELECT * from futebolamador.slot 
                                JOIN futebolamador.campos on slot.Nome_campo=campos.Nome_campo
                                WHERE slot.id_slot IN ( SELECT slot_torneios.id_slot from futebolamador.slot_torneios 
                                                        WHERE slot_torneios.Nome_torneio = \"%s\");", $_GET["tname"]  );

            $result_slots = $connection->query($query);
           

            $connection->close();
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
                <h2><?php echo $tournament['Nome_torneio'];?></h2>
                <div class="row">
					<div>
						<h5>Data de Inicio</h5>
						<?php echo "<input type=date name=\"tournamentstart\" id = \"start\" disabled style=\"background: none;\" value=". $tournament['Data_inicio']."><br><br>";?>
                    </div>
                    <div>
                        <h5>Data de Fim</h5>
						<?php echo "<input type=date name=\"tournamentend\" id = \"end\" disabled style=\"background: none;\" value=". $tournament['Data_fim']."><br><br>";?>
                    </div>
					<div>
						<br>
						<input type="submit" id = "submit" style="visibility:hidden;" value="Gravar"><br>
					</div>
				</div>
				<input type="checkbox" name="change" value="true" id = "check" onclick="getSaveButton()">Alterar datas
					
                <?php
					echo "<table style=\"width:auto;\">";
					echo"<tr>";
						echo"<th>Dia</th>";
						echo"<th>Horário</th>";
						echo"<th>Local</th>";
						echo"<th>Custo Campo</th>";
					echo"</tr>";
                    while($slot = mysqli_fetch_array($result_slots)){
						
						echo"<tr>";
							echo"<td>".$slot['Dia_semana']."</td>";
							echo"<td>".$slot['Hora_inicio']." - ".$slot['Hora_fim']."</td>";
							echo"<td>".$slot['Nome_campo']." - ".$slot['Cidade']."</td>";
							echo"<td>".$slot['Custo']."</td>";
						echo"</tr>";
					}
					echo "</table>"; 
                ?>
             
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