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
    $firstnameErr = $lastnameErr = $usernameErr = $emailErr = $phoneErr = "";
    $error = false;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

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

    $firstname = $user['Primeiro_nome'];
    $lastname = $user['Ultimo_nome'];
    $username = $user['Username'];
    $email = $user['Email'];
    $phone = $user['Telemovel'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $firstname = test_input($_POST["firstname"]);
        $lastname = test_input($_POST["lastname"]);
        $username = test_input($_POST["username"]);
        $email = test_input($_POST["email"]);
        $phone = test_input($_POST["phone"]);

        if (empty($_POST["firstname"])) {
            $firstnameErr = "Primeiro nome obrigatório.";
            $error = true;
        } 
        if (empty($_POST["lastname"])) {
            $lastnameErr = "Ultimo nome obrigatório.";
            $error = true;
        } 
        if (empty($_POST["username"])) {
            $usernameErr = "Username obrigatório.";
            $error = true;
        } 
        if (empty($_POST["email"])) {
            $emailErr = "Email obrigatório.";
            $error = true;
        } 
        if (empty($_POST["phone"])) {
            $phoneErr = "Numero de telefone obrigatório.";
            $error = true;
        } 
        
        if(!$error){
        
            $query = sprintf("  UPDATE futebolamador.utilizadores 
                                SET utilizadores.Primeiro_nome = '%s', utilizadores.Ultimo_nome = '%s', 
                                    utilizadores.Username = '%s', utilizadores.Email = '%s', 
                                    utilizadores.Telemovel = '%s'
                                WHERE utilizadores.CC = '%s';", $firstname, $lastname, $username, $email, $phone, $user_id);

            if ($connection->query($query) === TRUE) {
                echo "Updated user successfully";
                header('Location: user-profile.php');
                $connection->close();
            } else {
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
				<h2>Editar Perfil</h2>
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
                    <div><br></div>
                    <div><br></div>
					<div style="width: 400px;">
                        <form action="user-profile-edit.php" method="post">
                            Primeiro nome:
                            <input type="text" name="firstname" value="<?php echo $firstname;?>">
                            <span class="error"><?php echo $firstnameErr;?></span><br>
                            
                            Ultimo nome: 
                            <input type="text" name="lastname" value="<?php echo $lastname;?>">
                            <span class="error"><?php echo $lastnameErr;?></span><br>
                            
                            Username:
                            <input type="text" name="username" value="<?php echo $username;?>">
                            <span class="error"><?php echo $usernameErr;?></span><br>
                              
                            Email:
                            <input type="email" name="email" value="<?php echo $email;?>">
                            <span class="error"><?php echo $emailErr;?></span><br>
                   
                            Telemovel:<br>
                            <input type="text" name="phone" value="<?php echo $phone;?>">
                            <span class="error"><?php echo $phoneErr;?></span><br><br>
                            <div style="text-align:center">
                            <div style="display:inline-flex;">
                                <a href="user-profile.php"><input type="button"  style="background-color: rgb(170,170,170);" value="Cancelar"></a><br>
                                <input type="submit" value="Gravar"><br>
                            </div>
                            </div>
                        </form>
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