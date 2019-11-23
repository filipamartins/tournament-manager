<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->

<html lang="en">

<style>
	.error {
		color: #FF0000;
	}
</style>

<?php
// define variables and set to empty values


$tournamentnameErr =  $tournamentstartErr = $tournamentendErr =  $checkboxErr = $timeErr = $campErr = "";
$tournamentname = $tournamentstart = $tournamentend = "";
$monday = $tuesday = $wednesday = $thursday = $friday = $saturday = $sunday = "";
$disabled1 = $disabled2 = $disabled3 = $disabled4 = $disabled5 = $disabled6 = $disabled7 = "disabled";
$start1 = $start2 = $start3 = $start4 = $start5 = $start6 = $start7 = "";
$end1 = $end2 = $end3 = $end4 = $end5 = $end6 = $end7 = "";
$camp1 = $camp2 = $camp3 = $camp4 = $camp5 = $camp6 = $camp7 = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["tournamentname"])) {
		$tournamentnameErr = "Nome do torneio obrigatório.";
	} else {
		$tournamentname = test_input($_POST["tournamentname"]);
	}

	if (empty($_POST["tournamentstart"])) {
		$tournamentstartErr = "Data de inicio obrigatória.";
	} else {
		$tournamentstart = test_input($_POST["tournamentstart"]);
	}

	if (empty($_POST["tournamentend"])) {
		$tournamentendErr = "Data de fim obrigatória.";
	} else {
		$tournamentend = test_input($_POST["tournamentend"]);
	}
	if($tournamentstart != "" and $tournamentend != "" and $tournamentend <= $tournamentstart){
		$tournamentendErr = "Data de fim deve ser superior à data de inicio.";
	}

	if (empty($_POST["monday"]) and empty($_POST["tuesday"]) and empty($_POST["wednesday"]) and empty($_POST["thursday"]) and 
		empty($_POST["friday"]) and empty($_POST["saturday"]) and empty($_POST["sunday"])) {
		$checkboxErr = "Obrigatório selecionar pelo menos um dia.";
	}
	else{
		if(!empty($_POST["monday"])){
			$monday = test_input($_POST["monday"]);
			$start1 = test_input($_POST["start1"]);
			$end1 = test_input($_POST["end1"]);
			$camp1 = test_input($_POST["camp1"]);
			if (empty($_POST["start1"]) or empty($_POST["end1"]) or empty($_POST["camp1"])) {
				$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
			} 	
			if($start1 != "" and $end1 != "" and $end1 <= $start1){
				$timeErr = "Hora de fim deve ser superior à hora de inicio.";
			}
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/", $camp1)) {
				$campErr = "Apenas são permitidas letras e espaços em branco para o nome do campo.";
			}
			$disabled1 = "";
		}
		if(!empty($_POST["tuesday"])){
			$tuesday = test_input($_POST["tuesday"]);
			$start2 = test_input($_POST["start2"]);
			$end2 = test_input($_POST["end2"]);
			$camp2 = test_input($_POST["camp2"]);
			if (empty($_POST["start2"]) or empty($_POST["end2"]) or empty($_POST["camp2"])) {
				$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
			}
			if($start2 != "" and $end2 != "" and $end2 <= $start2){
				$timeErr = "Hora de fim deve ser superior à hora de inicio.";
			}
			if (!preg_match("/^[a-zA-Z ]*$/",$camp2)) {
				$campErr = "Apenas são permitidas letras e espaços em branco para o nome do campo.";
			} 
			$disabled2 = "";
		}
		if(!empty($_POST["wednesday"])){
			$wednesday = test_input($_POST["wednesday"]);
			$start3 = test_input($_POST["start3"]);
			$end3 = test_input($_POST["end3"]);
			$camp3 = test_input($_POST["camp3"]);
			if (empty($_POST["start3"]) or empty($_POST["end3"]) or empty($_POST["camp3"])) {
				$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
			} 
			if($start3 != "" and $end3 != "" and $end3 <= $start3){
				$timeErr = "Hora de fim deve ser superior à hora de inicio.";
			}
			if (!preg_match("/^[a-zA-Z ]*$/",$camp3)) {
					$campErr = "Apenas são permitidas letras e espaços em branco para o nome do campo.";
			}
			$disabled3 = "";
		}
		if(!empty($_POST["thursday"])){
			$thursday = test_input($_POST["thursday"]);
			$start4 = test_input($_POST["start4"]);
			$end4 = test_input($_POST["end4"]);
			$camp4 = test_input($_POST["camp4"]);
			if (empty($_POST["start4"]) or empty($_POST["end4"]) or empty($_POST["camp4"])) {
				$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
			} 
			if($start4 != "" and $end4 != "" and $end4 <= $start4){
				$timeErr = "Hora de fim deve ser superior à hora de inicio.";
			}
			if (!preg_match("/^[a-zA-Z ]*$/",$camp4)) {
				$campErr = "Apenas são permitidas letras e espaços em branco para o nome do campo.";
			}
			$disabled4 = "";
		}
		if(!empty($_POST["friday"])){
			$thursday = test_input($_POST["friday"]);
			$start5 = test_input($_POST["start5"]);
			$end5 = test_input($_POST["end5"]);
			$camp5 = test_input($_POST["camp5"]);
			if (empty($_POST["start5"]) or empty($_POST["end5"]) or empty($_POST["camp5"])) {
				$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
			} 
			if($start5 != "" and $end5 != "" and $end5 <= $start5){
				$timeErr = "Hora de fim deve ser superior à hora de inicio.";
			}
			if (!preg_match("/^[a-zA-Z ]*$/",$camp5)) {
				$campErr = "Apenas são permitidas letras e espaços em branco para o nome do campo.";
			}
			$disabled5 = "";
		}
		if(!empty($_POST["saturday"])){
			$thursday = test_input($_POST["saturday"]);
			$start6 = test_input($_POST["start6"]);
			$end6 = test_input($_POST["end6"]);
			$camp6 = test_input($_POST["camp6"]);
			if (empty($_POST["start6"]) or empty($_POST["end6"]) or empty($_POST["camp6"])) {
				$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
			} 
			if($start6 != "" and $end6 != "" and $end6 <= $start6){
				$timeErr = "Hora de fim deve ser superior à hora de inicio.";
			}
			if (!preg_match("/^[a-zA-Z ]*$/",$camp6)) {
				$campErr = "Apenas são permitidas letras e espaços em branco para o nome do campo.";
			}
			$disabled6 = "";
		}
		if(!empty($_POST["sunday"])){
			$thursday = test_input($_POST["sunday"]);
			$start7 = test_input($_POST["start7"]);
			$end7 = test_input($_POST["end7"]);
			$camp7 = test_input($_POST["camp7"]);
			if (empty($_POST["start7"]) or empty($_POST["end7"]) or empty($_POST["camp7"])) {
				$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
			} 
			if($start7 != "" and $end7 != "" and $end7 <= $start7){
				$timeErr = "Hora de fim deve ser superior à hora de inicio.";
			}
			if (!preg_match("/^[a-zA-Z ]*$/",$camp7)) {
				$campErr = "Apenas são permitidas letras e espaços em branco para o nome do campo.";
			}
			$disabled7 = "";
		}
	}

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings

	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0){
		throw new Exception(mysqli_connect_errno());
	} else{
		echo "connected successfully";

		$query = sprintf("INSERT INTO futebolamador.torneios (`Nome_torneio`,`Data_inicio`,`Data_fim`)
			VALUES ('%s','%s','%s');", $tournamentname, $tournamentstart, $tournamentend);
		
		if ($connection->query($query) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $query . "<br>" . $connection->error;
		}
		
		$connection->close();
	}
	
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
	<script src="js/tournament-create.js"></script>
	<noscript>
		<!--	<link rel="stylesheet" href="css/skel.css" /> -->
		<link rel="stylesheet" href="css/style.css" />
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
							<img src="images/foto.jpg" onerror="this.src= 'images/user.png';"
								style="width:auto;height:50px; border-radius:50%">
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
					<li><a href="tournament-create.php"><strong style="color:#5c3ab7;">Criar Novo Torneio</a></strong></li>
					<li><a href="tournament-management.php"><strong>Gestão de Torneios</a></strong></li>
					<li><a href="field-management.php"><strong>Gestão de Campos</a></strong></li>
					<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
				</ul>
			</section>
		</div>
		<div class="9u" style="padding-top: 30px; padding-right: 40px;">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<div>
				Nome do Torneio:<br>
				<input type="text" name="tournamentname" value="<?php echo $tournamentname;?>"><br>
				<span class="error"><?php echo $tournamentnameErr;?></span>
				</div>
				
				<div class="row">
					<div>
						Data de inicio do torneio:<br>
						<input type="date" name="tournamentstart" value="<?php echo $tournamentstart;?>"><br><br>
						<span class="error"><?php echo $tournamentstartErr;?></span>
					</div>
					<div>
						Data de fim do torneio:<br>
						<input type="date" name="tournamentend" value="<?php echo $tournamentend;?>"><br><br>
						<span class="error"><?php echo $tournamentendErr;?></span>
					</div>
				</div>
				Selecionar dias de jogos:<br><br>
				<div class="row" style="margin-left:0px;">
					<div style="padding-left:0px; width: 11.8%">
						<input type="checkbox" name="monday"  value="true" id = "check1" onclick="getTime(1)" <?php if (isset($_POST['monday'])) echo "checked";?>>Segunda-Feira<br><br>
							Inicio: <input type="time" name="start1" id = "start1" value=
							"<?php echo $start1;?>" <?php echo $disabled1;?>><br>
							Fim: <input type="time" name="end1" style="margin-left: 10px;" id = "end1" value=
							"<?php echo $end1;?>" <?php echo $disabled1;?>><br><br>
							Campo:<br>
							<input type="text" name="camp1" id ="camp1" value="<?php echo $camp1;?>" <?php echo $disabled1;?>><br>
						
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="tuesday" value="true" id = "check2" onclick="getTime(2)" <?php if (isset($_POST['tuesday'])) echo "checked";?>>Terça-Feira<br><br>
							Inicio: <input type="time" name="start2" id = "start2" value=
							"<?php echo $start2;?>" <?php echo $disabled2;?>><br>
							Fim: <input type="time" name="end2" style="margin-left: 10px;" id = "end2" value=
							"<?php echo $end2;?>" <?php echo $disabled2;?>><br><br>
							Campo:<br>
							<input type="text" name="camp2" id ="camp2" value="<?php echo $camp2;?>" <?php echo $disabled2;?>><br>
						
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="wednesday" value="true" id = "check3" onclick="getTime(3)" <?php if (isset($_POST['wednesday'])) echo "checked";?>>Quarta-Feira<br><br>
							Inicio: <input type="time" name="start3" id = "start3" value=
							"<?php echo $start3;?>" <?php echo $disabled3;?>><br>
							Fim: <input type="time" name="end3" style="margin-left: 10px;" id = "end3" value=
							"<?php echo $end3;?>" <?php echo $disabled3;?>><br><br>
							Campo:<br>
							<input type="text" name="camp3" id ="camp3" value="<?php echo $camp3;?>" <?php echo $disabled3;?>><br>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="thursday" value="true" id = "check4" onclick="getTime(4)" <?php if (isset($_POST['thursday'])) echo "checked";?>>Quinta-Feira<br><br>
							Inicio: <input type="time" name="start4" id = "start4" value=
							"<?php echo $start4;?>" <?php echo $disabled4;?>><br>
							Fim: <input type="time" name="end4" style="margin-left: 10px;" id = "end4" value=
							"<?php echo $end4;?>" <?php echo $disabled4;?>><br><br>
							Campo:<br>
							<input type="text" name="camp4" id ="camp4" value="<?php echo $camp4;?>" <?php echo $disabled4;?>><br>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="friday" value="true" id = "check5" onclick="getTime(5)" <?php if (isset($_POST['friday'])) echo "checked";?>>Sexta-Feira<br><br>
							Inicio: <input type="time" name="start5" id = "start5" value=
							"<?php echo $start5;?>" <?php echo $disabled5;?>><br>
							Fim: <input type="time" name="end5" style="margin-left: 10px;" id = "end5" value=
							"<?php echo $end5;?>" <?php echo $disabled5;?>><br><br>
							Campo:<br>
							<input type="text" name="camp5" id ="camp5" value="<?php echo $camp5;?>" <?php echo $disabled5;?>><br>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="saturday" value="true" id = "check6" onclick="getTime(6)" <?php if (isset($_POST['saturday'])) echo "checked";?>>Sábado<br><br>
							Inicio: <input type="time" name="start6" id = "start6" value=
							"<?php echo $start6;?>" <?php echo $disabled6;?>><br>
							Fim: <input type="time" name="end6" style="margin-left: 10px;" id = "end6" value=
							"<?php echo $end6;?>" <?php echo $disabled6;?>><br><br>
							Campo:<br>
							<input type="text" name="camp6" id ="camp6" value="<?php echo $camp6;?>" <?php echo $disabled6;?>><br>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="sunday" value="true" id = "check7" onclick="getTime(7)" <?php if (isset($_POST['sunday'])) echo "checked";?>>Domingo<br><br>
							Inicio: <input type="time" name="start7" id = "start7" value=
							"<?php echo $start7;?>" <?php echo $disabled7;?>><br>
							Fim: <input type="time" name="end7" style="margin-left: 10px;" id = "end7" value=
							"<?php echo $end7;?>" <?php echo $disabled7;?>><br><br>
							Campo:<br>
							<input type="text" name="camp7" id ="camp7" value="<?php echo $camp7;?>" <?php echo $disabled7;?>>
					</div>
					<span class="error" style = "padding-left:0px;"><?php echo $checkboxErr;?></span>
					<span class="error" style = "padding-left:0px;"><?php echo $timeErr;?></span><p></p>
					<span class="error" style = "padding-left:0px;"><?php echo $campErr;?></span>
				</div><br>
				<div style="text-align:center">
					<input type="submit" value="Criar"><br>
				</div>
			</form>
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

