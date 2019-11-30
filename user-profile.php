<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">

<?php
    $user_id = 11111111;
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings

    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection->connect_errno != 0){
        throw new Exception(mysqli_connect_errno());
    } else{
        //echo "connected successfully";
    }
    $query = sprintf(  "SELECT * FROM futebolamador.utilizadores 
                        WHERE utilizadores.CC = '%s';", $user_id  );

    $result_user = $connection->query($query);
    $user = mysqli_fetch_array($result_user);

    function getTeamsPlayer($user_id){
        global $connection;
        $query = sprintf("  SELECT equipas_jogadores.Nome_equipa, equipas.Nome_torneio 
                            FROM futebolamador.equipas_jogadores 
                            Join futebolamador.equipas on equipas.Nome_equipa = equipas_jogadores.Nome_equipa 
                            WHERE equipas_jogadores.CC = '%s';", $user_id );
        
        $result = $connection->query($query);
        return $result;
    }

    function getTeamsCaptain($user_id){
        global $connection;
        $query = sprintf("  SELECT equipas.Nome_equipa, equipas.Nome_torneio FROM futebolamador.equipas 
                            WHERE equipas.CC = '%s';", $user_id );

        $result = $connection->query($query);
        return $result;
    }

    function getManagedTournaments($user_id){
        global $connection;
        $query = sprintf("  SELECT gestores_torneio_torneios.Nome_torneio FROM futebolamador.gestores_torneio_torneios 
                            WHERE gestores_torneio_torneios.CC = '%s';", $user_id );

        $result = $connection->query($query);
        return $result;
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
							  <img src="images/player.jpg" onerror = "this.src= 'images/usr.png';" style="width:auto;height:50px; border-radius:25%;">
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
						<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
				<h2>Perfil</h2>
                <div class="row">
                    <div>
                        <img src="images/player_girl2.jpg" onerror = "this.src= 'images/user.png';" style="height:360px;max-width:100%; border:solid 10px #3cadd4; border-radius:1%;"><br><br>
                        <div style="text-align: center;">
                            <?php 
                                if($user['Admin'] == 1){
                                    $admin = "[ Administrador ]";
                                }
                                echo "<h4>".$user['Primeiro_nome']. " " . $user['Ultimo_nome']."</h4>";
                                echo $admin;
                            ?>
                        </div>
                    </div>
					<div>
                        <strong>Username: </strong><?php echo $user['Username']?><br><br>
                        <strong>Email: </strong><?php echo $user['Email']?><br><br>
                        <strong>Telemovel: </strong><?php echo $user['Telemovel']?>
					</div>
                    <div><br></div>
                    <div><br></div>
                    <div>
                    <?php 
                        $teams = getTeamsPlayer($user_id);
                        if(mysqli_num_rows($teams) !=0){
                            echo "<h4>Jogador nas equipas:</h4>";
                            echo"<table style=\"width:250px;\">";
                            echo"<tr style=\"background: #afd2f0;\">";
                            echo"<th>Equipa</th>";
                            echo"<th>Torneio</th>";
                            echo"<th></th>";
                            echo"</tr>";
                            
                            while($team = mysqli_fetch_array($teams)){
                                echo"<tr>";
                                echo"<td>".$team['Nome_equipa']."</td>";
                                echo"<td>".$team['Nome_torneio']."</td>";
                                echo"<td></td>";
                                echo"</tr>";
                            }
                            echo "</table>";
                        }
                        $teams = getTeamsCaptain($user_id);
                        if(mysqli_num_rows($teams) !=0){
                            echo "<h4>Capitão nas equipas:</h4>";
                            echo "<table style=\"width:250px;\">";
                            echo"<tr style=\"background: #afd2f0;\">";
                            echo"<th>Equipa</th>";
                            echo"<th>Torneio</th>";
                            echo"<th></th>";
                            echo"</tr>";
                            
                            while($team = mysqli_fetch_array($teams)){
                                echo"<tr>";
                                echo"<td>".$team['Nome_equipa']."</td>";
                                echo"<td>".$team['Nome_torneio']."</td>";
                                echo"<td></td>";
                                echo"</tr>";
                            }
                            echo "</table>";
                        }
                        $tournaments = getManagedTournaments($user_id);
                        if(mysqli_num_rows($tournaments) !=0){
                            echo "<h4>Gestor das equipas:</h4>";
                            echo "<table style=\"width:250px;\">";
                            echo"<tr style=\"background: #afd2f0;\">";
                            echo"<th>Torneio</th>";
                            echo"<th>Estado</th>";
                            echo"<th></th>";
                            echo"</tr>";
                            
                            while($tournament = mysqli_fetch_array($tournaments)){
                                $state = getTournamentState($tournament['Nome_torneio']);
                                echo"<tr>";
                                echo"<td>".$tournament['Nome_torneio']."</td>";
                                if($state == 2){
                                    echo"<td>A decorrer</td>";
                                }
                                else if($state == 1){
                                    echo"<td>Pronto a Iniciar</td>";
                                }
                                else{
                                    echo"<td>Não pronto</td>";
                                }
                                echo"<td></td>";
                                echo"</tr>";
                            }
                            echo "</table>";
                        }
                        ?>
                    </div>
				</div>
                <div style="text-align:right">
                    <a href="user-profile-edit.php"><input type="submit" value="Editar perfil ->"></a>
                </div>
				<br>
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