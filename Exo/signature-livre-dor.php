<?php
include_once "../bootstrap.php";
$mysqliObject = mysqli_connect($_ENV['DATABASE_HOST'] ?? "localhost", $_ENV['DATABASE_USER'] ?? "admin", $_ENV['DATABASE_PWD'] ?? "secret");
mysqli_select_db($mysqliObject, $_ENV['DATABASE_DBNAME'] ?? "dor");
$id = 0;
if (
    (isset($_POST['pseudo']) && isset($_POST['texte'])) &&
    (!empty($_POST['pseudo']) && !empty($_POST['texte']))
) {
    $pseudo = $_POST['pseudo'];
    $text = $_POST['texte'];
    $sql = "INSERT INTO livre(pseudo,texte,quand) VALUES('$pseudo', '$text', NOW())";
    mysqli_query($mysqliObject, $sql);
    $id = mysqli_insert_id($mysqliObject);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
    <link type="text/css" rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Signer le livre d'or</h1>
    <form method="post">
        <?php if($id) {?>
        <div class="alert alert-success" role="alert">
            Message enregistré avec succès dans le livre d'or.
        </div>
        <?php } ?>

        <div class="form-group">
        <label for="pseudo"> Pseudo : </label>
        <input class="form-control" type="text" name="pseudo" id="pseudo">
        </div>
        <br>
        <div class="form-group">
        <label for="text"> Texte : </label>
        <textarea class="form-control" name="texte" id="text" rows="5"></textarea>
        </div>
        <br/>
        <button class="btn btn-success" type="submit">Signer</button>
    </form>

    <?php
    $sql = "SELECT * FROM livre ORDER BY id DESC";
    $requete = mysqli_query($mysqliObject, $sql);
    echo "<hr>\n";
    while ($resultat = mysqli_fetch_array($requete)) {
        echo sprintf("%s a écrit le %s : <br/>", $resultat['pseudo'], $resultat['quand']);
        echo $resultat['texte'];
        echo "<hr>";
    }
    mysqli_close($mysqliObject);
    ?>
</div>
</body>
</html>