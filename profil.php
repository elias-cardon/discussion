<?php
session_start();

$link = mysqli_connect("localhost", "root", "", "discussion");

if (isset($_POST['submitLogout'])) {
    session_destroy();
    $_SESSION = array();
    header('Location: connexion.php');
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $message = '';
    $requete = "SELECT * FROM utilisateurs WHERE id = $id";
    $query = mysqli_query($link, $requete);
    $userinfo = mysqli_fetch_all($query);

    if (isset($_POST['editlogin']) and !empty($_POST['editlogin']) and $_POST['editlogin'] != $userinfo[0][1]) {
        $editlogin = htmlspecialchars($_POST['editlogin']);
        $insertLogin = "UPDATE utilisateurs SET login = '$editlogin' WHERE id = '$id'";
        $requete = mysqli_query($link, $insertLogin);
        header("Location: profil.php?id=" . $_SESSION['id']);
    }

    if (isset($_POST['editpassword1']) and !empty($_POST['editpassword1']) and isset($_POST['editpassword2']) and !empty($_POST['editpassword2'])) {

        $pass1 = $_POST['editpassword1'];
        $pass2 = $_POST['editpassword2'];
        if ($pass1 == $pass2) {
            $insertPass = "UPDATE utilisateurs SET password = '$pass1' WHERE id = '$id'";
            $requete = mysqli_query($link, $insertPass);
            header("Location: profil.php?id=" . $_SESSION['id']);
        } else {
            $messagePass = 'Vos mot de passe ne correspondent pas !';
        }
    }
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="src/css/main.css">
        <link rel="stylesheet" href="src/css/profil.css">
        <title>Profil</title>
        <script src="https://kit.fontawesome.com/22c6f4e36c.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <nav>
            <h1><a href="#">Masque</a></h1>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="discussion.php">Discussion</a></li>
                    <!-- <li><a href="profil.php">Profil</a></li> -->
                    <?php
                    if (isset($_SESSION['id'])) {
                    ?>
                        <li>

                            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" method="POST">
                                <button name="submitLogout" type="submit">Deconnexion</button>
                            </form>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <main>
            <section>
                <div class="container">
                    <h2>Bienvenue <?php
                                    echo $userinfo[0][1]
                                    ?> !</h2>

                    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" method="post" method="POST">

                        <label>Login : <?php echo $userinfo[0][1]; ?></label>
                        <input type="text" placeholder="Entrez votre nouveau login" name="editlogin">

                        <label>Password : <?php echo $userinfo[0][2]; ?></label>
                        <input type="password" placeholder="Entrez votre nouveau mot de passe" name="editpassword1">

                        <input type="password" placeholder="Répétez votre nouveau mot de passe" name="editpassword2">
                        <?php if (!empty($messagePass)) {  ?>
                            <p><?php echo $messagePass; ?></p>
                        <?php } ?>
                        <button name="submitedit" type="submit">Edit</button>

                    </form>
                </div>
            </section>


        </main>
        <footer>

        </footer>
    </body>
<?php
} else {
    header("Location: connexion.php");
}
?>