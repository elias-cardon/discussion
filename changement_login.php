<?php
session_start();
if (isset($_SESSION['login'])) {
	$username = $_SESSION['login'];
	if (isset($_POST['submit'])) {
		$login = $_POST['login'];
		$newlogin = $_POST['newlogin'];
		$repeatnewlogin = $_POST['repeatnewlogin'];
		if ($login && $newlogin && $repeatnewlogin) {
			if ($newlogin == $repeatnewlogin) {
				$db = mysqli_connect('localhost', 'root', '') or die('Erreur');
				mysqli_select_db($db, 'discussion');
				$query = mysqli_query($db, "SELECT * FROM utilisateurs WHERE login = '$username' AND login = '$login'");
				$rows = mysqli_num_rows($query);
				if ($rows==1) {
					$newpass = mysqli_query($db, "UPDATE utilisateurs SET login='$newlogin' WHERE login='$username'");
					die("Votre login a bien été modifié. Vous pouvez vous <a href='connexion.php'>connecter</a>.");
				}
				else
				{
					echo "Votre ancien login est incorrect";
				}
			}
			else
				{echo "Les deux champs doivent être identiques";}
		
		}
		else
		{
			echo "Veuillez saisir tous les champs";
		}
	}


echo '<form method="POST" action="changement_login.php">
<p>Votre ancien login</p>
<input class="input" type="text" name="login"<br/>
<p>Votre nouveau login</p>
<input class="input" type="text" name="newlogin">
<p>Répétez votre nouveau login</p>
<input class="input" type="text" name="repeatnewlogin"><br/><br/>
<input class="input" type="submit" value="Changer de login" name="submit"</input>
</form>
	';
}
else
{
	header("Location:connexion.php");
}
?>

<?php
echo '<style>
h1
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
	color : black;
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