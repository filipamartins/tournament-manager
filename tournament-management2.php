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
        $tname = $_GET["tname"];
        $tournamentGamesErr = "";

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings

        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->connect_errno != 0){
            throw new Exception(mysqli_connect_errno());
        } else{
            //echo "connected successfully";
        }
        $query = sprintf(  "SELECT * FROM futebolamador.torneios 
                            WHERE torneios.Nome_torneio = \"%s\";", $tname  );

        $result_tournament = $connection->query($query);
        $tournament = mysqli_fetch_array($result_tournament);
        $tournamentstart = $tournament['Data_inicio'];
        $tournamentend = $tournament['Data_fim'];
        //$connection->close();
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if(isset($_POST["submit_date"])) { 
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
			else if(isset($_POST["submit_manager"])) { 
				$captainCC =  test_input($_POST["captains"]);
				if($captainCC != ""){

					$query = sprintf("  INSERT INTO futebolamador.gestores_torneio (`CC`)
										VALUES ('%s');", $captainCC );

					if ($connection->query($query) === TRUE) {
						$query = sprintf("  INSERT INTO futebolamador.gestores_torneio_torneios (`CC`, `Nome_torneio`) 
											VALUES ('%s', '%s');", $captainCC, $tname);

						if ($connection->query($query) === TRUE) {
							echo "Manager updated successfully";
						}
						else {
							echo "Error: " . $query . "<br>" . $connection->error;
						}	
					}else {
						echo "Error: " . $query . "<br>" . $connection->error;
					}					
				}
			}
			else if(isset($_POST["submit_captain"])) { 
				$playerCC =  test_input($_POST["players"]);
				$teamName = test_input($_POST["team"]);
				if($playerCC != ""){
					$captainCC = getTeamCaptain($teamName);
					
					$query = sprintf("DELETE FROM futebolamador.capitaes WHERE capitaes.CC = '%s';", $captainCC[0]);

					if ($connection->query($query) === TRUE) {
						$query = sprintf("INSERT INTO futebolamador.capitaes (`CC`) VALUES ('%s');", $playerCC);
						
						if ($connection->query($query) === TRUE) {
							$query = sprintf("  UPDATE futebolamador.equipas
												SET equipas.CC = '%s'
												WHERE equipas.Nome_equipa = '%s';", $playerCC, $teamName);
							
							if ($connection->query($query) === TRUE) {
								echo "Captain updated successfully";
							}
							else {
								echo "Error: " . $query . "<br>" . $connection->error;
							}	
						}
						else {
							echo "Error: " . $query . "<br>" . $connection->error;
						}
					}
					else {
						echo "Error: " . $query . "<br>" . $connection->error;
					}	
				}
            }
            else if(isset($_POST["submit_games"])) {
                $games = test_input($_POST["games"]);
                $error = false;

                if (empty($_POST["games"])) {
                    $tournamentGamesErr = "Obrigatório indicar número de jogos.";
                    $error = true;
                }
                if(!$error){
                    $query = sprintf("  UPDATE futebolamador.torneios SET torneios.Numero_confrontos = '%s'
                                        WHERE torneios.Nome_torneio = '%s';", $games, $tname);
                    if ($connection->query($query) === TRUE) {
                        generateGames($games);
                        $connection->close();
                        header('Location: tournament-management3.php?tname='.$tournament['Nome_torneio'].'');
                       
                    }
                }
            } 
		}

		function getManagers($tname){
			global $connection;
			$query = sprintf(  "SELECT utilizadores.Primeiro_nome, utilizadores.Ultimo_nome FROM futebolamador.utilizadores 
								WHERE utilizadores.CC IN (  SELECT gestores_torneio_torneios.CC FROM futebolamador.gestores_torneio_torneios 
															WHERE gestores_torneio_torneios.Nome_torneio = \"%s\");", $tname );
	
			$managers = $connection->query($query);
			return $managers;
		}

		function getTeams($tname){
			global $connection;
			$query = sprintf(  "SELECT * FROM futebolamador.equipas 
								WHERE equipas.Nome_torneio = \"%s\"
								ORDER BY equipas.Nome_equipa;", $tname );

			$teams = $connection->query($query);
			return $teams;
		}

		function getTeamPlayers($teamName){
			global $connection;
			$query = sprintf(  "SELECT utilizadores.CC, utilizadores.Primeiro_nome, utilizadores.Ultimo_nome 
								FROM futebolamador.utilizadores 
								WHERE utilizadores.CC IN (  SELECT equipas_jogadores.CC 
															FROM futebolamador.equipas_jogadores 
															WHERE equipas_jogadores.Nome_equipa = '%s');", $teamName );
			$team_players = $connection->query($query);
			return $team_players;
		}

		function getTeamCaptain($teamName){
			global $connection;
			$query = sprintf("SELECT equipas.CC FROM futebolamador.equipas WHERE equipas.Nome_equipa = \"%s\";", $teamName );
			$result_captainCC = $connection->query($query);
			$captainCC = mysqli_fetch_array($result_captainCC);
			return $captainCC;
		}

		function getTeamCaptainInfo($team){
			global $connection;
			$query = sprintf(  "SELECT utilizadores.CC, utilizadores.Primeiro_nome, utilizadores.Ultimo_nome
													FROM futebolamador.utilizadores
													WHERE utilizadores.CC = '%s';", $team['CC'] );
								
			$result_captain = $connection->query($query);
			$captain = mysqli_fetch_array($result_captain);
			return $captain;
        }
        
        function getSlots($tname){
			global $connection;
			$query = sprintf(  "SELECT * from futebolamador.slot 
                                JOIN futebolamador.campos on slot.Nome_campo=campos.Nome_campo
                                WHERE slot.id_slot IN ( SELECT slot_torneios.id_slot from futebolamador.slot_torneios 
                                                        WHERE slot_torneios.Nome_torneio = \"%s\");", $tname  );

			$slots = $connection->query($query);
			return $slots;
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
        
        function generateGames($games){
            global $connection;
            global $tournament;
            $completed_teams = array();
            $paired_teams = array();
            $weekdays = array();
            $weekdays_idSlot = array();
          
            $slots = getSlots($tournament['Nome_torneio']);
            $teams = getTeams($tournament['Nome_torneio']);

            while($team = mysqli_fetch_array($teams)){
                if($team['Estado'] == 1){
                    array_push($completed_teams, $team);
                } 
            }

            while($slot = mysqli_fetch_array($slots)){
                $weekdays_idSlot[$slot['Numero_dia']]  = $slot['id_slot'] ; //associar representacao numerica do dia ao slot
                array_push($weekdays, $slot['Numero_dia']);
            } 

            $nTeams = sizeof($completed_teams);
            if($nTeams %2 !=0){
                array_push($completed_teams, NULL);//add ghost team
                $nTeams+=1;
            }

            //Comecar a contar da data em que inicia o torneio
            $date = $tournament['Data_inicio'];
            //Numeric representation of the day of the week - 0 (for Sunday) through 6 (for Saturday)
            $dayofweek = date('w', strtotime($date)); 
            
            $volta = 0;
            for ($j = 0; $j < $games; $j++){ // numero de voltas
                $initialTeam = $completed_teams[1]; //team in second position
                $initialTeamName = $initialTeam['Nome_equipa'];
                $volta++;
                $jornada = 0;
                echo "VOLTA ".$j;
                do{                                     //ate obter todas as combinações para ter uma volta 
                                                        //(todas as equipas jogam uma vez com cada uma das outras)
                    for ($i = 0; $i < $nTeams; $i+=2){  // Jornada (Cada equipa joga apenas uma vez)
                        if(isset($completed_teams[$i]) and isset($completed_teams[$i+1])){
                            $pair = array($completed_teams[$i], $completed_teams[$i+1]);
                            array_push($paired_teams, $pair);
                        }
                    }
                    $jornada++; 

                    //criar jogos da jornada
                    $n2 = sizeof($paired_teams);

                    for ($i = 0; $i < $n2; $i++){
                        while(!in_array($dayofweek, $weekdays)){ //se o dia da semana da data corresponder a um dia de semana definido no torneio
                            $date = date('Y-m-d', strtotime($date .' +1 day')); //dia seguinte
                            $dayofweek = date('w', strtotime($date));
                        }  
                        $team1 = $paired_teams[$i][0];
                        $team2 = $paired_teams[$i][1];
                        $idSlot = $weekdays_idSlot[$dayofweek];
                        $query = sprintf("  INSERT INTO futebolamador.jogos (`Nome_torneio`, `Data`, `Nome_equipa_visitada`, 
                                                                             `Nome_equipa_visitante`, `id_slot`, `Jornada`, `Volta`) 
                                            VALUES ('%s','%s','%s','%s','%s','%s','%s');", 
                                                                            $tournament['Nome_torneio'], $date, 
                                                                            $team1['Nome_equipa'], $team2['Nome_equipa'],
                                                                            $idSlot, $jornada, $volta);
                        if ($connection->query($query) === TRUE) {
                            echo "Game created successfully";
                        }
                        else {
                            echo "Error: " . $query . "<br>" . $connection->error;
                        }
                        //Avançar a data para o proximo jogo ou para a proxima jornada
                        $date = date('Y-m-d', strtotime($date .' +1 day'));	
                        $dayofweek = date('w', strtotime($date));
                    }
                    $paired_teams = array();

                    $second_team = $completed_teams[1];
                    for ($i = 1; $i < $nTeams-1; $i++){
                        $completed_teams[$i] = $completed_teams[$i + 1];
                    }
                    $completed_teams[$nTeams-1] = $second_team;
                
                    $secondPositionTeam = $completed_teams[1];
                    
                }while($initialTeamName != $secondPositionTeam['Nome_equipa']);
            }
            $end_date = $tournament['Data_fim'];
            $date = date('Y-m-d', strtotime($date .' -1 day')); //correct real end date of tournament 	
            if($date > $end_date){
                $query = sprintf("  UPDATE futebolamador.torneios
									SET torneios.Data_fim = '%s'
									WHERE torneios.Nome_torneio = '%s';", $date, $tournament['Nome_torneio']);
                
                if ($connection->query($query) === TRUE) {
					echo "End date updated successfully";
				}
				else {
					echo "Error: " . $query . "<br>" . $connection->error;
				}
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
						<li><a href="tournament-management.php"><strong style="color:#5c3ab7;">Gestão de Torneios</a></strong></li>
						<li><a href="field-management.php"><strong>Gestão de Campos</a></strong></li>
						<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
                <h2><?php echo $tournament['Nome_torneio'];?></h2>
				<form action="tournament-management2.php?tname=<?php echo $tname?>" method="post">
					<div class="row">
						<div>
							<h5>Data de Inicio</h5>
							<input type=date name="tournamentstart" id ="start" disabled style="background: none;" value="<?php echo $tournamentstart?>"><br><br>
						</div>
						<div>
							<h5>Data de Fim</h5>
							<input type=date name="tournamentend" id ="end" disabled style="background: none;" value="<?php echo $tournamentend?>"><br><br>
						</div>
						<div>
							<br>
							<input type="submit" name="submit_date" id ="submit" style="visibility:hidden;" value="Gravar">
						</div>
					</div>
					<?php 
						$ongoing = tournamentState($tname);
						if(!$ongoing[0]){
							echo "<input type=\"checkbox\" id =\"check\" onclick=\"getSaveButton()\">Alterar datas";
						}
					?>
				</form>
				
				<div class="row">
					<div>
						<h5>Gestores de Torneio</h5>
						<?php 
							$managers = getManagers($tname);
							while($manager = mysqli_fetch_array($managers)){
								echo $manager['Primeiro_nome']." ".$manager["Ultimo_nome"]."<br>";	
							}
						?>
					</div>
				<?php 
				$teams = getTeams($tname);
				if(mysqli_num_rows($teams) !=0){	
					echo "<div>";
					echo "<form action=\"tournament-management2.php?tname=".$tname."\" method=\"post\">";
						echo "<br><select name=\"captains\">";
							echo "<option value=\"\" selected hidden>Promover capitão a gestor >></option>;";
							
							while($team = mysqli_fetch_array($teams)){
								$captain = getTeamCaptainInfo($team);
								echo "<option value=\"".$captain['CC']."\">"
										.$captain['Primeiro_nome']." ".$captain['Ultimo_nome']." - ".$team['Nome_equipa'].
									"</option>";
							}
						echo "</select>";
					echo "</div>";
					echo "<div>";
						echo "<br><input type=\"submit\" name =\"submit_manager\" value=\"Gravar\">";
					echo "</div>";
					echo "</form>";
				}
				?>
				</div>
			
                <?php
					$teams = getTeams($tname);
					if(mysqli_num_rows($teams) !=0){
						
						echo "<table style=\"width:65%\">";
						echo"<tr style=\"background: #afd2f0;\">";
						echo"<th>Equipas</th>";
						echo"<th>Capitão</th>";
						echo"<th></th>";
						echo"<th></th>";
						echo"<th>Estado</th>";
						echo"</tr>";
						
						while($team = mysqli_fetch_array($teams)){
							echo "<form action=\"tournament-management2.php?tname=".$tname."\" method=\"post\">";
							echo"<tr>";
							echo"<td>".$team['Nome_equipa']."</td>";

							$captain = getTeamCaptainInfo($team);

							echo"<td>".$captain[1]." ".$captain[2]."</td>";
							
							$team_players = getTeamPlayers($team['Nome_equipa']);
						
							echo "<td><select name=\"players\">";
							echo "<option value=\"\" selected hidden>Alterar capitão >></option>;";
							while($player = mysqli_fetch_array($team_players)){
								echo "<option value=\"".$player['CC']."\">"
										.$player['Primeiro_nome']." ".$player['Ultimo_nome'].
									"</option>";
							}
							echo"</select></td>";
							echo"<input type=\"hidden\" name=\"team\" id=\"hiddenField\" value=\"".$team['Nome_equipa']."\" />";
							echo"<td><input type=\"submit\" name =\"submit_captain\" value=\"Gravar\"></td>";
							
							if($team['Estado'] == 1){
								echo"<td style = \"color: rgb(0,200,0);\">Completa</td>";
							}else{
								echo"<td>Incompleta</td>";
							}
							echo"</tr>";
							echo "</form>";
						}
						echo "</table>";
					}
                ?>
                <?php
                    $state = getTournamentState($tname);
                    if($state == 1){
                        echo "<form action=\"tournament-management2.php?tname=".$tname."\" method=\"post\">";
                        echo "<div class=\"row\">";
                            echo "<div>";
                                echo "<h5>Nº de jogos entre pares de equipas:</h5>";
                                echo "<input type=\"number\" name=\"games\" min=\"1\" max=\"2\" style=\"background: none;\"><br><br>";
                                echo "<span class=\"error\">". $tournamentGamesErr ."</span>";                                
                            echo "</div>";
                            echo "<div>";
                            echo "</div>";
                            echo "<div>";
                                echo "<div style=\"text-align:right\">";
                                echo "<input type=\"submit\" name=\"submit_games\" value=\"Gerar Jogos\">";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "</form>";
                    }
                ?>
				<div style="text-align:left">
					<a href="tournament-management.php?tname=<?php echo $tname;?>"><input type="button" value="<- Voltar"></a>
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