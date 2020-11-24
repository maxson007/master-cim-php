# Master CIM VCIEL 2006

## Exercice 1 : 

**Question 1** :	(2 points)
Décrivez les deux méthodes (GET et POST) du protocole HTTP, 
permettant de transmettre les données d’un formulaire à un script.
Quels sont les avantages et les inconvénients de ces modes de transmission ? 
Laquelle des deux méthodes préconisez-vous pour ce formulaire ? 
justifiez votre réponse.
 
**Décrivez les deux méthodes (GET et POST) du protocole HTTP, permettant de transmettre les données d’un formulaire à un script.**
> La méthode GET demande une représentation de la ressource spécifiée.
> Les requêtes GET doivent uniquement être utilisées afin de récupérer des données.

> La méthode POST est utilisée pour envoyer une entité vers la ressource indiquée.
> Cela  entraîne généralement un changement d'état ou des effets de bord sur le serveur.

### Quels sont les avantages et les inconvénients de ces modes de transmission ?
Source: https://www.ionos.fr/digitalguide/sites-internet/developpement-web/get-vs-post/
#### Methode GET
**Avantages :**

Les paramètres de l’URL peuvent être enregistrés avec l’adresse du site Web.
Cela permet de mettre une requête de recherche en marque-page et de la récupérer plus tard. 

**Inconvénients :**

Le principal inconvénient de la méthode GET est l’absence de protection des données.
Les paramètres URL envoyés sont non seulement visibles par tous dans la barre d’adresse du navigateur, 
mais sont également stockés sans chiffrement dans l’historique du navigateur, 
dans le cache et dans le fichier log du serveur.

Un deuxième inconvénient est sa capacité limitée : 
suivant le serveur Web et le navigateur, 
l’URL ne peut pas contenir plus de 2 000 caractères environ. 
De plus, les paramètres des URL ne peuvent contenir que des caractères ASCII (lettres, chiffres, caractères spéciaux, etc.), 
et non des données binaires telles que des fichiers audio ou des images.

#### Methode POST

**Avantages :**
Lorsqu’il s’agit de transmettre des données sensibles au serveur, 
par exemple un formulaire d’inscription avec nom d’utilisateur et mot de passe, 
la méthode POST permet de garder la confidentialité nécessaire. 
Les données ne sont pas mises en cache et n’apparaissent pas dans 
l’historique de navigation. 
La flexibilité est également de mise avec POST : 
non seulement des textes courts, mais aussi des données de toute taille 
et de tout type peuvent être transmis, comme des photos ou des vidéos.

**Inconvénients :**

Si une page Web est mise à jour avec un formulaire dans le navigateur 
(par exemple, en utilisant le bouton « Précédent » / « Retour »), l
es données du formulaire doivent être de nouveau soumises. 
Vous avez certainement déjà vu des avertissements qui s’y réfèrent. 
Il existe un risque que les données soient envoyées plusieurs fois par 
inadvertance, ce qui peut déclencher des commandes en double par exemple.

De même, les données transmises par la méthode POST ne peuvent pas 
être sauvegardées sous forme de marque-page avec l’URL.

#### Quand utiliser quelle méthode ?
**POST** est presque toujours favorisé lorsque l’utilisateur doit soumettre des données ou des fichiers au serveur, par exemple pour remplir des formulaires ou télécharger des photos.

**GET** est particulièrement bien adapté pour personnaliser les sites Web : les recherches des utilisateurs, les paramètres de filtrage et le tri des listes peuvent être mis en marque-page avec l’URL, de sorte qu’à la prochaine visite du site, l’utilisateur retrouvera la page telle qu’il l’a laissée.

Une simple « règle de base » pour finir :

* GET pour les paramètres d’un site Web (filtres, tri, saisies de recherche, etc.).
* POST pour la transmission des informations et des données de l’utilisateur.

### Laquelle des deux méthodes préconisez-vous pour ce formulaire ?

Pour le formulaire d'authentification il est préférable d'utiliser la 
methode POST. Ici le mot de passe est d'une donnée sensible , utiliser la methode
GET ne serait pas judicieux car le mot de passe apparaitra en claire dans l'url
du site web.
La methode POST permet de masquer le mot de passe lors de la soumission du formulaire au serveur web.
##
**Question 2 :** 	(2 points)
Donnez le code HTML de la page identification.html.

````html
<form method="post">
    <label for="identifiant">Identifiant: </label>
    <input type="text" name="identifiant" id="identifiant">
    <label for="motdepasse">Mot de passe: </label>
    <input type="password" name="motdepasse" id="motdepasse">
</form>
````
##
**Question 3 :**	(1 point)
Dans le fichier _verification.php_, écrire les quelques lignes permettant 
la définition de deux variables **$identifiant** et **$motdepasse**, 
dont les valeurs proviennent du formulaire. 
Prévoir le cas de figure où l’internaute accèderait au fichier 
_verification.php_ sans être passé par le formulaire.

```php
$identifiant = isset($_POST['identifiant']) ? $_POST['identifiant'] : null;
$motdepasse = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null;
```
### 
**Question 4 :**	(2 points)
Écrire le test permettant de vérifier que l’identifiant et
le mot de passe sont corrects et écrire les deux traitements 
correspondants : affichage du message de réussite ou 
ré-affichage du formulaire.

```php
$identifiant = isset($_POST['identifiant']) ? $_POST['identifiant'] : null;
$motdepasse = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : null;

if($identifiant==="vciel" && $motdepasse==="informatique"){
    echo "Identification réussie ";
}else{
    header('location: identification.html');
}
```
###

**Question 5 :**	(3 points)
L’authentification décrite dans cet exercice vous paraît-elle 
adaptée à la protection d’un ensemble de pages par 
un identifiant et un mot de passe ?
Décrivez les alternatives techniques permettant 
de ne pas avoir à se ré-authentifier à chaque page.

> L'authentification n'est pas adapter pour être utilisé dans plusieurs page.
> Une des alternatives consisterait à utiliser les sessions pour stocker les informations
> de l'utilisateur une fois l'authentification réussie. 

Example:
```php
...
if($identifiant==="vciel" && $motdepasse==="informatique"){
    //echo "Identification réussie ";
    $_SESSION['auth']=true;
    $_SESSION['identifiant']=$identifiant;
}else{
    header('location: identification.html');
}
```
 
> Une fois les informations stocker dans la session nous pouvons 
> les récupérer et les tester sur l'ensemble des pages qui requièrent une authentification.

Example: PageProtege.php
```php
...
if(!isset($_SESSION['auth']) || $_SESSION['auth']!=true){
    header('location: identification.html');
}
```