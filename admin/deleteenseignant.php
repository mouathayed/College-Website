<?php
include "config.php";
//include "authentication.php";
$id = $_GET['email'];
if(isset($id)){
    $sql = "DELETE FROM utilisateur WHERE Email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $id);
    if ($stmt->execute()) {
        header("Location: enseignantadmin.php");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->errorInfo()[2];
    }
} else {
    echo 'error';
}
