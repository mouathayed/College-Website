<?php
include "config.php";
//include "authentication.php";
$id = $_GET['email'];
if(isset($id)){
    $sql ="DELETE FROM utilisateur WHERE Email=:email";
    $sql2="delete FROM note where Id_user=(select Id_user from utilisateur where Email=:email) ";
    $stmt = $pdo->prepare($sql);
    $stmt2 = $pdo->prepare($sql2);
    $stmt->bindParam(':email', $id, PDO::PARAM_STR);
    $stmt2->bindParam(':email', $id, PDO::PARAM_STR);
    if ($stmt->execute()) {
        header("Location: etudiantadmin.php");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->errorInfo()[2];
    }
} else {
    echo 'error';
}
