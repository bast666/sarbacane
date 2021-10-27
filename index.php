<?php
require_once "connect.php";
$xml = simplexml_load_file('villecp.xml');

$erreurs = array(
    "nom" => "",
    "prenom" => "",
    "email" => "",
    "societe" => "",
    "adresse" => "",
    "cp" => "",
    "ville" => "",
    "siren" => "",
    "naf" => "",
    "tel" => ""
);

$nom = $prenom = $email = $societe =  $adresse = $cp = $ville = $siren = $naf = $tel= $test_nom = $test_prenom = $test_email = $test_societe = $test_adresse = $test_cp = $test_ville = $test_siren= $test_naf = $test_tel = "";

$message="<h1>Merci de remplir ce formulaire :</h1>";

if(isset($_GET['ajout']))
{
        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $societe = filter_var($_POST['societe'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $adresse = filter_var($_POST['adresse'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cp = filter_var($_POST['cp'],FILTER_SANITIZE_NUMBER_INT);
        $ville = filter_var($_POST['ville'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $siren = filter_var($_POST['siren'], FILTER_SANITIZE_NUMBER_INT);
        $naf = filter_var($_POST['naf'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tel = filter_var($_POST['tel'], FILTER_SANITIZE_NUMBER_INT);
 
        
        if(empty($nom))
    {$erreurs['nom']="Merci de saisir votre <strong>nom !</strong>";
        $test_nom ="NOK";
    }

    if(empty($prenom))
    {$erreurs['prenom']="Merci de saisir votre <strong>prénom !</strong>";
    $test_prenom ="NOK";
    }

    if(empty($email))
    {$erreurs['email']="Merci de saisir votre <strong>e-mail !</strong>";
    $test_email ="NOK";
    }
    else{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $test_email = "NOK";
            $erreurs['email']="Le format de l'e-mail est invalide !";
         }else{}
         if (preg_match("/!/", "$email")) {
            $test_email = "NOK";
            $erreurs['email'] = "Votre e-mail ne doit pas contenir de '!'";
          }
          if (preg_match("/%/", "$email")) {
            $test_email = "NOK";
            $erreurs['email'] .= " Votre e-mail ne doit pas contenir de '%'";
          }
          if (preg_match("/\?/", "$email")) {
            $test_email = "NOK";
            $erreurs['email'] .= " Votre e-mail ne doit pas contenir de '?'";
          }
          if (!preg_match("/@/", "$email")) {
            $test_email = "NOK";
            $erreurs['email'] .= " Il manque un '@'";
          }

          //etc...
    }

    if(empty($societe))
    {$erreurs['societe']="Merci de saisir votre <strong>société !</strong>";
    $test_societe ="NOK";
    }

    if(empty($adresse))
    {$erreurs['adresse']="Merci de saisir votre <strong>adresse !</strong>";
    $test_adresse ="NOK";
    }
    
    if(empty($cp))
    {$erreurs['cp']="Merci de saisir votre <strong>code postal !</strong>";
    $test_cp ="NOK";
    }

    if(empty($ville))
    {$erreurs['ville']="Merci de saisir votre <strong>ville !</strong>";
    $test_ville ="NOK";
    }

    if(empty($siren))
    {$erreurs['siren']="Merci de saisir votre <strong>Numéro de SIREN !</strong>";
    $test_siren ="NOK";
    }

    if(empty($naf))
    {$erreurs['naf']="Merci de saisir votre <strong>code NAF !</strong>";
    $test_naf ="NOK";
    }

    if(empty($tel))
    {$erreurs['tel']="Merci de saisir votre <strong>numéro de téléphone !</strong>";
    $test_tel ="NOK";
    }else{
        if (strlen("$tel") != 10) {
            $erreurs['tel']="Votre <strong>numéro de téléphone</strong> doit impérativement contenir 10 chiffres !";
            $test_tel ="NOK";
        }
        if (!preg_match("/^0/", "$tel")) {
            $erreurs['tel'] .= " Votre numéro doit commencer par un 0";
            $test_tel ="NOK";
          }
    }
        
        
        if($test_nom == "NOK" || $test_prenom == "NOK" || $test_email == "NOK" || $test_societe == "NOK" || $test_adresse == "NOK" || $test_cp == "NOK" || $test_ville == "NOK" || $test_siren == "NOK" || $test_naf == "NOK" || $test_tel == "NOK") {
          $message="<H1>Au moins un champ du formulaire est vide ou contient des erreurs :</H1>";
        }
          
       
        else{
            $req = $bdd->prepare('
            INSERT INTO sarbacane(nom, prenom, email, societe, adresse, cp, ville, siren, naf, tel) 
            VALUES(:nom, :prenom, :email, :societe, :adresse, :cp, :ville, :siren, :naf, :tel)');   
             
            $req->bindParam(':nom', $nom);
            $req->bindParam(':prenom', $prenom);
            $req->bindParam(':email', $email);
            $req->bindParam(':societe', $societe);
            $req->bindParam(':adresse', $adresse);
            $req->bindParam(':cp', $cp);
            $req->bindParam(':ville', $ville);
            $req->bindParam(':siren', $siren);
            $req->bindParam(':naf', $naf);
            $req->bindParam(':tel', $tel);
    
        $req->execute();

        $nom = $prenom = $email = $societe =  $adresse = $cp = $ville = $siren = $naf = $tel="";
        $message="<H1>Votre formulaire a bien été envoyé !</H1>";
          }
}

//include "debug.php";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="style.css" type="text/css" />
    <title>Test technique Sarbacane</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
	function API_CP(){
	var n = formulaire.cp.value;
  var api = 'https://apicarto.ign.fr/api/codes-postaux/communes/';
  var result = api+n;
	  
  $.getJSON(result, function(data) {
    var result2 = `${data.codePostal}`
    formulaire.ville.value = result2;
    }); 
}
//marche pas !!
</script>

</head>
<body>
<?= $message ?>
<form method="post" name="formulaire" action="?ajout">
<input type ="text" name="nom" placeholder="Nom" value="<?=$nom; ?>"> <?= $erreurs['nom'] ?><br>
<input type ="text" name="prenom"  placeholder="Prenom" value="<?=$prenom; ?>"> <?= $erreurs['prenom'] ?><br>
<input type ="text" name="email"  placeholder="E-mail" value="<?=$email; ?>"> <?= $erreurs['email'] ?><br>
<input type ="text" name="societe"  placeholder="Société" value="<?=$societe; ?>"> <?= $erreurs['societe'] ?><br>
<input type ="text" name="adresse"  placeholder="Adresse" value="<?=$adresse; ?>"> <?= $erreurs['adresse'] ?><br>
<input type ="text" name="cp"  placeholder="Code Postal" value="<?=$cp; ?>" onchange="API_CP()"> <?= $erreurs['cp'] ?><br>
<input type ="text" name="ville"  placeholder="Ville" value="<?=$ville; ?>"> <?= $erreurs['ville'] ?><br>
<input type ="text" name="siren"  placeholder="SIREN" value="<?=$siren; ?>"> <?= $erreurs['siren'] ?><br>
<input type ="text" name="naf"  placeholder="Code NAF" value="<?=$naf; ?>"> <?= $erreurs['naf'] ?><br>
<input type ="text" name="tel"  placeholder="Téléphone" value="<?=$tel; ?>"> <?= $erreurs['tel'] ?><br>
<br>
<input type="submit" value="Envoyer">
</form>
</body>
</html>