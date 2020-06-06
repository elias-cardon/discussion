<?php
session_start();
if (isset($_SESSION["loginConnect"])) {
    echo "Tu es connecté en tant que " . "\"" . $_SESSION['loginConnect'] . "\"." . " Retour <a href=\"profil.php?id=" . $_SESSION['id'] . "\">Profil</a>";
} else {
    $link = mysqli_connect("localhost", "root", "", "discussion");

    $requete = "SELECT * FROM utilisateurs";
    $query = mysqli_query($link, $requete);
    $userinfo = mysqli_fetch_all($query);

    if (isset($_POST['submitConnect'])) {
        $login = htmlspecialchars($_POST['loginConnect']);
        $pass = htmlspecialchars($_POST['passwordConnect']);

        $requete = "SELECT * FROM utilisateurs where login ='$login' and password ='$pass'";
        $query = mysqli_query($link, $requete);
        $count = mysqli_num_rows($query);

        $sql_l = "SELECT * FROM utilisateurs WHERE login='$login'";
        $sql_p = "SELECT * FROM utilisateurs WHERE password='$pass'";
        $res_l = mysqli_query($link, $sql_l);
        $res_p = mysqli_query($link, $sql_p);
        $message = '';

        // Le login est-il rempli ?
        if (empty($login)) {
            $message = 'Veuillez indiquer votre login svp !';
        }
        // Le mot de passe est-il rempli ?
        elseif (empty($pass)) {
            $message = 'Veuillez indiquer votre mot de passe svp !';
        }
        // Le login est-il correct ?
        elseif (mysqli_num_rows($res_l) == 0) {
            $message = 'Votre login n\'existe pas !';
        }
        // Le mot de passe est-il correct ?
        else {
            $message = 'Votre mot de passe est incorrect !';
        }

        if ($login == 'admin' || $login == 'Admin' && $pass == 'admin') {
            $_SESSION['id'] = $userinfo[0][0];
            $_SESSION['loginConnect'] = $userinfo[0][1];
            header('Location: admin.php');
        }
        // L'identification a réussi
        if ($count == 1 and $login != 'admin') {
            $requete = "SELECT * FROM utilisateurs where login ='$login' and password ='$pass'";
            $userinfo = mysqli_fetch_all($query);
            $_SESSION['id'] = $userinfo[0][0];
            $_SESSION['loginConnect'] = $userinfo[0][1];
            header("Location: profil.php?id=" . $_SESSION['id']);
        }
    }

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="src/css/index.css">
        <link rel="stylesheet" href="src/css/main.css">
        <link rel="stylesheet" href="src/css/connexion.css">

        <title>Connexion</title>
        <script src="https://kit.fontawesome.com/22c6f4e36c.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <nav>
                <h1><a href="#">Masque</a></h1>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="discussion.php">Discussion</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
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
                    <h2>Connexion</h2>
                    <div class="test">
                        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" method="POST">
                            <div class="block">
                                <?php if (!empty($message)) : ?>
                                    <p><?php echo $message; ?></p>
                                <?php endif; ?>
                                <label for="login"><b>Login*</b></label>
                                <input type="text" placeholder="Entrer login" name="loginConnect" id="login" value="<?php if (!empty($_POST['login'])) {
                                                                                                                        echo htmlspecialchars($_POST['login'], ENT_QUOTES);
                                                                                                                    } ?>" required />
                                <label for="psw"><b>Mot de passe*</b></label>
                                <input type="password" placeholder="Entrer le mot de passe" name="passwordConnect" id="psw" required>

                                <button name="submitConnect" type="submit">Connexion</button>
                                <span class="psw">Vous n'êtes pas inscrit ? <a href="inscription.php"> Inscrivez vous.</a></span>
                            </div>
                        </form>
                    </div>

                </div>
            </section>


        </main>
        <footer>

        </footer>
    </body>

<?php
}
?>