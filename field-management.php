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
	mysqli_report(MYSQLI_REPORT_STRICT);

	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0){
		throw new Exception(mysqli_connect_errno());
	} else{
		//echo "connected successfully";
	}

	function checkIfManager($user_id){
		global $connection;
		$query = sprintf(  "SELECT * FROM futebolamador.gestores_torneio 
							WHERE gestores_torneio.CC = '%s';", $user_id );

		$result = $connection->query($query);
		if(mysqli_num_rows($result) == 0){
			return false;
		}
		return true;
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
						<li><a href="tournament-management.php"><strong>Gestão de Torneios</a></strong></li>
						<li><a href="field-management.php"><strong style="color:#5c3ab7;">Gestão de Campos</a></strong></li>
						<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
				
				<img src="images/camp3.jpg" onerror = "this.src= 'images/camp1.jpg';" style="max-width:100%;">
				<h2>Campos de Futebol</h2>
				<table style="width:100%;">
				<tr style="background: #afd2f0;">
					<th>Nome</th>
					<th>Rua</th>
					<th>Numero</th>
					<th>Cidade</th>
					<th>Coordenadas</th>
					<th>Custo</th>
				</tr>
				<?php
					
					$query = "SELECT * FROM futebolamador.campos;";
					$result = $connection->query($query);
				
					while($row = mysqli_fetch_array($result)){
						echo "<tr>";
						echo "<td>" . $row['Nome_campo'] . "</td>";
						echo "<td>" . $row['Rua'] . "</td>";
						echo "<td>" . $row['Numero'] . "</td>";
						echo "<td>" . $row['Cidade'] . "</td>";
						echo "<td>" . $row['GPS'] . "</td>";
						echo "<td>" . $row['Custo'] . "</td>";
						echo "</tr>";
					}
					
				?>
				</table> 
				<?php
					if(checkIfManager($user_id)){
						$connection->close();
						echo "<a href=\"field-create.php\">";
							echo"<input type=\"button\" value =\"Adicionar Campo\"><br>";
						echo"</a><br>";
					}
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