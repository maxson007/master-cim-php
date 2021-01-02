<?php
define("HEURES",12);
define("MINUTES",60);
define("SECONDES",60);
function generate_form_select($name,$numberItem){
    echo "<select name='$name'>";
    for($i=0;$i<$numberItem;$i++){
        echo "<option value='$i'>$i</option>";
    }
   echo "</select>";
}
?>
<h1>Quel heure voulez-vous afficher ?</h1>
<form method="get" action="horloge.php">
    <label>Heures</label>
    <?php generate_form_select('heures', HEURES)?>

    <label>Minutes</label>
    <?php generate_form_select('minutes', MINUTES)?>

    <label>Secondes</label>
    <?php generate_form_select('secondes', SECONDES)?>

    <button type="submit">OK</button>
</form>
