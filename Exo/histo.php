<?php
// Declaration de l'en-tete http
header("Content-type: image/png");

// La taille de l image
$largeur = 400; // x Max
$hauteur = 300; //y max
//creation d'une image
$img = imageCreate($largeur, $hauteur);
$valeurs = array(5, 12, 8, 1, 2);

$rouge = imageColorAllocate($img, 255, 0, 0);
$barreCouleur  = imageColorAllocate($img,   255, 255,   0);
$barreLargeur=10; //largeur de la barre
$max = max ( $valeurs ); // valeur maximale du tableau

foreach ($valeurs as $index => $valeur) {
    $x = 10+(int)($barreLargeur*(0.5+$index*1.5)); // calcule de la position x
   $barreHauteur = (int)(($valeur*($hauteur-40))/$max); //calcule de la hauteur de la barre en pourcentage
    imageFilledRectangle($img, $x,
        $hauteur-15-$barreHauteur,
        $x+$barreLargeur,
        $hauteur-15,
        $barreCouleur);
}

imagePNG($img);
imageDestroy($img);
?>