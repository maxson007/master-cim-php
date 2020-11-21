# Master CIM VCIEL 2006
## Exercice 2 : 

### **Question 1 : (2 points)**
Dans le script **carte.php** chargé de la génération dynamique de l’image,
montrez comment lire en mémoire le fichier « carte.png » et allouer les
couleurs nécessaires à la suite de l’exercice.

```php
$identifiantImage = imagecreatefrompng("carte.png");
$identifiantColor = imagecolorallocate( $identifiantImage, 200, 10 , 10);
$identifiantColorText = imagecolorallocate( $identifiantImage, 90, 210 , 110);
```

### **Question 2 : (2 points)**
Détaillez les instructions permettant à l’utilisateur « prof » de se connecter à la
base de données « geographie » et d’émettre une requête de récupération
des informations sur les villes contenues dans la table « villes ».

#### Réponse
Les instructions à suivre pour se connecter à la base de donnée sont les suivantes :

```php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=geographie;charset=utf8', 'prof', 'password');
}catch (Exception $e)
{
 die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM villes');

while ($donnees = $reponse->fetch())
{
	echo $donnees['nom'] . '<br />';
}

$reponse->closeCursor();
```

### Question 3 : (2,5 points)
Montrez comment s’écrit le parcours des villes de la table, et comment
générer la représentation sur la carte de la ville courante. La surface de la
pastille doit être proportionnelle au nombre d’habitants de la ville, et le nom
de la ville doit être légèrement décalé du centre de la pastille.

```php
<?php
$reponse = $bdd->query('SELECT * FROM villes');
$nombreMaxHabitant=67848156;
$widthMax=510;
$heightMax=541;
while ($donnees = $reponse->fetch())
{
    echo $donnees['nom'] . '-';
    echo $donnees['x'] . '-';
    echo $donnees['y'] . '-';
    echo $donnees['habitants'] . '<br />';
    $width=($donnees['habitants']/$nombreMaxHabitant)*$widthMax+5;
    imagefilledellipse($identifiantImage, $donnees['x'],$donnees['y'] , $width, $width ,$identifiantColor );
    imagestring($identifiantImage , 12, $donnees['x']+10, $donnees['y'] - 10, $donnees['nom'] ,$identifiantColorText);
}
imagepng($identifiantImage,"carte2.png");

$reponse->closeCursor();
?>
```

### Question 4 : (1,5 points)
Donnez finalement le code de la génération de l’en-tête HTTP, et de l’image
elle-même. Comment cette image, générée dynamiquement par le script
carte.php doit-elle être incluse dans une page web (donnez le code HTML de
l’inclusion) ?

```php
header("Content-type: image/png"); //l’en-tête HTTP,
imagepng($identifiantImage); //on ne precise pas de fichier de sortie
```
Code html
```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Afficher carte</title>
</head>
<body>
    <img src="carte.php">
</body>
</html>
```

### Question 5 : (2 points)
Imaginez une application où la requête ne serait plus « statique », en
affichant toutes les villes de la table, mais « dynamique », pour n’afficher que
les villes répondant à un certain critère (donnez un exemple). Comment le
script carte.php doit-il être modifié ?

#### Réponse
Nous pouvons imaginer que le script `carte.php` reçoit le non de la ville
en paramètre et l'affiche sur la carte. Ainsi le critère choisit sera le 'nom' et nous 
 utiliserons la methode http 'GET'.
 
 Nous devons donc ajouter l'instruction suivante :
```php
$ville= isset($_GET['ville'])?$_GET['ville']: null;
```

La requête SQL

```php
$sql = null==$ville ? 'SELECT * FROM villes' : "SELECT * FROM villes WHERE nom LIKE '%$ville%'";
```

