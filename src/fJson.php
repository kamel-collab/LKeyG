<?php
/*
 * This file is part of the LKeyG API.
 *
 * (c) Kamel Bahmed
 */

include 'header.php';

/* if user chooses generate operation */
if(!empty($_POST["generate"])){
  // if key's name already exist
  if(verifieKeyName($_POST["generate"], $pdo)){
    $return["success"]=false;
    $return["message"]="key's name already exist";
  }else{
    // else generate a key
    $cle = keyG(20);
    $req = $pdo->prepare("INSERT  INTO `keysgen` (`id`, `key_name`, `key_code`) VALUES (NULL,:key_name, '$cle');" );
    $req->bindParam(':key_name', $_POST["generate"]);
    $req->execute();

    $req = $pdo->prepare("SELECT * FROM `keysgen` WHERE `key_name` LIKE :key_name");
    $req->bindParam(':key_name', $_POST["generate"]);
    $req->execute();

    $return["success"]=true;
    $return["message"]="clé généré";
    $return["results"]["keys"] = $req->fetchAll();
  }
}elseif(!empty($_POST["delete"])){
/* else if user chooses delete operation */
  $req = $pdo->prepare("DELETE FROM `keysgen` WHERE `keysgen`.`key_name` = :key_name ");
  $req->bindParam(':key_name', $_POST["delete"]);
  $req->execute();

  $return["success"]=true;
  $return["message"]="clé supprimé";
}else {
  /* else show all keys*/
  $req = $pdo->prepare("SELECT * FROM `keysgen` ");
  $req->execute();

  $return["success"]=true;
  $return["message"]="voici les clés";
  $return["results"]["keys"] = $req->fetchAll();
}

echo json_encode($return);
?>
