<?php
// Declaration de l'en-tete http
header("Content-type: image/png");

$largeur = 400; // x Max
$hauteur = 300; //y max

$img = imageCreate($largeur, $hauteur);
$valeurs = array(5, 12, 8, 1, 2);

$jaune = imageColorAllocate($img, 255, 200, 0);
$barreCouleur  = imageColorAllocate($img,   255, 10,   0);