<?php
session_start();
if (isset($_POST['submitLogout'])) {
    session_destroy();
    $_SESSION = array();
    header('Location: connexion.php');
}

if (isset($_SESSION["loginConnect"])) {
    echo "Tu es connecté en tant que " . "\"" . $_SESSION['loginConnect'] . "\"." . " Retour <a href=\"profil.php?id=" . $_SESSION['id'] . "\">Profil</a>";
} else {
    $link = mysqli_connect("localhost", "root", "", "discussion");

    if (isset($_POST['submit'])) {

        $pass = $_POST['password'];
        $pass1 = $_POST['password1'];
        $login = $_POST['login'];
        $requete = "SELECT * FROM utilisateurs where login ='$login' and password ='$pass'";
        $query = mysqli_query($link, $requete);

        $data = mysqli_fetch_all($query);
        $count = mysqli_num_rows($query);

        $sql_l = "SELECT * FROM utilisateurs WHERE login = '$login'";
        $sql_p = "SELECT * FROM utilisateurs WHERE password = '$pass'";

        $res_l = mysqli_query($link, $sql_l);
        $res_p = mysqli_query($link, $sql_p);
        $message = '';

        if (mysqli_num_rows($res_l) == 1) {
            $messageLogin = 'Votre login exist deja !';
        } elseif ($pass != $pass1) {
            $messagePass = 'Vos mot de passe ne correspondent pas !';
        } elseif ($pass == $pass1 and mysqli_num_rows($res_l) == 0) {
            $insertMbr = "INSERT INTO utilisateurs (login, password) VALUES ('$login', '$pass')";
            $query = mysqli_query($link, $insertMbr);
            header('Location: connexion.php');
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

        <title>Register</title>
        <script src="https://kit.fontawesome.com/22c6f4e36c.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <nav>
            <h1><a href="#">Masque</a></h1>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                    <li><a href="motdepass.html">Forget password ?</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section>
                <h2>Register</h2>
                <div class="container">
                    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" method="post" method="POST">
                        <div class="imgcontainer">
                            <i class="fas fa-user-circle avatar" alt="Avatar"></i>
                        </div>
                        <div class="block">
                            <?php if (!empty($messageLogin)) : ?>
                                <p><?php echo $messageLogin; ?></p>
                            <?php endif; ?>
                            <label for="uname"><b>Login*</b></label>
                            <input type="text" placeholder="Enter lgoin" name="login" value="<?php if (!empty($_POST['login'])) {
                                                                                                    echo htmlspecialchars($_POST['login'], ENT_QUOTES);
                                                                                                } ?>" required>

                            <label for="psw"><b>Password*</b></label>
                            <input type="password" placeholder="Enter Password" name="password" required>

                            <?php if (!empty($messagePass)) : ?>
                                <p><?php echo $messagePass; ?></p>
                            <?php endif; ?>
                            <label for="psw"><b>Comfirm Password*</b></label>
                            <input type="password" placeholder="Enter comfirm Password" name="password1" required>

                            <button type="submit" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <footer>

        </footer>
    </body>

    </html>

<?php
}
?>