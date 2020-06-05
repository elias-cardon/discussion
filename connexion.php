<?php
session_start();
if (isset($_POST['submit'])) {
	$login = $_POST['login'];
	$password = $_POST['password'];
	if ($login && $password) {
		$db = mysqli_connect('localhost', 'root', '');
		mysqli_select_db($db, 'discussion');

		$query = mysqli_query($db, "SELECT * FROM utilisateurs WHERE login='$login' && password='$password'");
		$rows = mysqli_num_rows($query);
		if ($rows==1) {
			$_SESSION['login'] = $login;
			header('Location:profil.php');
		}

		if ($login == 'admin'|| $login == 'admin' && $password == 'admin') { 
			header('Location:admin.php');
		}
		
		else
		{
			echo "Login ou password incorrect";
		}
	}

	else
	{
		echo "Veuillez saisir tous les champs.";
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Connexion</title>
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
							<li><a href="inscription.php" accesskey="2" title="">Inscription</a></li>
						</ul>
					</div>
				</div>
			</div>
		<!-- Main -->
		<main>
			<h1 id="connexion">Connexion</h1>
				<form method="post" action="connexion.php">
        			<p>Login</p>
        			<input class="input" type="text" name="login">
        			<p>Mot de passe</p>
        			<input class="input" type="password" name="password"><br/><br/>
        			<input class="input" type="submit" name="submit" value="Valider"><br/>
				</form>
		</main>
	</body> 
</html>

<?php
echo '<style>
#connexion
{
	text-align : center;
	font-family: "Source Sans Pro", Helvetica, sans-serif;
	text-decoration : underline;
}
p
{
	text-align : center;
	font-family: "Source Sans Pro", Helvetica, sans-serif;
	font-size: 16pt;
	font-weight: 400;
	line-height: 1.75em;
}

.input
{
	display:block;
	margin:auto;
}

body
{
	background-image: linear-gradient(#03224c, #77b5fe);
}
</style>';
?>