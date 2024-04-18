<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <?php

$serveur = "localhost";
$utilisateur = "btssio";
$motDePasse = "btssio";
$nomBaseDeDonnees = "JeunesseSolidaire";

try {

        $connexion = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees", $utilisateur, $motDePasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        $nom = $_POST['nom'];
        $pnom = $_POST['pnom'];
        $tel = $_POST['tel'];
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];
        $link = 'index.php';
        
        $newUsers = "INSERT INTO users(nom, pnom, phone, mail, pwd) VALUES('$nom', '$pnom', '$tel', '$mail', '$mdp');";
        $stmtUsers = $connexion->prepare($newUsers);
        $stmtUsers->execute();

    } catch(PDOException $e) {
        $error = $e->getMessage();
        if ($error == "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '" . $mail . "' for key 'mail'") {
            echo "Cette adresse existe deja dans notre base de données";
            $link = '';
        } else {
            $link = 'index.php';
        }
        
    }

        

?>

    
</head>
<body>
    <form action="<?php echo $link ?>" method="post">
    <label for="nom">Nom:</label>
            <input type="text" name="nom" placeholder="Veuillez entrer votre nom"><br>
            <label for="pnom">Prénom:</label>
            <input type="text" name="pnom" placeholder="Veuillez entrer votre prénom"><br>
            <label for="tel">Numéro de téléphone:</label>
            <input type="tel" name="tel" placeholder="Veuillez entrer votre numéro de téléphone"><br>
            <label for="mail">Adresse e-mail:</label>
            <input type="email" name="mail" placeholder="Veuillez entrer votre adresse e-mail"> <br>
            <label for="mdp">Mot de passe:</label>
            <input type="password" name="mdp" placeholder="Veuillez entrer votre mot de passe">
            <input type="submit" value="Validez">
    </form>
</body>
</html>