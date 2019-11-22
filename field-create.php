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


$campname = $street = $number = $city = $gps = $cost = NULL;
$campnameErr = $streetErr = $cityErr = $costErr = "";
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $campname = test_input($_POST["campname"]);
    $street = test_input($_POST["street"]);
    $number = test_input($_POST["number"]);
    $city = test_input($_POST["city"]);
    $gps = test_input($_POST["gps"]);
    $cost = test_input($_POST["cost"]);

    if (empty($_POST["campname"])) {
        $campnameErr = "Nome do campo obrigatório.";
        $error = true;
    } 
    if (empty($_POST["street"])) {
        $streetErr = "Nome da rua obrigatório.";
        $error = true;
    } 
    if (empty($_POST["city"])) {
        $cityErr = "Nome da cidade obrigatório.";
        $error = true;
    } 
    if (empty($_POST["cost"])) {
        $costErr = "Definição de custo obrigatória.";
        $error = true;
    } 


    require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);// throw errors, not warnings

	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0){
		throw new Exception(mysqli_connect_errno());
	} else{
		echo "connected successfully";

        if(!$error){
            if($number == "" and $gps != ""){
                $query = sprintf("INSERT INTO futebolamador.campos (`Nome_campo`,`GPS`,`Rua`,`Cidade`,`Custo`)
                VALUES ('%s','%s','%s','%s','%s');", $campname, $gps, $street, $city, $cost);
            }
            else if($gps == "" and $number != ""){
                $query = sprintf("INSERT INTO futebolamador.campos (`Nome_campo`,`Rua`,`Numero`, `Cidade`,`Custo`)
                VALUES ('%s','%s','%s','%s','%s');", $campname, $street, $number, $city, $cost);
            }
            else if($gps == "" and $number == ""){
                $query = sprintf("INSERT INTO futebolamador.campos (`Nome_campo`,`Rua`,`Cidade`,`Custo`)
                VALUES ('%s','%s','%s','%s');", $campname, $street, $city, $cost);
            }
            else{
                $query = sprintf("INSERT INTO futebolamador.campos (`Nome_campo`,`GPS`,`Rua`,`Numero`,`Cidade`,`Custo`)
                VALUES ('%s','%s','%s','%s','%s','%s');", $campname, $gps, $street,$number,$city,$cost);
            }
            
            if ($connection->query($query) === TRUE) {
                echo "New record created successfully";
                header('Location: field-management.php');
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }
 
            /*
            $query = sprintf("UPDATE futebolamador.campos
                                SET `GPS` = '%s', `Numero` = '%s', 
                                WHERE futebolamador.campos.Nome_campo = '%s';",  , $campname);*/
         
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
						<li><a href="tournament-management.php"><strong>Gestão de Torneios</a></strong></li>
						<li><a href="field-management.php"><strong style="color:#5c3ab7;">Gestão de Campos</a></strong></li>
						<li><a href="tournament-list.php"><strong>Listar Torneios</a></strong></li>
					</ul>
				</section>
			</div>
			<div class="9u" style="padding-top: 30px; padding-right: 40px;">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div style = "width:60%;">
                        Nome do Campo:<br>
                        <input type="text" name="campname" value="<?php echo $campname;?>"><br>
                        <div><span class="error"><?php echo $campnameErr;?></span></div>
                        Rua: 
                        <input type="text" name="street" value="<?php echo $street;?>"><br>
                        <span class="error"><?php echo $streetErr;?></span>
                        <div class="row">
                            <div>
                                Numero:
                                <input type="text" name="number" value="<?php echo $number;?>">
                            </div>
                            <div>
                                Cidade:
                                <input type="text" name="city" value="<?php echo $city;?>">
                                <span class="error"><?php echo $cityErr;?></span>
                            </div>
                        </div><br>
                        
                    </div>
                    Coordenadas:<br>
                    <input type="text" name="gps" style = "width:40%" value="<?php echo $gps;?>"><br>
                    Custo(€):<br>
                    <input type="text" name="cost" style = "width:18%" value="<?php echo $cost;?>">
                    <span class="error"><?php echo $costErr;?></span><br><br>
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