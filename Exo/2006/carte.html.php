<?php

include_once "../../bootstrap.php";
try {
    $bdd = new PDO('mysql:host=localhost;dbname=geographie;charset=utf8', $_ENV['DATABASE_USER'] ?? 'prof', $_ENV['DATABASE_PWD'] ?? 'password');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$ville= isset($_POST['ville'])?$_POST['ville']: null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>afficher carte</title>
    <link type="text/css" rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<header class="container">
    <h1>
        Carte
    </h1>
</header>
<div class="container">
    <div class="align-self-center mr-3">
    <form class="form-inline mr-auto" method="post" name="myform">
        <div class="form-group m-2">
            <label for="exampleFormControlSelect1" class="m-2">Choisir une ville: </label>
            <select class="form-control" id="exampleFormControlSelect1" name="ville" onchange='document.forms["myform"].submit();'>
                <option value="">Tous</option>
                <?php
                $sql = 'SELECT * FROM villes';
                $reponse = $bdd->query($sql);
                while ($donnees = $reponse->fetch()) {
                    $selected=$ville==$donnees['nom']? "selected": "";
                    echo "<option $selected  value='".$donnees['nom']."'>";
                    echo sprintf("%s - %s habitants", $donnees['nom'], $donnees['habitants']);
                    echo "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Valider</button>
    </form>
     <img src="carte.php?ville=<?php echo $ville?>" alt="ville">
    </div>
</div>
</body>
</html>