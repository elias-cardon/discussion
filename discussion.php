<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "discussion");
if (isset($_SESSION['login'])) {
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

    if (isset($_POST['submitDiscussion'])) {
        $requeteid = "SELECT * FROM utilisateurs";
        $queryid = mysqli_query($link, $requeteid);
        $dataid = mysqli_fetch_all($queryid);
        $msg = $_POST['msg'];
        $id = $dataid[0][0];
        $msglength = strlen($msg);
        echo"test";
        if (!empty($_POST['msg']) and ($msglength <= 140)) {

            $date = date('Y-m-d');
            $insertMsg = "INSERT INTO messages (message, id_utilisateur, date) VALUES ('$msg', '$id','$date')";
            $insertMsg = mysqli_query($link, $insertMsg);
            header("Location: discussion.php");
            echo"test";
            
        } else {
            $message = 'Votre message est trop long 140 max !';
        
        }
    }
    if (isset($_SESSION["loginConnect"])) {
    }
?>
    <!DOCTYPE html>
    <html lang="fr">
    <style>
        thead {
            color: green;
        }

        tbody {
            color: blue;
        }

        tfoot {
            color: red;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        td,
        th {
            padding: 0.5rem;
        }
    </style>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="kalcss/index.css">
        <link rel="stylesheet" href="kalcss/main1.css">
        <link rel="stylesheet" href="kalcss/discussion1.css">
        <link rel="stylesheet" href="style.css">


        <title>Discussion</title>
        <script src="https://kit.fontawesome.com/22c6f4e36c.js" crossorigin="anonymous"></script>
    </head>

    <body>
            <header>
            <div id='header-wrapper'>
        <div id='header' class='container'>
            <div id='logo'>
                <h1><a href='index.php'>Masque</a></h1>
            </div>
            <div id='menu'>
                <ul>
                    <li><a href='index.php' title=''>Page d'accueil</a></li>
                    <li><a href='discussion.php'> Discussion</a></li>


                    <?php
                    if (isset($_SESSION['login'])) {
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
            </div>
        </div>
    </div>
        </header>
        <main>
            <section>
                <div class="container">
                    <h1>File de discussion</h1>
                    <?php
                    foreach ($data as $com) {
                    ?>
                        <div class="block-msg">
                            <div>
                                <p class="user">Utilisateur :<b class="username"><?php echo $com[5]; ?> </b></p>
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

                            <textarea cols="30" rows="10" placeholder="Entrer votre message" name="msg" value="" required></textarea>
                            <?php if (!empty($message)) : ?>
                                <p><?php echo $message; ?></p>
                            <?php endif; ?>
                            <button type="submit" name="submitDiscussion">Nouveau message</button>
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
    echo "Tu dois te connecté  " . " Retour <a href='connexion.php'>Connexion</a>";
}
?>