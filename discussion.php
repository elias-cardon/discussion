<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "discussion");
if (isset($_SESSION['id'])) {
    $date = '%d/%m/%Y';
    $requete = "SELECT messages.*, utilisateurs.*, DATE_FORMAT(date, '$date') as new_date
                        FROM messages 
                        INNER JOIN utilisateurs ON messages.id_utilisateur = utilisateurs.id
                        ORDER BY messages.id";

    $query = mysqli_query($link, $requete);
    $data = mysqli_fetch_all($query);
    if (isset($_POST['submitLogout'])) {
        session_destroy();
        $_SESSION = array();
        header('Location: connexion.php');
    }

    if (isset($_POST['submit'])) {
        $msg = $_POST['msg'];
        $id = $_SESSION['id'];
        $msglength = strlen($msg);
        if (!empty($_POST['msg']) and ($msglength <= 140)) {
            $date = date('Y-m-d');
            $insertMsg = "INSERT INTO messages (message, id_utilisateur, date) VALUES ('$msg', '$id','$date')";
            $insertMsg = mysqli_query($link, $insertMsg);
            header("Location: discussion.php");
        } else {
            $message = 'Votre message est trop long. 140 caractères maximum !';
        }
    }
    if (isset($_SESSION["loginConnect"])) {
    }
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="src/css/main.css">
        <link rel="stylesheet" href="src/css/discussion.css">

        <title>Discussion</title>
        <script src="https://kit.fontawesome.com/22c6f4e36c.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <nav>
            <h1><a href="#">Masque</a></h1>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="discussion.php">Discussion</a></li>
                    <li><a href="profil.php">Profil</a></li>
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
                    <h1>Fil de discussion</h1>
                    <?php
                    foreach ($data as $com) {
                    ?>
                        <div class="block-msg">
                            <div>
                                <p class="user">Utilisateur : <b class="username"><?php echo $com[5]; ?> </b></p>
                                <p class="date">Date : <?php echo $com[7]; ?></p>
                            </div>
                            <div>
                                <p>Message:</p>
                                <p><?php echo $com[1]; ?></p>
                            </div>

                        </div>
                    <?php
                    }
                    ?>
            </section>
            <section>
                <h2>Ecrire un commentaire</h2>
                <div class="container">
                    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" method="post" method="POST">
                        <div class="block">

                            <label for="ucom"><b>Commentaire*</b></label> <br> <br>
                            <textarea cols="30" rows="10" placeholder="Entrer votre message" name="msg" value="" required></textarea>
                            <?php if (!empty($message)) : ?>
                                <p><?php echo $message; ?></p>
                            <?php endif; ?>
                            <button type="submit" name="submit">Nouveau message</button>
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
} else {
    echo "Tu dois te connecter." . " <a href='connexion.php'>Connexion</a>";
}
?>