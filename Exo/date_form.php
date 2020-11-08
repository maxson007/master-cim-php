<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Choix d'une date</title></head>
<body>
<h1> Génération de Menus </h1>
<p>
    Pour la prochaine fois : http://eidolon.univ-lyon2.fr/~sergemiguet/vciel/2020/4-Dates/date.php <br/>
    Script qui génère un formulaire avec 3 meuns déroulants : jour / mois / année<br/>
    Générez chaque menu déroulant avec une boucle pour tous les jours, tous les mois et toutes les années<br/>
    Factorisez la génértion d'un menu déroulant dans une fonction unique, qui sera appelée trois fois : <br/> pour les jours, pour les mois, pour les années
    Avec des paramètres différents !
</p>
<?php
if(isset($_GET['envoyer'])){
echo "<h3>Vous avez choisi le ".$_GET['Jour']."/".$_GET['Mois']."/".$_GET['Année']."<h3/>";
}
?>
<form method="get">
    <?php
    dateSelectForm('d');
    dateSelectForm('m');
    dateSelectForm('Y');
    ?>
    <input type="submit" name="envoyer" value="OK">
</form>
<?php
/**
 * format value  'd' | 'm' | 'Y'
 * @param string $format
 *
 */
function dateSelectForm($format=''){
    $selected = '';
    $mois=range(1,12);
    $jour=range(01, 31);
    $annee=range(1992,date('Y'));
    if($format === 'd'){$context=$jour; $placeholder='Jour';}
    if($format === 'm'){$context=$mois; $placeholder='Mois';}
    if($format === 'Y'){$context=$annee;  $placeholder='Année';}

    echo '<select name="',$placeholder,'">',"\n";
    echo "\t",'<option value="', $placeholder,'"',  '>', $placeholder ,'</option>',"\n";
    foreach($context as $value)
    {
        if($value == date($format))
        {
            $selected = ' selected="selected"';
        }
        echo "\t",'<option value="', sprintf('%02d', $value) ,'"', $selected ,'>', sprintf('%02d', $value) ,'</option>',"\n";
        $selected='';
    }
    echo '</select>',"\n";

}
?>
</body>
</html>

