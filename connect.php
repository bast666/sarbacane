<?php 
try
{
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=localhost;dbname=adf', 'root', '', $pdo_options);
	$bdd->exec("SET CHARACTER SET utf8");
}

catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
?>