<?php
header("Content-type: image/png");

$heures = $_GET['heures']??0;
$minutes = $_GET['minutes']??0;
$secondes = $_GET['secondes']??0;

$r = 200;//rayon
$t = 400 ; //dimension d’image carrée à $t lignes et $t colonnes
$c= 200 ; //centre du cercle;

function coordonnees(float &$x,float &$y, int $cx, int $cy,float $r, float $fraction){
    $angle = $fraction * 2 * M_PI;
    $x = $cx + $r * sin($angle);
    $y = $cy - $r * cos($angle);
}

//instructions permettant de créer en mémoire une image
$img = imageCreate($t, $t);

//
$blanc = imageColorAllocate($img, 255, 255, 255);
$backgroundHorloge  = imageColorAllocate($img,   0, 250,   180);
$barreHorloge  = imageColorAllocate($img,   255, 50,   0);
$pourtourHorloge  = imageColorAllocate($img,   255, 50,   0);
$graduiationHorloge  = imageColorAllocate($img,   0, 0,   250);

//Dessine une ellipse centrée sur le point spécifié.
imagefilledellipse ($img , $c , $c , $r , $r , $backgroundHorloge);
imageellipse ($img , $c , $c , $r , $r , $pourtourHorloge);
imagefilledellipse ($img , $c , $c , 10 , 10 , $barreHorloge);

imagePNG($img);
imageDestroy($img);