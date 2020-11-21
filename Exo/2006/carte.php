<?php

include_once "../../bootstrap.php";

$identifiantImage = imagecreatefrompng("carte.png");
$identifiantColor = imagecolorallocate( $identifiantImage, 200, 10 , 10);
$identifiantColorText = imagecolorallocate( $identifiantImage, 90, 210 , 110);
$ville= isset($_GET['ville'])?$_GET['ville']: null;

try{
    $bdd = new PDO('mysql:host=localhost;dbname=geographie;charset=utf8', $_ENV['DATABASE_USER'] ??'prof', $_ENV['DATABASE_PWD'] ??'password');
}catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
//$sql= null==$ville ? 'SELECT * FROM villes' : "SELECT * FROM villes WHERE MATCH(nom) AGAINST('$ville')";
/**
 * ALTER TABLE villes ADD FULLTEXT(nom);
 */
$sql= null==$ville ? 'SELECT * FROM villes' : "SELECT * FROM villes WHERE nom LIKE '%$ville%'";
$reponse = $bdd->query($sql);
$nombreMaxHabitant=67848156;
$widthMax=510;
$heightMax=541;

while ($donnees = $reponse->fetch())
{
    $width=($donnees['habitants']/$nombreMaxHabitant)*$widthMax+5;
    imagefilledellipse($identifiantImage, $donnees['x'],$donnees['y'] , $width, $width ,$identifiantColor );
    imagestring($identifiantImage , 12, $donnees['x']+10, $donnees['y'] - 10, $donnees['nom'] ,$identifiantColorText);
}
$reponse->closeCursor();
header('Content-Type: image/png');
imagepng($identifiantImage);
?>
