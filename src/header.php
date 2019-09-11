<?php
/*
 * This file is part of the LKeyG API.
 *
 * (c) Kamel Bahmed
 */

header('Content-Type: application/json');
/* connextion PDO */
try{
  $pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=keygenerator', 'root', '');
  $return["success"]=true;
  $return["message"]="Connexion à la base de donnée réussie";
}catch(Exception $e){
  return_json(false,"Connexion à la base de donnée impossible");
}

/** this function is used to create a random key
 * @param string $nbCar the characters number in the key
 * @return string
 */
function keyG($nbCar) {
   $string = "";
   $chaine = "abcdefghijklmnpqrstuvwxyAZERTYUIOPQSDFGHJKLMWXCVBN123456789";
   for($i=0; $i<$nbCar; $i++) {
   $string .= $chaine[rand()%strlen($chaine)];
   }
   return $string;
   }

/** this function makes it possible to check if the name of the key already exists
 * @param string $keyName a key's name
 * @return string
 */
function verifieKeyName($keyName,$pdo){
  $req = $pdo->prepare("SELECT * FROM `keysgen` WHERE `key_name` LIKE '$keyName'");
  $req->execute();
  $nbResluts=count($req->fetchAll());
  if ($nbResluts>0)
  return true;
  return false;
}
?>
