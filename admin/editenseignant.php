<?php
include "config.php";
include "authentication.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['email'];
    $newnom = $_POST['value1'];
    $newprenom = $_POST['value2'];
    $newmail = $_POST['value3'];
    $newcode = $_POST['value4'];


    $sql = "UPDATE utilisateur SET Nom=:newnom, Prénom=:newprenom, Email=:newmail, Mdp=:newcode, User_role='enseignant' WHERE Email=:mail";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':newnom', $newnom);
    $stmt->bindParam(':newprenom', $newprenom);
    $stmt->bindParam(':newmail', $newmail);
    $stmt->bindParam(':newcode', $newcode);
    $stmt->bindParam(':mail', $mail);

    if ($stmt->execute()) {
        header("Location: enseignantadmin.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->errorInfo();
    }
}
