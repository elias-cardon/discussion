<?php
session_start();
if(isset($_POST['submit']))
{
	$login = htmlentities(trim($_POST['login']));
	$prenom = htmlentities(trim($_POST['prenom']));
	$nom = htmlentities(trim($_POST['nom']));
	$password = htmlentities(trim($_POST['password']));
	$repeatpassword = htmlentities(trim($_POST['repeatpassword']));

	if($login && $prenom && $nom && $password && $repeatpassword)
	{
		if($password == $repeatpassword)
		{
			$db = mysqli_connect('localhost', 'root', '') or die('Erreur');
			mysqli_select_db($db, 'discussion');

			$query = mysqli_query($db, "INSERT INTO utilisateurs (login, prenom, nom, password) VALUES('$login', '$prenom', '$nom', '$password');");

			die("Inscription terminée. <a href='connexion.php'>Connectez-vous</a>.");
		}
		else
		{
			echo "Les mots de passes doivent être identiques";
		}
	}
	else
	{
		echo "Veuillez saisir tous les champs";
	}
}
?>




<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inscription</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<link href="fontawesome-templategit.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<body class="color">
		<!-- Header -->
		<div id="header-wrapper">
			<div id="header" class="container">
				<div id="logo">
					<h1><a href="#">Masque</a></h1>
				</div>
				<div id="menu">
					<ul>
						<li><a href="index.php" accesskey="1" title="">Page d'accueil</a></li>
						<!-- <li><a href="inscription.php" accesskey="2" title="">Inscription</a></li> -->
						<li><a href="connexion.php" accesskey="3" title="">Connexion</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Main -->
		<main>
			<h1>Inscription</h1><br/>
				<form method="post" action="inscription.php">
        			<p>Login</p>
        			<input class="input" type="text" name="login">
        			<p>Mot de passe</p>
        			<input class="input" type="password" name="password">
        			<input class="input" type="submit" name="submit" value="Valider">
				</form>
		</main>
		<!-- Footer -->
<!-- 			<footer id="footer">
				<div class="inner">
					<ul class="icons">
						<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon brands fa-github"><span class="label">Github</span></a></li>
						<li><a href="#" class="icon brands fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
					</ul>
				</div>
			</footer> -->

		<!-- Scripts -->
<!-- 			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script> -->
	</body> 
</html>

<?php
echo '<style>
h1
{
	text-align : center;
	text-decoration : underline;
}

p
{
	text-align : center;
	color : white;
}

.input
{
	display:block;
	margin:auto;
}

body
{
	background-image: linear-gradient(#03224c, #77b5fe);
	background-repeat : no-repeat;
}
</style>';
?>