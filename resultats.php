<?php
require_once "connect.php";
$reponse = $bdd->query("
SELECT COUNT(DISTINCT naf) as stat_naf, nom, prenom FROM sarbacane;
 ");
 while ($donnees = $reponse->fetch())
     {
        $stat_naf=$donnees["stat_naf"];
     }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="style.css" type="text/css" />
    <title>Test technique Sarbacane</title>
</head>
<body><H1>Résultats :</H1>
    <table>
    <tr>
    <th>Nom</th>
    <th>Prenom</th>
    <th>E-mail</th>
    <th>Société</th>
    <th>Adresse</th>
    <th>CP</th>
    <th>Ville</th>
    <th>SIREN</th>
    <th>NAF</th>
    <th>Téléphone</th>
    </tr>
    <?php 
  $reponse = $bdd->query("
  
  SELECT nom, prenom, email, societe, adresse, cp, ville, siren, naf, tel FROM sarbacane GROUP BY siren;
 ");
 while ($donnees = $reponse->fetch())
     {
        $nom=$donnees["nom"];
        $prenom=$donnees["prenom"];
        $email=$donnees["email"];
        $societe=$donnees["societe"];
        $adresse=$donnees["adresse"];
        $cp=$donnees["cp"];
        $ville=$donnees["ville"];
        $siren=$donnees["siren"];
        $naf=$donnees["naf"];
        $tel=$donnees["tel"];

     
    echo '<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$email.'</td><td>'.$societe.'</td><td>'.$adresse.'</td><td>'.$cp.'</td><td>'.$ville.'</td><td>'.$siren.'</td><td>'.$naf.'</td><td>'.$tel.'</td></tr>';}  
    ?>
    </table>
   <?php 
   if (isset($stat_naf)){
       echo'Il y a '.$stat_naf.' codes NAF uniques !';
   }
   ?> 
</body>
</html>