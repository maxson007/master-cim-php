# Master « Visualisation et Conception Infographiques en ligne » (VCIEL)
Mardi 22 mai 2007
### 1.	Donnez le code HTML de ce formulaire, et justifiez la méthode employée pour transmettre les données du formulaire au script de la page 1.

```html
<h1>Accès au site protégé</h1>
<form> 
    <label> Identifiant:</label> 
    <input type="text" name="identifiant"/>
    <label> Identifiant:</label> 
    <input type="password" name="motdepasse"/>
</form>

```

### 2.	Justifiez la nécessité d’inclure les tests d’authentification dans chacune des n pages à protéger, alors que le formulaire dirige l’internaute sur la page 1 uniquement.

Même si le formulaire d'authentification redirige les utilisateurs vers la page 1,
Il est nécessaire d'inclure les tests d'authentification dans les tous pages 
car les internautes peuvent avoir accès aux autres pages grace à leurs url.

### 3.	Quelle est l’instruction PHP qu’il faut utiliser pour démarrer une session ? rappelez le principe de fonctionnement des sessions.
l’instruction PHP qu’il faut utiliser pour démarrer une session est : 
`session_start();`

Fonctionnement des sessions PHP: 
https://www.php.net/manual/fr/session.examples.basic.php
> Les sessions sont un moyen simple de stocker des données individuelles pour chaque utilisateur en utilisant un identifiant de session unique. Elles peuvent être utilisées pour faire persister des informations entre plusieurs pages. Les identifiants de session sont normalement envoyés au navigateur via des cookies de session, et l'identifiant est utilisé pour récupérer les données existantes de la session. L'absence d'un identifiant ou d'un cookie de session indique à PHP de créer une nouvelle session, et génère ainsi un nouvel identifiant de session

> Les sessions suivent une cinématique simple. Lorsqu'une session est démarrée, PHP va soit récupérer une session existante en utilisant l'identifiant de session passé (habituellement depuis un cookie de session) ou si aucun identifiant de session n'est passé, il va créer une nouvelle session. PHP va ainsi peupler la variable superglobale $_SESSION avec toutes les données de session une fois la session démarrée. Lorsque PHP s'arrête, il va prendre automatiquement le contenu de la variable superglobale $_SESSION, le linéariser, et l'envoyer pour stockage au gestionnaire de sauvegarde de session.

### 4.	Donnez les instructions qui permettent de définir les variables PHP $id et $passe correspondant au contenu que l’utilisateur a saisi dans le formulaire d’identification (on prendra soin de vérifier que l’utilisateur est passé par un formulaire pour arriver sur la page courante).

```php
<?php
$id=isset($_POST['identifiant']) ? $_POST['identifiant'] : null
$passe=isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null

if(null === $id || null === $passe){ 
  header('Location: id.html');
  exit();
}
?>
```

### 5.	Donnez les instructions permettant de mémoriser ces deux variables dans la session courante.

```php
session_start();
$_SESSION['id'] = $id;
$_SESSION['passe'] = $passe;
```

### 6.	Donnez la portion de code permettant de rediriger l’utilisateur vers la page « id.html » si le couple identifiant / mot de passe n’est pas correct.
```php
define("USER", "user");
define("PASSWORD", "password");
if(PASSWORD !== $id || USER !== $passe){ 
  header('Location: id.html');
  exit();
}
```

### 7.	Donnez l’instruction SQL permettant de créer la table « logins » 
(ou alternativement, décrivez la procédure que vous utiliseriez sous phpMyAdmin
 pour créer cette table).

```sql
CREATE TABLE logins (
identifiant VARCHAR(8) PRIMARY KEY NOT NULL,
mot_de_passe VARCHAR(8) NOT NULL,
nombre_page_visite INTEGER,
);
```

### 8.	Donnez les instructions PHP à inclure dans le fichier « auth.php » permettant de récupérer dans la table « logins » le triplet (identifiant, mot de passe, pages visitées) correspondant à l’utilisateur mémorisé dans la session.

```php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=acces ;charset=utf8', 'user', 'password');
}catch (Exception $e)
{
 die('Erreur : ' . $e->getMessage());
}
//  Récupération de l'utilisateur
$req = $bdd->prepare('SELECT identifiant, mot_de_passe, nombre_page_visite FROM membres WHERE identifiant = :identifiant AND mot_de_passe: :mot_de_passe');
$req->execute(array(
    'identifiant' => $id,
    'mot_de_passe' => $passe
));
//fetch result 
$resultat = $req->fetch();
//teste 
if ($resultat)
{
    session_start();
    $_SESSION['id'] = $resultat['identifiant'];
    $_SESSION['passe'] = $resultat['mot_de_passe'];
    $_SESSION['nombre_page_visite'] = $resultat['nombre_page_visite'];
    echo 'Vous êtes connecté !';

}else {
  header('Location: id.html');
  exit();
}
```

### 9.	Réécrivez la réponse à la question 6 en distinguant les deux cas de figure : identifiant inconnu, ou mot de passe incorrect. Comment peut-on modifier le fichier « id.html » pour inclure le message d’erreur approprié avant de re-demander à l’utilisateur de s’identifier ?

```php
//  Récupération de l'utilisateur
$req = $bdd->prepare('SELECT identifiant, mot_de_passe, nombre_page_visite FROM logins  WHERE identifiant = :identifiant');
$req->execute(array(
    'identifiant' => $id,
));
//fetch result 
$resultat = $req->fetch();
//teste 
if ($resultat)
{
   if($resultat['mot_de_passe']===$passe){
        session_start();
        $_SESSION['id'] = $resultat['identifiant'];
        $_SESSION['passe'] = $resultat['mot_de_passe'];
        $_SESSION['nombre_page_visite'] = $resultat['nombre_page_visite'];
        $message= 'Vous êtes connecté';
    }else{
        $erreur = 'Le mot de passe est incorrecte';
        header('Location: id.html?erreur='.$erreur);
        exit();
    }

}else {
  $erreur= 'L\'identifiant est incorrecte';
  header('Location: id.html?erreur='.$erreur);
  exit();
}
```
#### Modification du fichier « id.html » pour inclure le message d’erreur approprié
Il faudra dans un premier temps changer l'extension du fichier de `.html` a `.php`
En suite récupérer les messages d'erreur via la methode http `GET `

Exemple : 

````php
<?php
$erreur = isset($_GET['erreur']) ? $_GET['erreur'] : null
?>
<h1>Accès au site protégé</h1>
<?php 
 if($erreur){
    echo "<h2 style="color:red">$erreur</h2>"
}
?>
<form> 
    <label> Identifiant:</label> 
    <input type="text" name="identifiant"/>
    <label> Identifiant:</label> 
    <input type="password" name="motdepasse"/>
</form>

````

### 10.	En cas d’authentification correcte, inclure les instructions permettant d’incrémenter dans la table, le nombre de pages visitées par cet utilisateur.


```php

$nombrePageVisite = (int)$resultat['nombre_page_visite'];
//requette bddd
$req = $bdd->prepare('UPDATE logins SET nombre_page_visite = :nombre_page_visite WHERE identifiant = :identifiant');

$req->execute(array(
    'nombre_page_visite' => $nombrePageVisite+1,
    'identifiant' => $resultat['identifiant'],
	));

```

### 11.	En utilisant la bibliothèque GD, concevez un script permettant de présenter sous la forme d’un histogramme (cf ci-contre), les différents utilisateurs du site, et le nombre de pages visitées par ces utilisateurs sur le site.