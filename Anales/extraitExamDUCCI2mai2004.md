#Extrait d’un examen du Ducci 2, Mai 2004

### 1- Code HTML du formulaire

```html
<form>
    <label for="pseudo"> Pseudo : </label>
    <input type="text" name="pseudo" id="pseudo">
    <br>
    <label for="text"> Texte : </label>
    <textarea name="pseudo" id="text" cols="10" rows="5"></textarea>
    <button type="submit">Signer</button>
</form>
```
Le fichier peut se nomme `signature-livre-dor.php`

Il faut le placer à la racine d'un serveur web apache

### 2. Expliquez ce que sont les champs de cette table.

```sql
CREATE TABLE livre ( 
pseudo varchar(20),
texte text,
quand date,
id int auto_increment not NULL,
primary key (id) );
```
 
Le champs `pseudo`  est une chaine de 20 carractères  au maximum. 
Il permet de stocker le pseudo de l'utilisateur qui a saissie un message dans le livre d'or.

Le champs `texte` est un chaine de caratère de type `text`. 
Le type _**text**_ permet de stocker de long texte jusqu' 2^16 caractères.

Le champs `quand`  est de type date. 
Il permet de stocker la date d'ecriture du message en base de donnée.

Le champs `id`  est la clé primaire.
Elle s'auto incremente pour avoir un identifiant unique pour chaque message dans le livre 

### 3. Rajoutez en début du fichier de la question 1 la section PHP permettant la connexion au serveur et la sélection de la base de données appropriée.
```php
<?php
mysql_connect("localhost", "admin", "secret");
mysql_select_db("dor");
?>
```
> `mysql_connect` Cette extension est obsolète depuis PHP 5.5.0
```php
<?php
$mysqliObject=mysqli_connect("localhost", "admin", "secret");
mysqli_select_db($mysqliObject,"dor");
?>
```

### 4. Rajoutez après l’affichage du formulaire la section PHP incluant la requête de consultation de la base de données et le parcours des enregistrements permettant l’affichage de l’ensemble des entrées du livre d’or (la plus récente en premier) sous la forme :
