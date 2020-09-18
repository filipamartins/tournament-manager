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
	$user_id = 11111111;
	// define variables and set to empty values
	$tournamentnameErr =  $tournamentstartErr = $tournamentendErr =  $checkboxErr = $timeErr = $fieldErr = "";
	$tournamentname = $tournamentstart = $tournamentend = "";
	$weekday = array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");
	$weekdayPT = array("Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo");
	$nRepresentation = array(1, 2, 3, 4, 5, 6, 0); //Numeric representation of the day of the week
	$disabled = array(); 
	$day = array();
	$start = $end = array();
	$field = array();

	for ($i = 0; $i < 7; $i++){
		array_push($disabled, "disabled");
		array_push($day, "");
		array_push($start, "");
		array_push($end, "");
		array_push($field, "");
	}
	
	$error = false;
	$connection = connectToDatabase();
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$tournamentname = test_input($_POST["tournamentname"]);
		$tournamentstart = test_input($_POST["tournamentstart"]);
		$tournamentend = test_input($_POST["tournamentend"]);

		if (empty($_POST["tournamentname"])) {
			$tournamentnameErr = "Nome do torneio obrigatório.";
			$error = true;
		}
		if (empty($_POST["tournamentstart"])) {
			$tournamentstartErr = "Data de inicio obrigatória.";
			$error = true;
		}
		if (empty($_POST["tournamentend"])) {
			$tournamentendErr = "Data de fim obrigatória.";
			$error = true;
		} 
		if($tournamentstart != "" and $tournamentend != "" and $tournamentend <= $tournamentstart){
			$tournamentendErr = "Data de fim deve ser superior à data de inicio.";
			$error = true;
		}
		
		$daySelected = false; //checks if at least one day is selected
		for ($i = 0; $i < 7; $i++){
			if (!empty($_POST[$weekday[$i]])) 
				$daySelected = true;
		}

		if(!$daySelected){
			$checkboxErr = "Obrigatório selecionar pelo menos um dia.";
			$error = true;
		}
		else{ //if at least one day is selected
			for ($i = 0; $i < 7; $i++){
				if(!empty($_POST[$weekday[$i]])){
					$day[$i] = test_input($_POST[$weekday[$i]]);
					$start[$i] = test_input($_POST["start".($i+1)]);
					$end[$i] = test_input($_POST["end".($i+1)]);
					$field[$i] = test_input($_POST["field".($i+1)]);
					if ($start[$i] == "" or $end[$i] == "" or $field[$i] == "") {
						$timeErr = "Obrigatório preencher hora de inicio de fim e campo.";
						$error = true;
					} 	
					if($start[$i] != "" and $end[$i] != "" and $end[$i] <= $start[$i]){
						$timeErr = "Hora de fim deve ser superior à hora de inicio.";
						$error = true;
					}
					$disabled[$i] = "";
				}
			}
		}
		
		if(!$error){
			//Check if tournament to be created intersects another tournament already created			
			for ($i = 0; $i < 7; $i++){
				if($day[$i] != ""){
					$query = sprintf("SELECT torneios.Nome_torneio, slot.Hora_inicio, slot.Hora_fim, slot.Numero_dia, slot.Nome_campo, torneios.Data_inicio, torneios.Data_fim
								FROM futebolamador.torneios
								JOIN futebolamador.slot_torneios on slot_torneios.Nome_torneio = torneios.Nome_torneio
								JOIN futebolamador.slot on slot_torneios.id_slot = slot.id_slot
								WHERE ('%s' <= torneios.Data_fim  AND torneios.Data_inicio <= '%s') AND ('%s' LIKE slot.Nome_campo ) 
								AND ('%s'=slot.Numero_dia) AND ('%s' <= slot.Hora_fim  AND slot.Hora_inicio <= '%s') ;", 
								$tournamentstart, $tournamentend, $field[$i], $nRepresentation[$i], $start[$i], $end[$i]);
					//START A <= END B
					//START B <= END A
					$intersection = $connection->query($query);
					if(mysqli_num_rows($intersection) != 0){
						$timeErr = "As datas, horas e campo colocados são incompativeis com as de outro torneio. Por favor altere um destes campos.";
						$error = true;
					} 
				}
			}
		}
		
		if(!$error){

			$query = sprintf("  INSERT INTO futebolamador.torneios (`Nome_torneio`,`Data_inicio`,`Data_fim`)
								VALUES ('%s','%s','%s');", $tournamentname, $tournamentstart, $tournamentend);

			if ($connection->query($query) === TRUE) {
				echo "New tournament created successfully";
				setUserToManager($tournamentname); //set user that created tournament to manager of that tournament
				for ($i = 0; $i < 7; $i++){
					if($day[$i] != ""){
						$query = sprintf("INSERT INTO futebolamador.slot (`Nome_campo`,`Hora_inicio`,`Hora_fim`,`Dia_semana`, `Numero_dia`)
						VALUES ('%s','%s','%s','%s','%s');", $field[$i], $start[$i], $end[$i], $weekdayPT[$i], $nRepresentation[$i]);
						if ($connection->query($query) === TRUE) {
							echo "New slot created successfully";
							$slot_id = mysqli_insert_id($connection);
							$query = sprintf("INSERT INTO futebolamador.slot_torneios (`id_slot`, `Nome_torneio`) 
							VALUES ('%s','%s');", $slot_id, $tournamentname);
							if ($connection->query($query) === TRUE) {
								echo "New slot_torneio created successfully";
							}
							else {
								echo "Error: " . $query . "<br>" . $connection->error;
							}
						} else {
							echo "Error: " . $query . "<br>" . $connection->error;
						}
						header('Location: tournament-management.php');
						$connection->close();
					}
				}
			} else {
				echo "Error: " . $query . "<br>" . $connection->error;
			}
		}
	}

	function connectToDatabase(){
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings

		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno != 0){
			throw new Exception(mysqli_connect_errno());
		} else{
			//echo "connected successfully";
		}
		return $connection;
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function fieldsDropdown(){
		global $connection;
		$query = "SELECT * FROM futebolamador.campos;";
		$result =  $connection->query($query);
		$option = 1;
		echo "<option value=\"\" selected hidden>Opção >></option>;";
		while($row = mysqli_fetch_array($result)){
			echo "  <option value=\"".$row['Nome_campo']."\">
					Opção ".$option." &nbsp;&nbsp;&nbsp;>&nbsp; ".$row['Nome_campo']."
					</option>";
			$option++;
		}
	}

	function setUserToManager($tname){
		global $connection;
		global $user_id;
		$query = sprintf("  INSERT INTO futebolamador.gestores_torneio_torneios (`CC`, `Nome_torneio`) 
							VALUES ('%s','%s');", $user_id, $tname );
		if ($connection->query($query) === TRUE) {
			$query = sprintf("	INSERT INTO futebolmador.gestores_torneio(`CC`) VALUES ('%s');", $user_id);
			if ($connection->query($query) === TRUE) {
				echo "User set to tournament manager.";
			}
			else {
				echo "Error: " . $query . "<br>" . $connection->error;
			}
		}
		else {
			echo "Error: " . $query . "<br>" . $connection->error;
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
	<script src="js/tournament.js"></script>
	<noscript>
		<link rel="stylesheet" href="css/style.css" />
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
					<li><a href="tournament-create.php"><strong style="color:#5c3ab7;">Criar Novo Torneio</a></strong></li>
					<li><a href="tournament-management.php"><strong>Gestão de Torneios</a></strong></li>
					<li><a href="field-management.php"><strong>Gestão de Campos</a></strong></li>
					<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
				</ul>
			</section>
		</div>
		<div class="9u" style="padding-top: 30px; padding-right: 40px;">
			<h2>Criar Torneio:</h2>
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
							"<?php echo $start[0];?>" <?php echo $disabled[0];?>><br>
							Fim: <input type="time" name="end1" style="margin-left: 10px;" id = "end1" value=
							"<?php echo $end[0];?>" <?php echo $disabled[0];?>><br><br>
							Campo:<br>
							<select name="field1" id="field1" <?php echo $disabled[0];?>>
								<?php
									fieldsDropdown();
								?>
							</select>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="tuesday" value="true" id = "check2" onclick="getTime(2)" <?php if (isset($_POST['tuesday'])) echo "checked";?>>Terça-Feira<br><br>
							Inicio: <input type="time" name="start2" id = "start2" value=
							"<?php echo $start[1];?>" <?php echo $disabled[1];?>><br>
							Fim: <input type="time" name="end2" style="margin-left: 10px;" id = "end2" value=
							"<?php echo $end[1];?>" <?php echo $disabled[1];?>><br><br>
							Campo:<br>
							<select name="field2" id="field2" <?php echo $disabled[1];?>>
								<?php
									fieldsDropdown();
								?>
							</select>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="wednesday" value="true" id = "check3" onclick="getTime(3)" <?php if (isset($_POST['wednesday'])) echo "checked";?>>Quarta-Feira<br><br>
							Inicio: <input type="time" name="start3" id = "start3" value=
							"<?php echo $start[2];?>" <?php echo $disabled[2];?>><br>
							Fim: <input type="time" name="end3" style="margin-left: 10px;" id = "end3" value=
							"<?php echo $end[2];?>" <?php echo $disabled[2];?>><br><br>
							Campo:<br>
							<select name="field3" id="field3" <?php echo $disabled[2];?>>
								<?php
									fieldsDropdown();
								?>
							</select>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="thursday" value="true" id = "check4" onclick="getTime(4)" <?php if (isset($_POST['thursday'])) echo "checked";?>>Quinta-Feira<br><br>
							Inicio: <input type="time" name="start4" id = "start4" value=
							"<?php echo $start[3];?>" <?php echo $disabled[3];?>><br>
							Fim: <input type="time" name="end4" style="margin-left: 10px;" id = "end4" value=
							"<?php echo $end[3];?>" <?php echo $disabled[3];?>><br><br>
							Campo:<br>
							<select name="field4" id="field4" <?php echo $disabled[3];?>>
								<?php
									fieldsDropdown();
								?>
							</select>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="friday" value="true" id = "check5" onclick="getTime(5)" <?php if (isset($_POST['friday'])) echo "checked";?>>Sexta-Feira<br><br>
							Inicio: <input type="time" name="start5" id = "start5" value=
							"<?php echo $start[4];?>" <?php echo $disabled[4];?>><br>
							Fim: <input type="time" name="end5" style="margin-left: 10px;" id = "end5" value=
							"<?php echo $end[4];?>" <?php echo $disabled[4];?>><br><br>
							Campo:<br>
							<select name="field5" id="field5" <?php echo $disabled[4];?>>
								<?php
									fieldsDropdown();
								?>
							</select>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="saturday" value="true" id = "check6" onclick="getTime(6)" <?php if (isset($_POST['saturday'])) echo "checked";?>>Sábado<br><br>
							Inicio: <input type="time" name="start6" id = "start6" value=
							"<?php echo $start[5];?>" <?php echo $disabled[5];?>><br>
							Fim: <input type="time" name="end6" style="margin-left: 10px;" id = "end6" value=
							"<?php echo $end[5];?>" <?php echo $disabled[5];?>><br><br>
							Campo:<br>
							<select name="field6" id="field6" <?php echo $disabled[5];?>>
								<?php
									fieldsDropdown();
								?>
							</select>
					</div>
					<div style = "width: 14.5%">
						<input type="checkbox" name="sunday" value="true" id = "check7" onclick="getTime(7)" <?php if (isset($_POST['sunday'])) echo "checked";?>>Domingo<br><br>
							Inicio: <input type="time" name="start7" id = "start7" value=
							"<?php echo $start[6];?>" <?php echo $disabled[6];?>><br>
							Fim: <input type="time" name="end7" style="margin-left: 10px;" id = "end7" value=
							"<?php echo $end[6];?>" <?php echo $disabled[6];?>><br><br>
							Campo:<br>
							<select name="field7" id="field7" <?php echo $disabled[6];?>>
								<?php
									fieldsDropdown();
								?>
							</select>
					</div>
					<span class="error" style = "padding-left:0px;"><?php echo $checkboxErr;?></span>
					<span class="error" style = "padding-left:0px;"><?php echo $timeErr;?></span><p></p>
					<span class="error" style = "padding-left:0px;"><?php echo $fieldErr;?></span>
				</div>
				<div style="text-align:center">
                    <div style="display:inline-flex;">
                        <a href="tournament-list.php"><input type="button" style="background-color: rgb(170,170,170);" value="Cancelar"></a><br>
						<input type="submit" value="Criar"><br>
					</div>
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

