<?php
require_once "connect.php";
$reponse = $bdd->query("
SELECT COUNT(*) as nb_lignes, COUNT(DISTINCT naf) as stat_naf, COUNT(DISTINCT siren) as stat_siren FROM sarbacane;
 ");
 while ($donnees = $reponse->fetch())
     {
        $stat_naf=$donnees["stat_naf"];
        $stat_siren=$donnees["stat_siren"];
        $nb_lignes=$donnees["nb_lignes"];
     }

?>
<H1>Résultats :</H1>
    <table>
    <tr>
    <th>Nom</th>
    <th>Prenom</th>
    <th>E-mail</th>
    <th>Société</th>
    <th>Adresse</th>
    <th>CP</th>
    <th>Ville</th>
    <th>SIREN &#x2726;</th>
    <th>NAF</th>
    <th>Téléphone</th>
    <th>Doublons</th>
    </tr>
    <?php 
  $reponse = $bdd->query("SELECT DISTINCT siren, count(*) as total FROM sarbacane GROUP BY siren");
 while ($donnees = $reponse->fetch())
     {
        $siren=$donnees["siren"];
        $total=$donnees["total"];
     
        $reponse2 = $bdd->query("SELECT * FROM sarbacane Where siren = $siren LIMIT 1");
        while ($donnees2 = $reponse2->fetch())
        {
            $nom=$donnees2["nom"];
            $prenom=$donnees2["prenom"];
            $email=$donnees2["email"];
            $societe=$donnees2["societe"];
            $adresse=$donnees2["adresse"];
            $cp=$donnees2["cp"];
            $ville=$donnees2["ville"];
            $naf=$donnees2["naf"];
            $tel=$donnees2["tel"];
            


    echo '<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$email.'</td><td>'.$societe.'</td><td>'.$adresse.'</td><td>'.$cp.'</td><td>'.$ville.'</td><td>'.$siren.'</td><td>'.$naf.'</td><td>'.$tel.'</td><td>'.$total.'</td></tr>';}  }
    ?>
</table>
   
<p><?php 
   if (isset($stat_naf)){
       echo'Il y a <strong>'.$stat_naf.' codes NAF</strong> uniques, <strong>'.$stat_siren.' SIREN</strong> uniques, pour un total de <strong>'.$nb_lignes.' entrées</strong> !';
   }
   ?> 
   (&#x2726; = SIREN uniques)</p>