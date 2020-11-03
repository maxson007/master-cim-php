<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
if(isset($_GET['couleur'])){
    echo "La couleur saisie est :".$_GET['couleur'];
}
?>
<table border="1">


    <?php
    $couleur = 000000;
    $k = 0;
    for ($i = 0; $i < 16; $i++) {
        echo "<tr>\n";
        for ($j = 0; $j < 16; $j++) {
            $couleur = dechex($j) . dechex($j) . dechex($i) . dechex($i) . dechex($k) . dechex($k);
            echo "<td BGCOLOR='" . $couleur . "'><a href=?couleur=$couleur style='text-decoration: none'> &nbsp;&nbsp;&nbsp;&nbsp; </a> </td> \n";
        }
        echo "</tr>\n";
    }
    ?>
</table>
</body>
</html>

