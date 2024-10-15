<?php
include "config.php";
$id = $_GET['id'];
$usql ="DELETE FROM etudiant WHERE id_etudiant=:id";
$uquery = $pdo->prepare($usql);
if (!$uquery) {
    // handle error
}
$uquery->execute(['id' => $id]);
if($uquery){
    header('location:index.php');
}else{
    header('location:index.php');
}

