<?php
include "config.php";
$id = $_GET['id'];
$usql ="DELETE FROM etudiant WHERE id_etudiant=:id";
$usql2 ="DELETE FROM note WHERE id_etudiant=:id";
$uquery = $pdo->prepare($usql);
$uquery2= $pdo->prepare($usql2);
if (!($uquery && $uquery2)) {
    echo "error";
}
$uquery->execute(['id' => $id]);
if($uquery){
    header('location:index.php');
}else{
    header('location:index.php');
}
