<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservo</title>
</head>
<body> 

<?php

$serveur = "localhost";
$utilisateur = "btssio";
$motDePasse = "btssio";
$nomBaseDeDonnees = "JeunesseSolidaire";

try {
    //Connexion avec PDO à la base de données

        $connexion = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees", $utilisateur, $motDePasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Récupération des informations depuis la base de donnée

        $prix_total = 0;

    //Récupération des prix des équipements

        $sql_equ = "SELECT prix FROM equipements;";
        $stmt_equ = $connexion->query($sql_equ);
        $prixEquipements = $stmt_equ->fetchAll(PDO::FETCH_COLUMN);

    //Récupération des prix des salles

        $sql_sa = "SELECT prix FROM salles;";
        $stmt_sa = $connexion->query($sql_sa);
        $prixSalles = $stmt_sa->fetchAll(PDO::FETCH_COLUMN);

    //Récupération des prix des services

        $sql_ser = "SELECT prix FROM services;";
        $stmt_ser = $connexion->query($sql_ser);
        $prixServices = $stmt_ser->fetchAll(PDO::FETCH_COLUMN);

        // Prix des salles

        $prix_salle_preau = $prixSalles[0];
        $prix_salle_terrain = $prixSalles[1];
        $prix_salle_15 = $prixSalles[2];
        $prix_salle_centre_culturelle_1 = $prixSalles[3];
        $prix_salle_centre_culturelle_2 = $prixSalles[4];

    //Prix des equipements

        $prix_equipement_table = $prixEquipements[0];
        $prix_equipement_chaise = $prixEquipements[1];
        $prix_equipement_haut_parleur = $prixEquipements[2];
        $prix_equipement_micro = $prixEquipements[3];
        $prix_equipement_chapteau_1 = $prixEquipements[4];
        $prix_equipement_chapteau_2 = $prixEquipements[5];
        $prix_equipement_chapteau_3 = $prixEquipements[6];

    //Prix des options

        $prix_options_mise_en_place = $prixServices[0];
        $prix_options_nettoyage = $prixServices[1];


    //Création d'un nouvel utilisateur

        $nom = $_POST['nom'];
        $pnom = $_POST['pnom'];
        $tel = $_POST['tel'];
        $mail = $_POST['mail'];

        $newUsers = "INSERT INTO users(nom, pnom, phone, mail) VALUES('$nom', '$pnom', '$tel', '$mail');";
        $stmtUsers = $connexion->prepare($newUsers);
        $stmtUsers->execute();

    //Création d'une nouvelle réservation

        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];

        $date_d = $date_debut . ' ' . $heure_debut . ':00';
        $date_f = $date_fin . ' ' . $heure_fin . ':00';

        $preau = $_POST['Préau'];

        if ($preau == 'on') {
            $preau = 1;
        } else {
            $preau = 0;
        }

        $terrain = $_POST['Terrain'];

        if ($terrain == 'on') {
            $terrain = 1;
        } else {
            $terrain = 0;
        }

        $salle_15 = $_POST['Salle_15'];

        if ($salle_15 == 'on') {
            $salle_15 = 1;
        } else {
            $salle_15 = 0;
        }

        $cc1 = $_POST['Centre_culturel_1'];

        if ($cc1 == 'on') {
            $cc1 = 1;
        } else {
            $cc1 = 0;
        }

        $cc2 = $_POST['Centre_culturel_2'];

        if ($cc2 == 'on') {
            $cc2 = 1;
        } else {
            $cc2 = 0;
        }

        $table = $_POST['Table'];
        $chaise = $_POST['Chaise'];
        $haut_parleurs = $_POST['Haut-parleur'];
        $micro = $_POST['Microphone'];
        $chapiteau_3x3 = $_POST['Chapiteau_3x3m'];
        $chapiteau_3x4 = $_POST['Chapiteau_3x4m'];
        $chapiteau_3x6 = $_POST['Chapiteau_3x6m'];

        $setup = $_POST['Setup'];

        if ($setup == 'on') {
            $setup = 1;
        } else {
            $setup = 0;
        }
        
        $cleaning = $_POST['Cleaning'];

        if ($cleaning == 'on') {
            $cleaning = 1;
        } else {
            $cleaning = 0;
        }

        $prix_total = $prix_total + $prix_salle_preau * $preau;
        $prix_total = $prix_total + $prix_salle_terrain * $terrain;
        $prix_total = $prix_total + $prix_salle_15 * $salle_15;
        $prix_total = $prix_total + $prix_salle_centre_culturelle_1 * $cc1;
        $prix_total = $prix_total + $prix_salle_preau * $cc2;
        $prix_total = $prix_total + $prix_equipement_chaise * $chaise;
        $prix_total = $prix_total + $prix_equipement_table * $table;
        $prix_total = $prix_total + $prix_equipement_haut_parleur * $haut_parleurs;
        $prix_total = $prix_total + $prix_equipement_micro * $micro;
        $prix_total = $prix_total + $prix_equipement_chapteau_1 * $chapiteau_3x3;
        $prix_total = $prix_total + $prix_equipement_chapteau_2 * $chapiteau_3x4;
        $prix_total = $prix_total + $prix_equipement_chapteau_3 * $chapiteau_3x6;
        $prix_total = $prix_total + $prix_options_mise_en_place * $setup;
        $prix_total = $prix_total + $prix_options_nettoyage * $cleaning;
        
        $newRes = "INSERT INTO reservations(date_d, date_f, préau, terrain, salle_15, cc1, cc2, chaises, tables, haut_parleurs, micro, chapiteau_3x3, chapiteau_3x4, chapiteau_3x6, setup, cleaning, prix_total) VALUES('$date_d', '$date_f', '$preau', '$terrain', '$salle_15', '$cc1', '$cc2', '$table', '$chaise', '$haut_parleurs', '$micro', '$chapiteau_3x3', '$chapiteau_3x4', '$chapiteau_3x6', '$setup', '$cleaning', '$prix_total');";
        $stmtRes = $connexion->prepare($newRes);
        $stmtRes->execute();

    
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion à la base de données

    $connexion = null;

?>

    <div class="forandtable">
    <div class="Tableau">
        <div class="Salle">
            <table>
                <tr>
                  <th>Salles</th>
                  <th>Tarifs</th>
                </tr>
                <tr>
                  <td>Préau <br> <img src="https://www.akena.com/sites/default/files/styles/phablet/public/2023-04/akena-produit-preau-2021-saint-urbain-019.jpg?itok=VY-9k7lc" height="200px" alt=""></td>
                  <td><?php echo $prix_salle_preau ?>€</td>
                </tr>
                <tr>
                    <td>Terrain <img src="https://www.insep.fr/sites/default/files/styles/768x430/public/2019-10/installsportive-footsynthetique-2-web_0.jpg?itok=3nnwAjrd" height="200px" alt=""></td>
                    <td><?php echo $prix_salle_terrain ?>€</td>
                </tr>
                <tr>
                    <td>Salle 15 <br> <img src="https://www.tresboeuf.fr/medias/sites/21/2019/10/salle-JBC.jpg" height="200px" alt=""></td>
                    <td><?php echo $prix_salle_15 ?>€</td>
                </tr>
                <tr>
                    <td>Centre culturel 1 <br> <img src="https://previews.123rf.com/images/ismagilov/ismagilov1709/ismagilov170901600/87045223-r%C3%A9ception-de-r%C3%A9ception-en-bois-blanc-et-en-bois-est-dans-un-bureau-avec-des-murs-de-bord-et-des.jpg" height="200px" alt=""</td>
                    <td><?php echo $prix_salle_centre_culturelle_1 ?>€</td>
                </tr>
                <tr>
                    <td>Centre culturel 2 <br> <img src="https://www.stfv.fr/img/location/04-salle-vide.jpg" height="200px" alt=""> </td>
                    <td><?php echo $prix_salle_centre_culturelle_2 ?>€</td>
                </tr>
            </table> 
        </div>
    
        <div class="Equipements">
            <table>
                <tr>
                  <th>Equipements</th>
                  <th>Tarifs</th>
                </tr>
                <tr>
                  <td>Tables <img src="https://www.gosto.com/12118-home_default/table-modulaire-rectangulaire-l160xp80cm.jpg" height="200px" width="200px" alt="Image de table"></td>
                  <td><?php echo $prix_equipement_table ?>€</td>
                </tr>
                <tr>
                    <td>Chaises <img src="https://www.axess-industries.com/mobilier-pour-les-etablissements-secondaires/chaise-scolaire-avec-4-pieds-tube-best-seller-p-400016-450x450.png" height="200px" width="200px" alt="Image de chaise"/></td>
                    <td><?php echo $prix_equipement_chaise ?>€</td>
                </tr>
                <tr>
                    <td>Haut parleurs <img src="https://m.media-amazon.com/images/I/717fcOPpXhL.jpg" height="200px" width="200px" alt="Image de haut-parleurs"></td>
                    <td><?php echo $prix_equipement_haut_parleur ?>€</td>
                </tr>
                <tr>
                    <td>Microphones <img src="https://www.wowevent.fr/wp-content/uploads/2018/03/Micro-1-1030x1030.jpg" height="200px" width="200px" alt="Image de microphone"></td>
                    <td><?php echo $prix_equipement_micro ?>€</td>
                </tr>
                <tr>
                    <td>Chapiteau (3x3m, 3x4m, 3x6m) <img src="https://www.semio.fr/69102-large_default/chapiteau-de-reception-pyramide.jpg" height="200px" width="200px" alt="Image de chapiteau"></td>
                    <td><?php echo "Les prix varient entre " .  $prix_equipement_chapteau_1 . "€ et " . $prix_equipement_chapteau_3 . "€ selon les dimensions"  ?></td>
            </table> 
        </div>

        <div class="Services">
            <table>
                <tr>
                  <th>Services</th>
                  <th>Tarifs</th>
                </tr>
                <tr>
                  <td>Option de mise en place</td>
                  <td><?php echo $prix_options_mise_en_place ?>€</td>
                </tr>
                <tr>
                    <td>Option de nettoyage</td>
                    <td><?php echo $prix_options_nettoyage ?>€</td>
                </tr>
            </table> 
        </div>
    </div>

    <div class="Formulaire">
        <form action="" method="post">
        <h1>Coordonnées</h1>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" placeholder="Veuillez entrer votre nom"><br>
            <label for="pnom">Prénom:</label>
            <input type="text" name="pnom" placeholder="Veuillez entrer votre prénom"><br>
            <label for="tel">Numéro de téléphone:</label>
            <input type="tel" name="tel" placeholder="Veuillez entrer votre numéro de téléphone"><br>
            <label for="mail">Adresse e-mail:</label>
            <input type="email" name="mail" placeholder="Veuillez entrer votre adresse e-mail">

        <h1>Infos sur la réservation</h1>
            Je réserve le
            <input type="date" name="date_debut"> à partir de
            <input type="time" name="heure_debut"> jusqu'au  
            <input type="date" name="date_fin"> à
            <input type="time" name="heure_fin">

        <h1>Salle(s) souhaitée(s)</h1>
            <label for="Préau">Préau</label>
            <input type="checkbox" name="Préau" id="" >
            <label for="Terrain">Terrain</label>
            <input type="checkbox" name="Terrain" id="">
            <label for="Salle 15">Salle 15</label>
            <input type="checkbox" name="Salle_15" id="">
            <label for="Centre culturel 1">Centre culturel 1</label>
            <input type="checkbox" name="Centre_culturel_1" id="">
            <label for="Centre culturel 2">Centre culturel 2</label>
            <input type="checkbox" name="Centre_culturel_2" id="">

        <h1>Equipement(s)</h1>
            <label for="Table">Table</label>
            <input type="number" name="Table" id="Table" value="0" max="100" min="0"><br>
            <label for="Chaise">Chaise</label>
            <input type="number" name="Chaise" id="Chaise" value="0" max="100" min="0"><br>
            <label for="Haut-parleur">Haut-parleur</label>
            <input type="number" name="Haut-parleur" id="Haut-parleur" value="0" max="100" min="0"><br>
            <label for="Microphone">Microphone</label>
            <input type="number" name="Microphone" id="Microphone" value="0" max="100" min="0"><br>
            <label for="Chapiteau 3x3m">Chapiteau 3x3m</label>
            <input type="number" name="Chapiteau_3x3m" id="Chapiteau 3x3m" value="0" max="100" min="0"><br>
            <label for="Chapiteau 3x4m">Chapiteau 3x4m</label>
            <input type="number" name="Chapiteau_3x4m" id="Chapiteau 3x4m" value="0" max="100" min="0"><br>
            <label for="Chapiteau 3x6m">Chapiteau 3x6m</label>
            <input type="number" name="Chapiteau_3x6m" id="Chapiteau 3x6m" value="0" max="100" min="0"><br>

        <h1>Service(s)</h1>
            <label for="Setup">Option de mise en place</label>
            <input type="checkbox" name="Setup" id="" >
            <label for="Cleanning">Option de nettoyage</label>
            <input type="checkbox" name="Cleanning" id="">
            <br><br>

        <h2>Prix total : <?php echo $prix_total ?>€</h2>
            <input type="submit" value="Réserver">
        </form>
        
    </div>
    </div>

    <a href="https://policies.google.com/terms?hl=fr">Mentions légales</a>

    <style>
        table, th, tr, td{
            border: solid 2px;
            
        }
        th, tr, td{
            padding: 5px;
        }
        .Tableau{
            width: 983px;
            display: flex;
        }
        table{
            margin: 3px;
        }
        .forandtable{
            display: flex;
        }
        .Formulaire{
            margin-left: 100px;
        }
        .Formulaire input{

        }
    </style>


</body>
</html>